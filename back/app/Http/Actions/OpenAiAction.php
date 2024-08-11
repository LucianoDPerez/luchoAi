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
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $data['text']]
                ],
            ]);

            $result =($response->toArray());

            $responseText = $result['choices'][0]['message']['content'];

                return response()->json([
                    'message' => $responseText,
                    'found' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
