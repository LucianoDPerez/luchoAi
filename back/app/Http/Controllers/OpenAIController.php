<?php

// app/Http/Controllers/OpenAIController.php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

//use OpenAI\Laravel\Facades\OpenAI;

//use Orhanerday\OpenAi\OpenAi;

use OpenAI;

class OpenAIController extends Controller
{

    private const MODEL_AI_DEFAUTL = "gpt-3.5-turbo-0125";

    public function index(Request $request)
    {
        $key = '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';
        $client = OpenAI::client($key);

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => 'farmacias de turno victoria entre rios'],
            ],
        ]);

        $result =($response->toArray());

        if (cache()->has($key)) {
            $models = cache()->get($key);
            if (empty($models)) {
                throw new Exception("OAIC20 :: Error listing models");
            }
        }

                return view('openai', [
                    'models' => '$models',
                    'message' => 'farmacias de turno victoria entre rios',
                    'result' => $result['choices'][0]['message']['content'],
                    'info' => 'kakaka'
                ]);
    }

        //return view('openai', ['models' => $models]);


        public function chat(Request $request)
        {
            $mensaje = $request->input('mensaje');
            $apiKey = config('openai.api_key');
            $client = new Client();

            $response = $client->post('https://api.openai.com/v1/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . 'sk-None-BXwhYqvUPfVJzhqQaS06T3BlbkFJeCEHkeWZxHM2nD48vEGI',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "model" => "gpt-3.5-turbo-0125",
                    "prompt" => "",
                    "max_tokens" => 1056,
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $respuesta = $responseData['choices'][0]['text'];
            return response()->json(['respuesta' => $respuesta]);
        }

}
