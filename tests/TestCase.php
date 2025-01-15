<?php

namespace Karlos3098\TelephoneExchangePlay\Tests;

use Karlos3098\TelephoneExchangePlay\PlayProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            PlayProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('play_exchange.base_url', 'https://example.com');
        $app['config']->set('play_exchange.client.id', 'test-client-id');
        $app['config']->set('play_exchange.client.secret', 'test-client-secret');
        $app['config']->set('play_exchange.from', '48456456456');
        $app['config']->set('play_exchange.client.token_validity_time', 3600);
    }
}
