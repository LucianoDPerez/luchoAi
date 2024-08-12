<?php

namespace App\Http\Actions;

use App\Http\Controllers\Api\ActionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use OpenAI;


class OpenAiAction implements ActionInterface
{
    public function execute(Request $request)
    {
        $data = $request->all();

        try {
            $key = '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';
            $client = OpenAI::client($key);

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini', //gpt-3.5-turbo
                'messages' => [
                    ['role' => 'user', 'content' => $data['city'] . ' ' . $data['text']]
                ],
            ]);

            $result =($response->toArray());

            $responseText = $result['choices'][0]['message']['content'];

                return response()->json([
                    'message' => $responseText,
                    'found' => true, 'action' => false], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
