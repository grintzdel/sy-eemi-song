<?php

declare(strict_types=1);

namespace App\Modules\Album\Infrastructure\Doctrine\Repositories;

use App\Modules\Album\Domain\Entities\Album;
use App\Modules\Album\Domain\Exceptions\InvalidAlbumNameException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Album\Domain\ValueObjects\AlbumName;
use App\Modules\Album\Infrastructure\Doctrine\Entities\AlbumEntity;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Song\Domain\ValueObjects\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AlbumEntity>
 */
class SqlAlbumRepository extends ServiceEntityRepository implements IAlbumRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlbumEntity::class);
    }

    /**
     * @throws InvalidAlbumNameException
     */
    public function findById(AlbumId $id): ?Album
    {
        $entity = $this->find($id->getValue());

        return $entity ? $this->toDomain($entity) : null;
    }

    /**
     * @throws InvalidAlbumNameException
     */
    public function findByAuthorId(UserId $authorId): array
    {
        $entities = $this->findBy(
            ['authorId' => $authorId->getValue(), 'deletedAt' => null],
            ['createdAt' => 'DESC']
        );

        return array_map(fn(AlbumEntity $entity) => $this->toDomain($entity), $entities);
    }

    /**
     * @throws InvalidAlbumNameException
     */
    public function findAll(): array
    {
        $entities = $this->findBy(
            ['deletedAt' => null],
            ['createdAt' => 'DESC']
        );

        return array_map(fn(AlbumEntity $entity) => $this->toDomain($entity), $entities);
    }

    public function save(Album $album): void
    {
        $entity = $this->find($album->getId()->getValue());

        if ($entity === null) {
            $entity = $this->toInfrastructure($album);
            $this->getEntityManager()->persist($entity);
        } else {
            $this->updateEntity($entity, $album);
        }

        $this->getEntityManager()->flush();
    }

    public function delete(AlbumId $id): void
    {
        $entity = $this->find($id->getValue());

        if ($entity !== null) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws InvalidAlbumNameException
     */
    private function toDomain(AlbumEntity $entity): Album
    {
        $categoryId = $entity->getCategoryId() !== null
            ? new CategoryId($entity->getCategoryId())
            : null;

        return new Album(
            id: new AlbumId($entity->getId()),
            authorId: new UserId($entity->getAuthorId()),
            name: new AlbumName($entity->getName()),
            categoryId: $categoryId,
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt(),
            deletedAt: $entity->getDeletedAt()
        );
    }

    private function toInfrastructure(Album $album): AlbumEntity
    {
        return new AlbumEntity(
            id: $album->getId()->getValue(),
            authorId: $album->getAuthorId()->getValue(),
            name: $album->getName()->getValue(),
            categoryId: $album->getCategoryId()?->getValue(),
            createdAt: $album->getCreatedAt(),
            updatedAt: $album->getUpdatedAt(),
            deletedAt: $album->getDeletedAt()
        );
    }

    private function updateEntity(AlbumEntity $entity, Album $album): void
    {
        $entity->setName($album->getName()->getValue());
        $entity->setCategoryId($album->getCategoryId()?->getValue());
        $entity->setUpdatedAt($album->getUpdatedAt());
        $entity->setDeletedAt($album->getDeletedAt());
    }
}
