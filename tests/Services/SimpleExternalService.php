<?php

namespace App\Tests\Services;

use App\Service\ExternalServiceInterface;

class SimpleExternalService implements ExternalServiceInterface{

    private array $settings;
    private string $service_name;

    public function __construct(string $service_name, array $settings)
    {
        $this->settings = $settings;
        $this->service_name = $service_name;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function updateSettings($settings)
    {
        $this->settings = $settings;
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