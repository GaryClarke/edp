<?php

declare(strict_types=1);

namespace App\Webhook\Handler;

use App\DTO\Webhook;

class NewsletterHandler implements WebhookHandlerInterface
{
    public function supports(Webhook $webhook): bool
    {
        return $webhook->getName() === 'newsletter_notification';
    }

    public function handler(Webhook $webhook)
    {
        // TODO: Implement handler() method.
    }
}
