<?php

declare(strict_types=1);

namespace App\Modules\Tag\Infrastructure\Doctrine\Repositories;

use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Tag\Domain\Entities\Tag;
use App\Modules\Tag\Domain\Exceptions\InvalidTagNameException;
use App\Modules\Tag\Domain\Repositories\ITagRepository;
use App\Modules\Tag\Domain\ValueObjects\TagName;
use App\Modules\Tag\Infrastructure\Doctrine\Entities\TagEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TagEntity>
 */
class SqlTagRepository extends ServiceEntityRepository implements ITagRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagEntity::class);
    }

    /**
     * @throws InvalidTagNameException
     */
    public function findById(TagId $id): ?Tag
    {
        $entity = $this->findOneBy([
            'id' => $id->getValue(),
            'deletedAt' => null
        ]);

        return $entity ? $this->toDomain($entity) : null;
    }

    /**
     * @throws InvalidTagNameException
     */
    public function findAll(): array
    {
        $entities = $this->findBy(
            ['deletedAt' => null],
            ['name' => 'ASC']
        );

        return array_map(fn(TagEntity $entity) => $this->toDomain($entity), $entities);
    }

    public function save(Tag $tag): void
    {
        $entity = $this->find($tag->getId()->getValue());

        if ($entity === null) {
            $entity = $this->toInfrastructure($tag);
            $this->getEntityManager()->persist($entity);
        } else {
            $this->updateEntity($entity, $tag);
        }

        $this->getEntityManager()->flush();
    }

    public function delete(TagId $id): void
    {
        $entity = $this->find($id->getValue());

        if ($entity !== null) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws InvalidTagNameException
     */
    private function toDomain(TagEntity $entity): Tag
    {
        return new Tag(
            id: new TagId($entity->getId()),
            name: new TagName($entity->getName()),
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt(),
            deletedAt: $entity->getDeletedAt()
        );
    }

    private function toInfrastructure(Tag $tag): TagEntity
    {
        return new TagEntity(
            id: $tag->getId()->getValue(),
            name: $tag->getName()->getValue(),
            createdAt: $tag->getCreatedAt(),
            updatedAt: $tag->getUpdatedAt(),
            deletedAt: $tag->getDeletedAt()
        );
    }

    private function updateEntity(TagEntity $entity, Tag $tag): void
    {
        $entity->setName($tag->getName()->getValue());
        $entity->setUpdatedAt($tag->getUpdatedAt());
        $entity->setDeletedAt($tag->getDeletedAt());
    }
}
