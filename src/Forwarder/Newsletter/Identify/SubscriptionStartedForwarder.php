<?php

declare(strict_types=1);

namespace App\Forwarder\Newsletter\Identify;

use App\DTO\Newsletter\NewsletterWebhook;
use App\Forwarder\Newsletter\ForwarderInterface;

class SubscriptionStartedForwarder implements ForwarderInterface
{
    public function supports(NewsletterWebhook $newsletterDto): bool
    {
        return true;
    }

    public function forward(NewsletterWebhook $newsletterDto): void
    {
        // Instantiate a class which models Identify data

        // Map the NewsletterWebhook data to the model

        // Validate the model

        // Use the CDP client to POST the data to the CDP
    }
}