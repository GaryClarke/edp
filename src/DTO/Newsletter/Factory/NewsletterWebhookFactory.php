<?php

declare(strict_types=1);

namespace App\DTO\Newsletter\Factory;

use App\DTO\Newsletter\NewsletterWebhook;
use App\DTO\Webhook;
use Symfony\Component\Serializer\SerializerInterface;

class NewsletterWebhookFactory
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function createFromWebhook(Webhook $webhook): NewsletterWebhook
    {
        $newsletterWebhook = $this->serializer->deserialize(
            $webhook->getRawPayload(),
            NewsletterWebhook::class,
            'json'
        );

        return $newsletterWebhook;
    }
}
