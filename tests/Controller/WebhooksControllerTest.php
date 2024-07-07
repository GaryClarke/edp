<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\CDP\Analytics\Model\Subscription\Identify\IdentifyModel;
use App\CDP\Http\CdpClient;
use App\Tests\TestDoubles\CDP\Http\FakeCdpClient;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class WebhooksControllerTest extends WebTestCase
{
    private KernelBrowser $webTester;
    private ContainerInterface $container;
    private FakeCdpClient $cdpClient;

    protected function setUp(): void
    {
        $this->webTester = static::createClient();
        $this->container = $this->webTester->getContainer();
        $this->cdpClient = $this->container->get(CdpClient::class);
    }

    public function testWebhooksAreHandled(): void
    {
        $webhook = '{"event":"newsletter_subscribed","id":"12345","origin":"www","timestamp":"2024-12-12T12:00:00Z","user": {"client_id":"some-user-guid","email":"user@example.com","region":"UK"},"newsletter": {"newsletter_id":"newsletter-001","topic":"N/A","product_id":"some-product-identifier"}}';

        $this->postJson($webhook);

        // Assert CdpClient::identify() called once
        $this->assertEquals(1, $this->cdpClient->getIdentifyCallCount());
        // Assert correct IdentifyModel is passed to CdpClient::identify() method
        $identifyModel = $this->cdpClient->getIdentifyModel();
        assert($identifyModel instanceof IdentifyModel);

        // Assert IdentifyModel::toArray() organizes data into format expected by CDP
        $this->assertSame([
            'type' => 'identify',
            'context' => [
                'product' => 'some-product-identifier', // newsletter.product_id
                'event_date' => '2024-12-12' // timestamp
            ],
            'traits' => [
                'subscription_id' => '12345', // id
                'email' => 'user@example.com' // user.email
            ],
            'id' => 'some-user-guid' // user.client_id
        ], $identifyModel->toArray());

        // Assert CdpClient::track() called once
        // Assert correct TrackModel is passed to CdpClient::track() method
        // Assert TrackModel::toArray() organizes data into format expected by CDP

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
