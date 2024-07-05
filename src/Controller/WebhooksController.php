<?php

declare(strict_types=1);

namespace App\Controller;

use App\CDP\Analytics\Model\ModelInterface;
use App\CDP\Http\CdpClient;
use App\DTO\Webhook;
use App\Webhook\Handler\HandlerDelegator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class WebhooksController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private HandlerDelegator $handlerDelegator,
        private CdpClient $cdpClient
    ) {
    }

    #[Route(path: '/webhook', name: 'webhook', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $webhook = $this->serializer->deserialize($request->getContent(), Webhook::class, 'json');
        $webhook->setRawPayload($request->getContent());

//        $this->handlerDelegator->delegate($webhook);

        /* identify Model should look like this when sent */
        $identifyModel = new class implements ModelInterface
        {
            public function toArray(): array
            {
                return [
                    'type' => 'identify',
                    'context' => [
                        'product' => 'some-product-code', // newsletter.product_id
                        'event_date' => '2024-12-12' // timestamp
                    ],
                    'traits' => [
                        'subscription_id' => 12345, // id
                        'email' => 'email@example.com' // user.email
                    ],
                    'id' => 'some-user-guid' // user.client_id
                ];
            }
        };
        $this->cdpClient->identify($identifyModel);

        $trackModel = new class implements ModelInterface
        {
            public function toArray(): array
            {
                return [
                    'type' => 'track',
                    'event' => 'newsletter_subscribe', // event
                    'context' => [
                        'product' => 'some-product-code', // newsletter.product_id
                        'event_date' => '2024-12-12', // timestamp
                        'traits' => [
                            'subscription_id' => 12345, // id
                            'email' => 'email@example.com', // user.email
                        ],
                    ],
                    'properties' => [
                        'requires_consent' => true, // from user.region
                        'platform' => 'web', // origin
                        'currency' => null, // should be removed
                        'in_trial' => null, // should be removed
                        'product_name' => 'newsletter-001', // newsletter.newsletter_id
                        'renewal_date' => '2025-12-12', // start date + 1 year if not provided
                        'start_date' => '2024-12-12', // timestamp
                        'status' => 'subscribed', // set by api
                        'type' => 'newsletter', // set by api
                        'is_promotion' => false, // use default
                    ],
                    'id' => 'some-user-guid' // user.client_id
                ];
            }
        };
        $this->cdpClient->track($trackModel);

        return new Response(status: 204);
    }
}
