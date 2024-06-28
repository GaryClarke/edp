<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class StatusController
{
    #[Route(path: '/healthcheck', name: 'healthcheck', methods: ['GET'])]
    public function healthcheck(): JsonResponse
    {
        $commitHash = rtrim(exec('git rev-parse --short HEAD'));  // Get the current git commit hash

        return new JsonResponse([
            'app' => true,
            'git_commit' => $commitHash
        ]);
    }
}