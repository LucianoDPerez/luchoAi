<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaapiController extends Controller
{
    public function receive(Request $request)
    {
        $response = file_get_contents('php://input');

        if ($response) {
            file_put_contents('receive.txt', $response);
            return response()->json(['message' => 'Data received successfully'], 200);
        } else {
            return response()->json(['message' => 'No data received'], 400);
        }
    }
}
