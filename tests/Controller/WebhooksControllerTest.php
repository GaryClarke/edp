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

        $webhook = '{"event": "newsletter_opened","timestamp": "2023-07-03T12:00:00Z","user": {"client_id":"some-user-guid","email": "user@example.com","region": "UK"},"newsletter": {"newsletter_id":"newsletter-001","topic": "Summer Sales","product_id": "some-product-identifier"}}';

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
