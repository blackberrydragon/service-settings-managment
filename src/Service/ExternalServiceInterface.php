<?php

namespace App\Service;

interface ExternalServiceInterface
{
    public function getSettings();
    public function updateSettings($settings);
    public function supportsUpdateSettings($service_name): bool;
}