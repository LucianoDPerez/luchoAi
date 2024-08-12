<?php

namespace App\Http\Actions;

use App\Http\Controllers\Api\ActionInterface;
use Blackboxai\Clima\Clima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
class WeatherAction implements ActionInterface
{
    public function execute(Request $request)
    {
        $data = $request->all();
        $weather = new Clima();
        $returnWeather = $weather->getCurrentWeather(Str::ascii($data['city']));

        Log::info(json_encode($returnWeather));
        return response()->json([
            'message' => 'El pronostico para ' . $data['city'] . " es: \n" .
                            'Temperatura actual: ' . $returnWeather->temp . "\n" .
                            'Temperatura minima: ' . $returnWeather->temp_min . "\n" .
                            'Temperatura maxima: ' . $returnWeather->temp_max . "\n" .
                            'Porcentaje humedad: ' . $returnWeather->humidity,
            'found' => true, 'action' => true], 200);
    }
}
