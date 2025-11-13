<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Commands\UpdateTag;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateTagCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Tag ID is required')]
        #[Assert\Uuid(message: 'Tag ID must be a valid UUID')]
        private string $id,

        #[Assert\NotBlank(message: 'Tag name is required')]
        #[Assert\Length(
            max: 100,
            maxMessage: 'Tag name cannot exceed {{ limit }} characters'
        )]
        private string $name
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
