<?php

namespace App\Http\Controllers;

use App\TisiCb;
use App\TisiIb;
use App\TisiLab;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function pmt1()
    {
        return 'found';
    }

    public function api()
    {
        $url = 'http://127.0.0.1:8082/pmt1';
    $context = stream_context_create([
        'http' => [
            'timeout' => 120, // กำหนดเวลา timeout เป็น 120 วินาที
        ]
    ]);
    $response = file_get_contents($url, false, $context);
    dd($response);
    }

    public function lab()
    {
        $tisiLabs = TisiLab::find(7)->ssoUser;
        dd($tisiLabs);
    }
}
