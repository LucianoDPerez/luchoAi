<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaapiController extends Controller
{
    public function receive()
    {
        $response = file_get_contents('php://input');

        file_put_contents('receive.txt', $response);
    }
}
