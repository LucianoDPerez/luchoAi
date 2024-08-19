<?php

namespace App\Http\Actions;

use App\Http\Controllers\Api\ActionInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FarmacyAction implements ActionInterface
{
    public function execute(Request $request)
    {
        $data = $request->all();
        try {
            $client = new Client();

            $apiKey = 'AIzaSyBNYYbPqi-YxfPRzVTGivmi8oUBY_j-kxA';
            $query = $data['city'] . '  farmacias';

            $response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => [
                    'query' => $query,
                    'fields' => 'name',
                    'key' => $apiKey,
                ],
            ]);

            $places = json_decode($response->getBody(), true);
            //**********************************************************************************
            $placesReturn = [];
            foreach ($places['results'] as $place) {
                $responsePlace = $client->get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'query' => [
                        'place_id' => $place['place_id'],
                        'fields' => 'formatted_address,name,formatted_phone_number,international_phone_number,opening_hours',
                        'key' => $apiKey,
                    ],
                ]);

                $responseBody = $responsePlace->getBody();

                $responseJson = json_decode($responseBody, true);
                Log::debug($responseJson);
                //dd();

                if ($responseJson && isset($responseJson['result'])) {
                    $placesReturn[]=[
                        'name' => "💊 " . $responseJson['result']['name'],
                        'address' => "📍 " . $responseJson['result']['formatted_address'],
                        'phone' => " 📞 " . ($responseJson['result']['formatted_phone_number'] ?? ' -- '),
                        'opening' => " Abierto ahora:  " . (($responseJson['result']['opening_hours'] ?? [])['open_now'] ?? false ? 'SI' : 'NO')
                    ];
                } else {
                    Log::error('Error al obtener detalles del lugar: ' . $responseBody);
                }
            }

            $placesTest = $placesReturn;

            $places = $placesTest;

            Log::debug(json_encode($placesTest));
            //***********************************************************************************
            /*$formattedText = array_map(function ($rate) {
                return " 🩹💊 " .($rate['name'] ?? '**') . "\n" .
                    " 📍 " . ($rate['formatted_address'] ?? '**') . "\n" .
                    " 📞 " . ($rate['formatted_phone_number'] ?? ' -- ') . "\n" .
                    " Abierto ahora:  " . (($rate['opening_hours'] ?? [])['open_now'] ?? false ? 'SI' : 'NO') . "\n"
                    ;
            }, $places['results']); //results*/

            // Unir los textos y devolver como respuesta
                //$responseText = implode("\n\n", $formattedText);

            $message = "Encontre las siguientes farmacias en tu ubicacion \n";

            /*foreach ($placesTest['results'] as $place) {
                $message .= $place['name'] . "\n";
                $message .= $place['address'] . "\n";
                $message .= $place['phone'] . "\n";
                $message .= "Abierto ahora: " . $place['opening'] . "\n\n";
            }
*/
            return response()->json([
                'message' => $message,
                'values' => $placesTest,
                'found' => true,
                'action' => true,
                'group' => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
