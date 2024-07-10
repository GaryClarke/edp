<?php

declare(strict_types=1);

namespace App\Forwarder\Newsletter\Track;

use App\CDP\Analytics\Model\Subscription\Track\SubscriptionMapper;
use App\CDP\Analytics\Model\Subscription\Track\TrackModel;
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
        // Instantiate a class which models Identify data
        $model = new TrackModel();

        $model->setStatus('subscribed');

        (new SubscriptionMapper())->map($newsletterWebhook, $model);

        // Validate the model
//        $this->modelValidator->validate($model);

        // Use the CDP client to POST the data to the CDP
//        $this->cdpClient->identify($model);
    }
}