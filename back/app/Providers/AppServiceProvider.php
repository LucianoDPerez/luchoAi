<?php

namespace App\Providers;

use App\Http\Actions\WeatherAction;
use App\Http\Controllers\Api\ActionInterface;
use Google_Client;
use HalilCosdu\ChatBot\ChatBot;
use HalilCosdu\ChatBot\Services\ChatBotService;
use HalilCosdu\ChatBot\Services\OpenAI\RawService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Google_Client::class, function ($app) {
            return new Google_Client();
        });

        $this->app->bind(ActionInterface::class, WeatherAction::class);

        $this->app->singleton(ChatBot::class, function ($app) {

            return new ChatBot($app->make(ChatBotService::class), $app->make(RawService::class));

        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
