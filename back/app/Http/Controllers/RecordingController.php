<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Speech\V1\SpeechClient;

class RecordingController extends Controller
{
    public function store(Request $request)
    {
        // Obtener el audio desde la solicitud
        $audio = $request->file('audio');

        // Crear un cliente de Speech-to-Text
        $speechClient = new SpeechClient();

        // Configurar la solicitud de reconocimiento de voz
        $config = [
            'encoding' => 'LINEAR16',
            'sampleRateHertz' => 48000,
            'languageCode' => 'es-ES',
        ];

        // Reconocer el texto desde el audio
        $response = $speechClient->recognize($config, $audio);

        // Obtener el texto reconocido
        $texto = $response->getResults()[0]->getAlternatives()[0]->getTranscript();

        // Retornar el texto reconocido como respuesta
        return response()->json(['textoRespuesta' => $texto]);
    }
}
