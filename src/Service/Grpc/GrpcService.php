<?php

namespace App\Service\Grpc;

use App\Service\ExternalServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GrpcService implements ExternalServiceInterface
{

    private string $service_name;
    private HttpClientInterface $client;

    public function __construct(string $service_name, HttpClientInterface $client)
    {
        $this->service_name = $service_name;
        $this->client = $client;
    }

    public function getSettings()
    {
//        $response = $this->client->GetSettings(new GetSettingsRequest());
//        $settings = $response->getSettings();
        return ['field1' => 'value1', 'field2' => false, 'field3' => 3];
    }

    public function updateSettings($settings)
    {
//        $this->client->UpdateSettings(new UpdateSettingsRequest($settings));
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