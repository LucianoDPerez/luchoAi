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
                    'message' => "Que quieres comprar? \n \n",
                    'categories' => [
                        ['name' => 'ALIMENTOS', 'url' => 'alimentos'],
                        ['name' => 'VESTIMENTA', 'url' => 'vestimenta'],
                        ['name' => 'ELECTRODOMESTICOS', 'url' => 'electrodomesticos'],
                    ],
                    'found' => true, 'action' => true], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
