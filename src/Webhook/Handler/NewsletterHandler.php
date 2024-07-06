<?php

declare(strict_types=1);

namespace App\Webhook\Handler;

use App\DTO\Newsletter\Factory\NewsletterWebhookFactory;
use App\DTO\Webhook;

class NewsletterHandler implements WebhookHandlerInterface
{
    private const SUPPORTED_EVENTS = ['newsletter_opened', 'newsletter_subscribed', 'newsletter_unsubscribed'];

    public function __construct(
        private NewsletterWebhookFactory $newsletterWebhookFactory
    ) {
    }

    public function supports(Webhook $webhook): bool
    {
        return in_array($webhook->getEvent(), self::SUPPORTED_EVENTS);
    }

    public function handle(Webhook $webhook): void
    {
        $newsletterWebhook = $this->newsletterWebhookFactory->createFromWebhook($webhook);

        // Loop over the forwarders
            // If supported
            // Forward the data
    }
}
