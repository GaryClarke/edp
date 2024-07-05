<?php

namespace App\Forwarder\Newsletter;

use App\DTO\Newsletter\NewsletterDto;

interface ForwarderInterface
{
    public function supports(NewsletterDto $newsletterDto): bool;

    public function forward(NewsletterDto $newsletterDto): void;
}
