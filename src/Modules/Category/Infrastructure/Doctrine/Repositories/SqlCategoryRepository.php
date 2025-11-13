<?php

declare(strict_types=1);

namespace App\Modules\Category\Infrastructure\Doctrine\Repositories;

use App\Modules\Category\Domain\Entities\Category;
use App\Modules\Category\Domain\Exceptions\InvalidCategoryNameException;
use App\Modules\Category\Domain\Repositories\ICategoryRepository;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Category\Domain\ValueObjects\CategoryName;
use App\Modules\Category\Domain\ValueObjects\CategoryDescription;
use App\Modules\Category\Infrastructure\Doctrine\Entities\CategoryEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryEntity>
 */
class SqlCategoryRepository extends ServiceEntityRepository implements ICategoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntity::class);
    }

    /**
     * @throws InvalidCategoryNameException
     */
    public function findById(CategoryId $id): ?Category
    {
        $entity = $this->find($id->getValue());

        return $entity ? $this->toDomain($entity) : null;
    }

    /**
     * @throws InvalidCategoryNameException
     */
    public function findByName(CategoryName $name): ?Category
    {
        $entity = $this->findOneBy(['name' => $name->getValue()]);

        return $entity ? $this->toDomain($entity) : null;
    }

    /**
     * @throws InvalidCategoryNameException
     */
    public function findAll(): array
    {
        $entities = $this->findBy([], ['name' => 'ASC']);

        return array_map(fn(CategoryEntity $entity) => $this->toDomain($entity), $entities);
    }

    /**
     * @throws InvalidCategoryNameException
     */
    public function findAllActive(): array
    {
        $entities = $this->findBy(
            ['deletedAt' => null],
            ['name' => 'ASC']
        );

        return array_map(fn(CategoryEntity $entity) => $this->toDomain($entity), $entities);
    }

    public function save(Category $category): void
    {
        $entity = $this->find($category->getId()->getValue());

        if ($entity === null) {
            $entity = $this->toInfrastructure($category);
            $this->getEntityManager()->persist($entity);
        } else {
            $this->updateEntity($entity, $category);
        }

        $this->getEntityManager()->flush();
    }

    public function delete(CategoryId $id): void
    {
        $entity = $this->find($id->getValue());

        if ($entity !== null) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }

    public function exists(CategoryName $name): bool
    {
        return $this->count(['name' => $name->getValue()]) > 0;
    }

    /**
     * @throws InvalidCategoryNameException
     */
    private function toDomain(CategoryEntity $entity): Category
    {
        return new Category(
            id: new CategoryId($entity->getId()),
            name: new CategoryName($entity->getName()),
            description: new CategoryDescription($entity->getDescription()),
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt(),
            deletedAt: $entity->getDeletedAt()
        );
    }

    private function toInfrastructure(Category $category): CategoryEntity
    {
        return new CategoryEntity(
            id: $category->getId()->getValue(),
            name: $category->getName()->getValue(),
            description: $category->getDescription()->getValue(),
            createdAt: $category->getCreatedAt(),
            updatedAt: $category->getUpdatedAt(),
            deletedAt: $category->getDeletedAt()
        );
    }

    private function updateEntity(CategoryEntity $entity, Category $category): void
    {
        $entity->setName($category->getName()->getValue());
        $entity->setDescription($category->getDescription()->getValue());
        $entity->setUpdatedAt($category->getUpdatedAt());
        $entity->setDeletedAt($category->getDeletedAt());
    }
}
