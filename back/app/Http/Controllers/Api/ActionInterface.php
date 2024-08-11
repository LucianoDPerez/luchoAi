<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

interface ActionInterface
{
    public function execute(Request $request);
}
