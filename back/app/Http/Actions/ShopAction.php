<?php

namespace App\Http\Actions;

use App\Http\Controllers\Api\ActionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ShopAction implements ActionInterface
{
    public function execute(Request $request)
    {
        try {

                return response()->json([
                    'message' => "Que quieres comprar? \n",
                    'categories' => [
                        ['name' => 'Alimentos', 'url' => 'https://example.com/alimentos'],
                        ['name' => 'Vestimenta', 'url' => 'https://example.com/vestimenta'],
                        ['name' => 'Electrodomesticos', 'url' => 'https://example.com/electrodomesticos'],
                    ],
                    'found' => true, 'action' => true], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
