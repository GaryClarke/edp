<?php

declare(strict_types=1);

namespace App\Webhook\Handler;

use App\DTO\Webhook;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class HandlerDelegator
{
    /**
     * @param WebhookHandlerInterface ...$handlers
     */
    public function __construct(
        #[AutowireIterator('webhook.handler.delegate')] private iterable $handlers
    ) {
    }

    public function delegate(Webhook $webhook): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($webhook)) {
                $handler->handle($webhook);
            }
        }
    }
}
