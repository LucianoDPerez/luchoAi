<?php

namespace BlackboxAi\Clima;

use Illuminate\Support\Facades\Log;
use RakibDevs\Weather\Weather as RakibDevsWeather;

class Clima
{
    public function getCurrentWeather($city)
    {
        $wt = new RakibDevsWeather();
        $info = $wt->getCurrentByCity($city);

        //dd($info); // or var_dump($info);

        return $info->main;
    }

}
