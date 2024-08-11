<?php

// app/Services/TranscriptionAnalyzer.php

namespace App\Services;

use App\Http\Actions\WeatherAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TranscriptionAnalyzerService
{
    private $actions = [];

    public function __construct()
    {
        // Registramos las acciones que se pueden ejecutar
        $this->actions = [
            'clima' => WeatherAction::class,
            'tiempo' => WeatherAction::class,
            'pronostico' => WeatherAction::class,
            // Agregar más acciones aquí
        ];
    }

    public function analyze($input, Request $request)
    {
        $input = is_array($input) ? $input['text'] : $input;
        foreach ($this->actions as $keyword => $action) {
            if (stripos($input, $keyword) !== false) {
                // La transcripción o el texto de entrada contienen la palabra clave, ejecutamos la acción
                return app()->make($action)->execute($request);
            }
        }
    }
}
