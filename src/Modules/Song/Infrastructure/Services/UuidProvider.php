<?php

declare(strict_types=1);

namespace App\Modules\Song\Infrastructure\Services;

use App\Modules\Song\Application\Ports\Services\IIdProvider;
use Symfony\Component\Uid\Uuid;

final readonly class UuidProvider implements IIdProvider
{
    public function generateId(): string
    {
        return Uuid::v4()->toRfc4122();
    }
}
