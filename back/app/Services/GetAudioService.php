<?php

namespace App\Services;

use App\Http\Actions\ActionFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetAudioService
{
    public function execute(Request $request)
    {
        if (!$request->hasFile('audio')) {
            Log::error('El archivo de audio no se subió correctamente.');
            return response()->json(['message' => 'Archivo de audio no encontrado'], 400);
        }

        $audio = $request->file('audio');
        $data = $request->all();

        Log::info('AUDIOSERVICE REQUEST ES...');
        Log::debug(json_encode($data));

        $path = $audio->store('audios', 'public');
        $fullPath = public_path('/storage/' . $path);

        Log::info('fullpath es... ' . $fullPath);

        try {
            $command = escapeshellcmd('/usr/local/bin/whisper') . ' ' . escapeshellarg($fullPath) .
                ' --language Spanish --model base --output_format txt';

            $output = [];
            $resultCode = null;

            $result = exec($command, $output, $resultCode);

            Log::info('Command output: ' . implode("\n", $output));
            Log::info('Result code: ' . $resultCode);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Error procesando el audio.', 'found' => true, 'action' => false], 500);
        }

        if (!$result && $resultCode !== 0) {
            return response()->json(['message' => 'Error ejecutando el comando de whisper', 'found' => true, 'action' => false], 500);
        }

        $text = substr(implode("\n", $output), strpos(implode("\n", $output), ']') + 1);

        Log::info('Texto procesado: ' . $text);

        $request->merge(['text' => $text]);

        // Llamar a la acción correspondiente
        $actionFactory = new ActionFactory();
        $action = $actionFactory->getAction($text);

        if ($action) {
            return $action->execute($request);
        } else {
            return response()->json(['message' => 'Acción no encontrada después del procesamiento', 'found' => true, 'action' => false], 200);
        }
    }
}
