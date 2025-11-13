<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\ViewModels;

final readonly class IdViewModel
{
    public function __construct(
        public string $id
    ) {}
}
