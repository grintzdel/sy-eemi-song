<?php

declare(strict_types=1);

namespace App\Modules\Shared\Application\Services;

use App\Modules\User\Domain\Entities\User;

interface IUserProvider
{
    public function getUser(): ?User;

    public function getUserId(): string;

    public function isAuthenticated(): bool;
}