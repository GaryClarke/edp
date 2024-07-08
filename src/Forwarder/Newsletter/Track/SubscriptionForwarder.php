<?php

declare(strict_types=1);

namespace App\Forwarder\Newsletter\Track;

use App\DTO\Newsletter\NewsletterWebhook;
use App\Forwarder\Newsletter\ForwarderInterface;

class SubscriptionForwarder implements ForwarderInterface
{
    public function supports(NewsletterWebhook $newsletterWebhook): bool
    {
        return true; // track user action for all events
    }

    public function forward(NewsletterWebhook $newsletterWebhook): void
    {
        // TODO: Implement forward() method.
    }
}