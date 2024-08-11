<?php

namespace App\Http\Controllers;

use App\Services\GetAudioService;
use App\Services\GetTextService;


use Illuminate\Http\Request;


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

    public function getAudio(Request $request)
    {
        return $this->getAudioService->execute($request);
    }
    //FUNCIONA BIEN LA TRANSCRIPCION
    //COMANDO DESDE TERMINAL -> whisper whisper.mp3 --language Spanish --model base --output_format txt
    // AssistantController.php
    public function __invoke(Request $request)
    {
        if ($request->hasFile('audio')) {
            // Procesar audio con Whisper
            return $this->getAudioService->execute($request);
        } else {
            // Llamar a los actions correspondientes
            return $this->getText($request);

        }
    }
}
