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
        $city = urlencode(Str::ascii($data['city'] ?? 'Victoria, Entre Rios, AR'));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$city}?unitGroup=metric&key=W34TQR82YWS5U2N2PW9T4XPCP&contentType=json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            Log::error('Error al obtener el clima: ' . curl_error($curl));
            return response()->json(['error' => 'No se pudo obtener el clima.'], 500);
        }

        curl_close($curl);
        $weatherData = json_decode($response, true);

        // Verifica si 'days' existe y tiene al menos un elemento
        if (!isset($weatherData['days']) || !is_array($weatherData['days']) || count($weatherData['days']) === 0) {
            Log::error('No se encontraron datos del clima para la ciudad: ' . $city);
            return response()->json(['error' => 'No se encontraron datos del clima para la ciudad.'], 404);
        }

        $currentWeather = $weatherData['days'][0];

        return response()->json([
            'message' => "El temperatura de hoy en {$data['city']} es:",
            'values' => [[
                'Temperatura actual: ' => $currentWeather['temp'] . " °c",
                'Temperatura minima: ' => $currentWeather['tempmin']  . " °c",
                'Temperatura maxima: ' => $currentWeather['tempmax'] . " °c",
                'Porcentaje de humedad: ' => $currentWeather['humidity'] . " %",
            ]],
            'found' => true,
            'action' => true,
            'group' => true
        ], 200);
    }
}
