<?php

namespace App\Tests;

use App\Service\ExternalServiceInterface;
use App\Service\InvalidArgumentException;
use App\Service\SettingServiceInterface;
use App\Service\SettingsService;
use App\Tests\Services\FakeExternalService;
use App\Tests\Services\SimpleExternalService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SettingServiceTest extends KernelTestCase
{
    public function testNoServices()
    {
        $settingService = new SettingsService([]);
        self::assertEquals([], $settingService->getSettings());
    }

    public function testInvalidArgument()
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage((sprintf('The service "%s" must implements "%s"', FakeExternalService::class, ExternalServiceInterface::class)));
        new SettingsService([new FakeExternalService]);

    }

    public function testCreateServiceAndGetSettings()
    {
        $settingService = new SettingsService(
            [
                new SimpleExternalService('service_1', ['field1' => true, 'field2' => 'string']),
                new SimpleExternalService('service_2', ['field1' => 34, 'field2' => [1, 2]]),
                new SimpleExternalService('service_3', [])
            ]);

        self::assertEquals(
            ['service_1' => ['field1' => true, 'field2' => 'string'], 'service_2' => ['field1' => 34, 'field2' => [1, 2]], 'service_3' => []],
            $settingService->getSettings()
        );
    }

    public function testUpdateSettings()
    {
        $settingService = new SettingsService(
            [
                new SimpleExternalService('service_1', ['field1' => true, 'field2' => 'string']),
                new SimpleExternalService('service_2', ['field1' => 34, 'field2' => [1, 2]]),
                new SimpleExternalService('service_3', [])
            ]);

        self::assertEquals(
            [
                'service_1' => ['field1' => true, 'field2' => 'string'],
                'service_2' => ['field1' => 34, 'field2' => [1, 2]],
                'service_3' => []
            ],
            $settingService->getSettings()
        );

        $settingService->setSettings([
            'service_1' => ['field1' => false, 'field2' => 'string new'],
            'service_2' => ['field1' => 44, 'field2' => [2, 3]],
            'service_3' => []
        ]);

        self::assertEquals(
            [
                'service_1' => ['field1' => false, 'field2' => 'string new'],
                'service_2' => ['field1' => 44, 'field2' => [2, 3]],
                'service_3' => []
            ],
            $settingService->getSettings()
        );
    }

    public function testGetServiceFromContainer()
    {
        /** @var SettingServiceInterface $service */
        $service = $this->getContainer()->get('test_setting_service');

        self::assertNotEmpty($service->getSettings());

        self::assertEquals(
            [
                'http_service',
                'grpc_service',
                'rest_service'
            ],
            array_keys($service->getSettings()));

    }
}



