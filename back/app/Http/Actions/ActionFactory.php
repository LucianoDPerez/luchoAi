<?php

namespace App\Http\Actions;

use App\Http\Controllers\Api\ActionInterface;
use Illuminate\Support\Facades\Log;

class ActionFactory
{
    private array $actions = [
        'weather' => WeatherAction::class,
        'clima' => WeatherAction::class,
        'tiempo' => WeatherAction::class,
        'pronostico' => WeatherAction::class,

        'dolar' => DollarAction::class,
        'dolares' => DollarAction::class,
        'dollar' => DollarAction::class,

        'farmacia' => FarmacyAction::class,
        // Agrega más acciones aquí
    ];

    private $openAi = OpenAiAction::class;

    public function getAction(string $transcription)
    {
        foreach ($this->actions as $keyword => $actionClass) {
            if (str_contains(strtolower($transcription), strtolower($keyword))) {
                return new $actionClass();
            }
        }

        return new $this->openAi();
    }
}
