<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Claude\Claude3Api\Client;
use Claude\Claude3Api\Config;
class ClaudeController extends Controller
{
    public function index()
    {
        $config = new Config('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');
        $client = new Client($config);

        $response = $client->chat("farmacias de turno victoria entre rios");

        echo "Claude's response: " . $response->getContent()[0]['text'];
    }
}
