<?php

namespace App\Http\Controllers;

use App\Services\GetAudioService;
use App\Services\GetTextService;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AssistantController extends Controller
{
    protected $getTextService;
    protected $getAudioService;

    public function __construct(GetTextService $getTextService, GetAudioService $getAudioService)
    {
        $this->getTextService = $getTextService;
        $this->getAudioService = $getAudioService;
    }

    public function getText(Request $request)
    {
        return $this->getTextService->execute($request);
    }

    public function whisper(Request $request)
    {
        Log::info('ENTRO LLEGO CON EL AUDIO EN WHISPER');
        Log::info(json_encode($request->all()));
        return $this->getAudioService->execute($request);
    }
    //FUNCIONA BIEN LA TRANSCRIPCION
    //COMANDO DESDE TERMINAL -> whisper whisper.mp3 --language Spanish --model base --output_format txt
    // AssistantController.php
    public function __invoke(Request $request)
    {
        if ($request->has('text')) {
            // Llamar a los actions correspondientes
            return $this->getText($request);
        } else {
            // Handle the case where the text key doesn't exist
            return response()->json(['message' => 'No text found'], 400);
        }
    }
}
