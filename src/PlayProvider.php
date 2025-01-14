<?php

namespace Karlos3098\TelephoneExchangePlay;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class PlayProvider extends ServiceProvider
{
    public function boot(): void
    {
        Notification::resolved(
            fn (ChannelManager $service) => $service->extend(
                'play-exchange',
                fn ($app) => new Channels\PlayChannel()
            )
        );

        $this->publishes([
            __DIR__.'/../config/play_exchange.php' => config_path('play_exchange.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Karlos3098\TelephoneExchangePlay\Commands\PlayCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/play_exchange.php', 'play-telephone-exchange'
        );
    }
}
