<?php

declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Services;

use App\Modules\Shared\Application\Services\IUserProvider;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\Entities\User;
use App\Modules\User\Domain\Repositories\IUserRepository;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class SymfonyUserProvider implements IUserProvider
{
    public function __construct(
        private Security $security,
        private IUserRepository $userRepository,
    ) {
    }

    public function getUser(): ?User
    {
        $userEntity = $this->security->getUser();

        if (null === $userEntity) {
            return null;
        }

        $userId = new UserId($userEntity->getId());

        return $this->userRepository->findById($userId);
    }

    public function getUserId(): string
    {
        $user = $this->getUser();

        if (null === $user) {
            throw new \RuntimeException('No authenticated user found');
        }

        return $user->getId()->getValue();
    }

    public function isAuthenticated(): bool
    {
        return null !== $this->security->getUser();
    }
}
