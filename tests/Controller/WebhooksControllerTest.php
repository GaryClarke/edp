<?php

declare(strict_types=1);

namespace Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class WebhooksControllerTest extends WebTestCase
{
    private KernelBrowser $webTester;
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $this->webTester = static::createClient();
        $this->container = $this->webTester->getContainer();
    }

    public function testWebhooksAreHandled(): void
    {
        $webhook = '{"event": "newsletter_subscribed","timestamp": "2023-07-03T12:00:00Z","user": {"client_id":"some-user-guid","email": "user@example.com","region": "UK"},"newsletter": {"newsletter_id":"newsletter-001","topic": "Summer Sales","product_id":"some-product-identifier"}}';

        $this->postJson($webhook);

        // Assert CdpClient::track() called once
        // Assert correct TrackModel is passed to CdpClient::track() method
        // Assert TrackModel::toArray() organizes data into format expected by CDP
        // Assert CdpClient::identify() called once
        // Assert correct IdentifyModel is passed to CdpClient::identify() method
        // Assert IdentifyModel::toArray() organizes data into format expected by CDP

        $this->assertEquals(Response::HTTP_NO_CONTENT, $this->webTester->getResponse()->getStatusCode());
    }

    private function postJson(string $payload): void
    {
        $this->webTester->request(
            method: 'POST',
            uri: '/webhook',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => '*/*',
            ],
            content: $payload
        );
    }
}
