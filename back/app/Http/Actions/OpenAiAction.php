<?php

namespace App\Http\Actions;

use App\Http\Controllers\Api\ActionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use OpenAI;


class OpenAiAction implements ActionInterface
{
    /*   ASI DEVUELVE OPENAI
{
  "id": "chatcmpl-9yBAOMGDKxZEZq1SNLdqvscxRRtLJ",
  "object": "chat.completion",
  "created": 1724129632,
  "model": "gpt-4o-mini-2024-07-18",
  "system_fingerprint": "fp_48196bc67a",
  "choices": [
    {
      "index": 0,
      "message": {
        "role": "assistant",
        "content": "No tengo la capacidad de acceder a la hora actual."
      },
      "finish_reason": "stop"
    }
  ],
  "usage": {
    "prompt_tokens": 13,
    "completion_tokens": 36,
    "total_tokens": 49
  }
}
     */
    public function execute(Request $request)
    {
        $data = $request->all();
        Log::info('SOLO EXISTE....');
        Log::info(json_encode($data));

        if (array_key_exists('text', $data) && strlen($data['text']) > 0 && array_key_exists('city', $data)) {
                $key = env('OPENAI_API_KEY');
                $client = OpenAI::client($key);

                $response = $client->chat()->create([
                    'model' => 'gpt-4o-mini', //gpt-3.5-turbo
                    'messages' => [
                        ['role' => 'user', 'content' => $data['city'] . ' ' . $data['text']]
                    ],
                ]);

                $result =($response->toArray());

                Log::info(json_encode($result));

                $responseText = $result['choices'][0]['message']['content'];

                return response()->json([
                    'message' => $responseText,
                    'prompt' => $data['text'],
                    'found' => true,
                    'action' => false
                ], 200);
        }

        return response()->json([
            'message' => 'Hubo un error al intentar procesar tu solicitud, intentalo nuevamente en unos minutos',
            'found' => true, 'action' => true], 200);
    }
}
