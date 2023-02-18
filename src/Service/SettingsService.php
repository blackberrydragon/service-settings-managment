<?php

namespace App\Service;

class SettingsService implements SettingServiceInterface
{

    /**
     * @var ExternalServiceInterface[]
     */
    private array $services = [];

    public function __construct(array $services)
    {
        foreach ($services as $service) {
            if (!($service instanceof ExternalServiceInterface)) {
                throw new InvalidArgumentException(sprintf('The service "%s" must implements "%s"', get_debug_type($service), ExternalServiceInterface::class));
            }
            $this->services[] = $service;
        }
    }

    public function getSettings(): array
    {
        $settings = [];

        foreach ($this->services as $service) {
            $settings[$service->getServiceName()] = $service->getSettings();
        }

        return $settings;
    }

    public function setSettings(array $settings_collection)
    {
        foreach ($settings_collection as $service_name => $service_settings) {
            foreach ($this->services as $service) {
                if ($service->supportsUpdateSettings($service_name)) {
                    $service->updateSettings($service_settings);
                    break;
                }
            }
        }
    }
}
