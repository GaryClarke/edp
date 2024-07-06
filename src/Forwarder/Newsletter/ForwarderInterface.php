<?php

namespace App\Forwarder\Newsletter;

use App\DTO\Newsletter\NewsletterWebhook;

interface ForwarderInterface
{
    public function supports(NewsletterWebhook $newsletterWebhook): bool;

    public function forward(NewsletterWebhook $newsletterWebhook): void;
}
