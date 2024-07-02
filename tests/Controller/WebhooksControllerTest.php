<?php

declare(strict_types=1);

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class WebhooksControllerTest extends WebTestCase
{
    public function testWebhooksAreHandled(): void
    {
        $webTester = static::createClient();

        $webhook = '{"name":"newsletter_notification","data":{"event":"opened"}}';

        $webTester->request(
            method: 'POST',
            uri: '/webhook',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => '*/*',
            ],
            content: $webhook
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $webTester->getResponse()->getStatusCode());
    }
}
