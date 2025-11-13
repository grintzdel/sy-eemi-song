<?php

declare(strict_types=1);

namespace App\Modules\Song\Infrastructure\Doctrine\Repositories;

use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Song\Domain\Entities\Song;
use App\Modules\Song\Domain\Exceptions\InvalidDurationException;
use App\Modules\Song\Domain\Exceptions\InvalidSongNameException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use App\Modules\Song\Domain\ValueObjects\Duration;
use App\Modules\Song\Domain\ValueObjects\SongId;
use App\Modules\Song\Domain\ValueObjects\SongName;
use App\Modules\Song\Domain\ValueObjects\Tag;
use App\Modules\Song\Domain\ValueObjects\UserId;
use App\Modules\Song\Infrastructure\Doctrine\Entities\SongEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SongEntity>
 */
class SqlSongRepository extends ServiceEntityRepository implements ISongRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongEntity::class);
    }

    /**
     * @throws InvalidSongNameException
     * @throws InvalidDurationException
     */
    public function findById(SongId $id): ?Song
    {
        $entity = $this->find($id->getValue());

        return $entity ? $this->toDomain($entity) : null;
    }

    /**
     * @throws InvalidSongNameException
     * @throws InvalidDurationException
     */
    public function findByArtistId(UserId $artistId): array
    {
        $entities = $this->findBy(
            ['artistId' => $artistId->getValue(), 'deletedAt' => null],
            ['createdAt' => 'DESC']
        );

        return array_map(fn(SongEntity $entity) => $this->toDomain($entity), $entities);
    }

    /**
     * @throws InvalidSongNameException
     * @throws InvalidDurationException
     */
    public function findAll(): array
    {
        $entities = $this->findBy(
            ['deletedAt' => null],
            ['createdAt' => 'DESC']
        );

        return array_map(fn(SongEntity $entity) => $this->toDomain($entity), $entities);
    }

    public function save(Song $song): void
    {
        $entity = $this->find($song->getId()->getValue());

        if ($entity === null) {
            $entity = $this->toInfrastructure($song);
            $this->getEntityManager()->persist($entity);
        } else {
            $this->updateEntity($entity, $song);
        }

        $this->getEntityManager()->flush();
    }

    public function delete(SongId $id): void
    {
        $entity = $this->find($id->getValue());

        if ($entity !== null) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws InvalidSongNameException
     * @throws InvalidDurationException
     */
    private function toDomain(SongEntity $entity): Song
    {
        return new Song(
            id: new SongId($entity->getId()),
            artistId: new UserId($entity->getArtistId()),
            name: new SongName($entity->getName()),
            categoryId: new CategoryId($entity->getCategoryId()),
            tag: new Tag($entity->getTag()),
            duration: new Duration($entity->getDuration()),
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt(),
            deletedAt: $entity->getDeletedAt()
        );
    }

    private function toInfrastructure(Song $song): SongEntity
    {
        return new SongEntity(
            id: $song->getId()->getValue(),
            artistId: $song->getArtistId()->getValue(),
            name: $song->getName()->getValue(),
            categoryId: $song->getCategoryId()->getValue(),
            tag: $song->getTag()->getValue(),
            duration: $song->getDuration()->getSeconds(),
            createdAt: $song->getCreatedAt(),
            updatedAt: $song->getUpdatedAt(),
            deletedAt: $song->getDeletedAt()
        );
    }

    private function updateEntity(SongEntity $entity, Song $song): void
    {
        $entity->setName($song->getName()->getValue());
        $entity->setCategoryId($song->getCategoryId()->getValue());
        $entity->setTag($song->getTag()->getValue());
        $entity->setDuration($song->getDuration()->getSeconds());
        $entity->setUpdatedAt($song->getUpdatedAt());
        $entity->setDeletedAt($song->getDeletedAt());
    }
}
