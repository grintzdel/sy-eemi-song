<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Ports\Services;

interface IIdProvider
{
    public function generateId(): string;
}
