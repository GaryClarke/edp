<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class WebhooksController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    #[Route(path: '/webhooks', name: 'webhooks', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $webhook = $this->serializer->deserialize($request->getContent(), Webhook::class, 'json');

        dd($webhook);
    }
}
