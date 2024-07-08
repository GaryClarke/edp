<?php

declare(strict_types=1);

namespace App\Forwarder\Newsletter\Identify;

use App\CDP\Analytics\Model\ModelValidator;
use App\CDP\Analytics\Model\Subscription\Identify\IdentifyModel;
use App\CDP\Analytics\Model\Subscription\Identify\SubscriptionStartMapper;
use App\CDP\Http\CdpClient;
use App\DTO\Newsletter\NewsletterWebhook;
use App\Forwarder\Newsletter\ForwarderInterface;

class SubscriptionStartForwarder implements ForwarderInterface
{
    private const string SUPPORTED_EVENT = 'newsletter_subscribed';

    public function __construct(
        private CdpClient $cdpClient,
        private ModelValidator $modelValidator
    ) {
    }

    public function supports(NewsletterWebhook $newsletterWebhook): bool
    {
        return $newsletterWebhook->getEvent() === self::SUPPORTED_EVENT;
    }

    public function forward(NewsletterWebhook $newsletterWebhook): void
    {
        // Instantiate a class which models Identify data
        $model = new IdentifyModel();

        // Map the NewsletterWebhook data to the model
        (new SubscriptionStartMapper())->map($newsletterWebhook, $model);

        // Validate the model
        $this->modelValidator->validate($model);

        // Use the CDP client to POST the data to the CDP
        $this->cdpClient->identify($model);
    }
}