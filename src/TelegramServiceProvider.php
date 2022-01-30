<?php

namespace SKprods\Telegram;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;
use SKprods\Telegram\Writers\WriterManager;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->configure();

        $this->app->singleton('chatInfoWriter', function () {
            return app(WriterManager::class);
        });
    }

    protected function configure()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/telegram.php", 'telegram');

        if ($this->app instanceof LaravelApplication) {
            $this->publishes([__DIR__ . "/../config/telegram.php" => config_path('telegram.php')], 'telegram');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('telegram');
        }
    }
}