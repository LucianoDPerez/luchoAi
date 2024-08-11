<?php

namespace App\Services;

use App\Http\Actions\ActionFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

class GetTextService
{
    public function execute(Request $request)
    {
        $data = $request->all();
        $text = Str::ascii($data['text']);

        $actionFactory = new ActionFactory();

        $action = $actionFactory->getAction($text);

        if ($action) {
            return $action->execute($request);
        } else {
            return response()->json(['message' => 'ERROR', 'found' => false], 200);
        }
    }

}
