<?php

declare(strict_types=1);

namespace App\Webhook\Handler;

use App\DTO\Webhook;

class AppSubscriptionHandler implements WebhookHandlerInterface
{
    private const SUPPORTED_EVENTS = [
        'app_subscription_started',
        'app_subscription_stopped',
        'app_subscription_changed'
    ];

    public function supports(Webhook $webhook): bool
    {
        return in_array($webhook->getEvent(), self::SUPPORTED_EVENTS);
    }

    public function handle(Webhook $webhook): void
    {
        dd($webhook);
    }
}
