<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Presentation\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Modules\Authentication\Application\ViewModels\TokenViewModel;
use App\Modules\Authentication\Presentation\State\Processor\LoginProcessor;
use App\Modules\Authentication\Presentation\State\Processor\RegisterProcessor;

#[ApiResource(
    shortName: 'Auth',
    operations: [
        new Post(
            uriTemplate: '/auth/register',
            security: 'true',
            processor: RegisterProcessor::class
        ),
        new Post(
            uriTemplate: '/auth/login',
            security: 'true',
            processor: LoginProcessor::class
        )
    ],
    routePrefix: '',
    paginationEnabled: false
)]
final readonly class AuthResource
{
    public function __construct(
        public TokenViewModel $data
    ) {}
}
