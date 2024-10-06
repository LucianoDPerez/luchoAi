<?php

namespace App\Services;

use App\Http\Actions\ActionFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetAudioService
{
    public function execute(Request $request)
    {
        $validatedData = $request->validate([
            'audio' => 'required|file|mimes:audio/m4a',
        ]);

        $audio = $validatedData['audio'];
        $data = $request->all();

        Log::info('AUDIOSERVICE REQUEST ES...');
        Log::debug(json_encode($data));

        $path = $audio->storePublicly('audios', 'public');

        $fullPath = public_path('audios/' . $path);

        $command = escapeshellcmd('/usr/local/bin/whisper') . ' ' . escapeshellarg($fullPath) . ' --language Spanish --model base --output_format txt';

        $output = [];
        $resultCode = null;

        $result = exec($command, $output, $resultCode);

        if (!$result && $resultCode !== 0) {
            return response()->json(['message' => 'Error ejecutando el comando de whisper', 'found' => true, 'action' => false], 200);
        }

        $text = substr(implode("\n", $output), strpos(implode("\n", $output), ']') + 1);

        Log::info($text);

        $request->merge(['text' => $text]);

        // Llamar a la acción correspondiente
        $actionFactory = new ActionFactory();
        $action = $actionFactory->getAction($text);

        if ($action) {
            return $action->execute($request);
        } else {
            return response()->json(['message' => 'Error ejecutando el comando de whisper', 'found' => true, 'action' => false], 200);
        }
    }

}
