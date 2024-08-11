<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlackboxController extends Controller
{
    public function blackbox(Request $request)
    {
        $txt = $request->input('text');
        $mode = $request->input('mode');
        $webk = $mode === '1';

        $url = 'https://www.blackbox.ai/api/chat';

        $data = [
            'messages' => [
                [
                    'id' => '6cdrFCv',
                    'content' => $txt,
                    'role' => 'user'
                ]
            ],

            'id' => '6clrFCv',
            'previewToken' => null,
            'userId' => '0d264665-73ae-498f-aa3f-4b7b65997963',
            'codeModelMode' => true,
            'agentMode' => [],
            'trendingAgentMode' => [],
            'isMicMode' => false,
            'isChromeExt' => false,
            'githubToken' => null,
            'webSearchMode' => $webk,
            'maxTokens' => "10240"
        ];

        $response = Http::post($url, $data);

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'data' => $response->body(),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => $response->status(),
            ], $response->status());
        }
    }
}
