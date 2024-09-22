<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WaAPI\WaAPISdk\WaAPISdk;

class WhatsappController extends Controller
{
    public function receive(Request $request)
    {
        $waApi = new WaAPISdk('L5stLmxlk4yFkRRE2sGgP1FaNqNwhE6Yhfy0rneuee0ca8c7');

        var_dump($waApi->getInstance(16077)->webhookEvents);

        //$instance = $waApi->getInstance(16077);
        //$response = $instance->clientInfo();

        //$instance->webhookEvents();


    }
}
