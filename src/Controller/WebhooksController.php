<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebhooksController
{
    #[Route(path: '/webhooks', name: 'webhooks', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        dd($request->getContent());
    }
}
