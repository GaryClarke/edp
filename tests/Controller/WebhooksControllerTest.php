<?php

declare(strict_types=1);

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebhooksControllerTest extends WebTestCase
{
    public function testWebhooksAreHandled(): void
    {
        $webTester = static::createClient();

        $webhook = '{
    "event": "event_name",
    "data": {
        "some": "key"
    }
}';

        $webTester->request(
            method: 'POST',
            uri: '/webhook',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => '*/*',
            ],
            content: $webhook
        );
    }
}