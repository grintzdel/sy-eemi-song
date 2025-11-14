<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class RegisterDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,

        #[Assert\NotBlank]
        public string $password
    ) {}
}
