<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
class GoogleMapsController
{
    public function test()
    {
        $client = new Client();

        $apiKey = 'AIzaSyBNYYbPqi-YxfPRzVTGivmi8oUBY_j-kxA';

        $query = 'farmacias de turno en victoria, entre rios';

        $response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
            'query' => [
                'query' => $query,
                'fields' => 'formatted_address,geometry,name,opening_hours,photos,rating,reviews',
                'key' => $apiKey,
            ],
        ]);

        $places = json_decode($response->getBody(), true);

        // Return the list of places with potentially added phone numbers
        return response()->json($places);
    }


}
