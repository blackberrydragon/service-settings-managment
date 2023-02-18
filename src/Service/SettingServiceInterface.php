<?php

namespace App\Service;

interface SettingServiceInterface
{
    public function getSettings(): array;
    public function setSettings(array $settings_collection);
}