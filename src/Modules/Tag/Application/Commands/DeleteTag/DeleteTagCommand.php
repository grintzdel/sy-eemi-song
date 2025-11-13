<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Commands\DeleteTag;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class DeleteTagCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Tag ID is required')]
        #[Assert\Uuid(message: 'Tag ID must be a valid UUID')]
        private string $id
    ) {}

    public function getId(): string
    {
        return $this->id;
    }
}
