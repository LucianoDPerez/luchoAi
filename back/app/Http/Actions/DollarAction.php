<?php

namespace App\Http\Actions;

use App\Http\Controllers\Api\ActionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DollarAction implements ActionInterface
{
    public function execute(Request $request)
    {
        try {
            $response = Http::get('https://dolarapi.com/v1/dolares');

            if ($response->successful()) {
                $data = $response->json();

                $formattedText = array_map(function ($rate) {
                    return "Tipo de dólar: {$rate['nombre']}\n" .
                        "Compra: {$rate['compra']}, Venta: {$rate['venta']}\n" .
                        "Fecha de actualización: " . date('d-m-Y H:i:s', strtotime($rate['fechaActualizacion'])) . "\n";
                }, $data);

                // Unir los textos y devolver como respuesta
                $responseText = implode("\n---\n", $formattedText);

                return response()->json([
                    'message' => "Las Cotizaciones del dolar son las siguiente: \n" . $responseText,
                    'found' => true], 200);

            } else {
                return response()->json(['error' => 'Error fetching data'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
