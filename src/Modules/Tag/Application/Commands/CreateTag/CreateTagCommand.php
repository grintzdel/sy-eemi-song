<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Commands\CreateTag;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateTagCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Tag name is required')]
        #[Assert\Length(
            max: 100,
            maxMessage: 'Tag name cannot exceed {{ limit }} characters'
        )]
        private string $name
    ) {}

    public function getName(): string
    {
        return $this->name;
    }
}
