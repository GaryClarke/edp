<?php

declare(strict_types=1);

namespace App\CDP\Http;

use App\CDP\Analytics\Model\ModelInterface;
use App\Error\Exception\WebhookException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class CdpClient
{
    private const string CDP_API_URL = 'https://some-cdp-api.com';

    public function __construct(
        private HttpClientInterface $httpClient,
        #[Autowire('%cdp.api_key%')] private readonly string $apiKey,
    ) {
    }

    public function track(ModelInterface $model): void
    {
        $response = $this->httpClient->request(
            'POST',
            self::CDP_API_URL . '/track',
            [
                'body' => json_encode($model->toArray(), JSON_THROW_ON_ERROR),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'API-KEY' => $this->apiKey,
                ]
            ]
        );

        // Add error handling
        try {
            $response->toArray();
        } catch (Throwable $throwable) {
            throw new WebhookException(
                message: $response->getContent(false),
                previous: $throwable
            );
        }
    }

    public function identify(ModelInterface $model): void
    {
        $response = $this->httpClient->request(
            'POST',
            self::CDP_API_URL . '/identify',
            [
                'body' => json_encode($model->toArray(), JSON_THROW_ON_ERROR),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'API-KEY' => $this->apiKey,
                ]
            ]
        );

        // Add error handling
        try {
            $response->toArray();
        } catch (Throwable $throwable) {
            throw new WebhookException(
                message: $response->getContent(false),
                previous: $throwable
            );
        }
    }
}
