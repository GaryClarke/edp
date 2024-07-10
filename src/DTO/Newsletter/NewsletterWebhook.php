<?php

declare(strict_types=1);

namespace App\DTO\Newsletter;

use App\CDP\Analytics\Model\Subscription\SubscriptionSourceInterface;
use App\DTO\User\User;
use DateInterval;
use DateTimeInterface;

class NewsletterWebhook implements SubscriptionSourceInterface
{
    private string $event;
    private string $id;
    private string $origin;
    private DateTimeInterface $timestamp;
    private User $user;
    private Newsletter $newsletter;

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): void
    {
        $this->origin = $origin;
    }

    public function getTimestamp(): DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(DateTimeInterface $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getNewsletter(): Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(Newsletter $newsletter): void
    {
        $this->newsletter = $newsletter;
    }

    // SubscriptionSourceInterface methods

    public function getProduct(): string
    {
        return $this->newsletter->getProductId();
    }

    public function getEventDate(): string
    {
        return $this->timestamp->format('Y-m-d');
    }

    public function getSubscriptionId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

    public function getUserId(): string
    {
        return $this->user->getClientId();
    }

    public function requiresConsent(): bool
    {
        return $this->user->getRegion() === 'EU';
    }

    public function getPlatform(): string
    {
        return $this->origin;
    }

    public function getProductName(): string
    {
        return $this->newsletter->getNewsletterId();
    }

    public function getRenewalDate(): string
    {
        $date = $this->timestamp;

        $interval = new DateInterval('P1Y');

        return $date->add($interval)->format('Y-m-d');
    }

    public function getStartDate(): string
    {
        return $this->timestamp->format('Y-m-d');
    }

    public function getType(): string
    {
        return 'newsletter';
    }

    public function isPromotion(): bool
    {
        return false;
    }
}
