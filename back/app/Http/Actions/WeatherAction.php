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

        return response()->json([
            'message' => 'El pronostico para ' . $data['city'] . ' es: ' . $returnWeather->temp,
            'found' => true], 200);
    }
}
