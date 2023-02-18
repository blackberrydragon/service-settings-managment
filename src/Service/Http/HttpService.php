<?php

namespace App\Service\Http;

use App\Service\ExternalServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpService implements ExternalServiceInterface
{

    private string $service_name;
    private HttpClientInterface $client;
    private string $url;

    public function __construct(string $service_name, HttpClientInterface $client, string $url)
    {
        $this->service_name = $service_name;
        $this->client = $client;
        $this->url = $url;
    }

    public function getSettings()
    {
//        $response = $this->client->request('GET', $this->url);
//        $settings = json_decode($response->getContent(), true);
        return ['field1' => true, 'field2' => 1, 'field3' => ['value1', 23]];
    }

    public function updateSettings($settings)
    {
        $this->client->request('POST', $this->url, [
            'body' => $settings,
        ]);
    }

    public function getServiceName(): string
    {
        return $this->service_name;
    }

    public function supportsUpdateSettings($service_name): bool
    {
        return $this->service_name === $service_name;
    }
}