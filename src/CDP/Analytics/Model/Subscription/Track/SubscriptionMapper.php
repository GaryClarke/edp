<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model\Subscription\Track;

use App\CDP\Analytics\Model\Subscription\SubscriptionSourceInterface;
use App\Error\Exception\WebhookException;
use TypeError;

class SubscriptionMapper
{
    public function map(SubscriptionSourceInterface $source, TrackModel $target): void
    {
        try {
            $target->setEvent($source->getEvent());
            $target->setProduct($source->getProduct());
            $target->setEventDate($source->getEventDate());
            $target->setSubscriptionId($source->getSubscriptionId());
            $target->setEmail($source->getEmail());
            $target->setRequiresConsent($source->requiresConsent());
            // need adding
            $target->setPlatform($source->getPlatform());
            $target->setProductName($source->getProductName());
            $target->setRenewalDate($source->getRenewalDate());
            $target->setStartDate($source->getStartDate());
            $target->setType($source->getType());
            $target->setIsPromotion($source->isPromotion());
            $target->setId($source->getUserId());
        } catch (TypeError $error) {
            $className = get_class($source);
            throw new WebhookException(
                "Could not map $className to TrackModel target because: " . $error->getMessage()
            );
        }
    }
}
