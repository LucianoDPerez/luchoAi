<?php

namespace App\Http\Actions\shop;

use App\Http\Controllers\Api\ActionInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ElectronicAction implements ActionInterface
{
    public function execute(Request $request)
    {
        $data = $request->all();
        try {
            $client = new Client();

            $apiKey = 'AIzaSyBNYYbPqi-YxfPRzVTGivmi8oUBY_j-kxA';
            $query = $data['city'] . '  electrodomesticos';

            $response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => [
                    'query' => $query,
                    'fields' => 'formatted_address,,name,opening_hours', //,photos,rating,reviews
                    'key' => $apiKey,
                ],
            ]);

            $places = json_decode($response->getBody(), true);

            $formattedText = array_map(function ($rate) {
                return "Nombre: " . ($rate['name'] ?? 'Sin nombre') . "\n" .
                    "Direccion: " . ($rate['formatted_address'] ?? 'Sin nombre') . "\n\n";
            }, $places['results']);


            // Unir los textos y devolver como respuesta
                $responseText = implode("\n---\n", $formattedText);

                return response()->json([
                    'message' => "Encontre los siguientes resultados en tu ubicacion \n" . $responseText,
                    'found' => true,
                    'action' => true
                ], 200);


        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
