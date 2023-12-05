<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }
        //user
        $responseUser = Http::get($apiHost . '/user');

        $dataUser = $responseUser->json()['data'];

        $countUser = count($dataUser);

        //point
        $responsepoint = Http::get($apiHost . '/index');

        $dataPoint = $responsepoint->json()['data'];

        $countPoint = count($dataPoint);

        return view('dashboard.dashboard', [
            'user' =>  $countUser,
            'point' => $countPoint
        ]);
    }
}
