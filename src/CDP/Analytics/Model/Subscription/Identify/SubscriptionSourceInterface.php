<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model\Subscription\Identify;

interface SubscriptionSourceInterface
{
    public function getProduct(): string;

    public function getEventDate(): string;

    public function getSubscriptionId(): string;

    public function getEmail(): string;

    public function getId(): string;
}
