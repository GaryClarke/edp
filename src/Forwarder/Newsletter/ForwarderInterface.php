<?php

namespace App\Forwarder\Newsletter;

use App\DTO\Newsletter\NewsletterWebhook;

interface ForwarderInterface
{
    public function supports(NewsletterWebhook $newsletterDto): bool;

    public function forward(NewsletterWebhook $newsletterDto): void;
}
