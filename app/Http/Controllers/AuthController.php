<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function prosesLogin(Request $request)
    {
        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }

        $response = Http::post($apiHost . '/login', $request->all());

        $responseData = $response->json();

        if ($response->successful()) {
            $data =  $responseData['data']['user'];
            Alert::success('Success', $responseData['message']);
            $apiToken = $responseData['data']['api_token'];
            session([
                'api_token' => $apiToken,
                'user' => $data,
                ]);
            return redirect('/dashboard')->with('data', $data);
        } else {
            Alert::error('Error', $responseData['message']);
            return redirect('/login');
        }
    }

    public function register()
    {
        return view('auth.register', [
            'title' => 'Register',
        ]);
    }

    public function prosesRegister(Request $request)
    {

        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }

        $validated = $request->validate([
            'password' => 'required',
            'passwordConfirm' => 'required|same:password'
        ]);

        $response = Http::post($apiHost . '/register', $request->all());

        $responseData = $response->json();

        if ($response->successful()) {
            Alert::success('Success', $responseData['message']);
            return redirect('/login');
        } else {
            Alert::error('Error', $responseData['email']);
            return redirect('/register');
        }
    }

    public function logout(){

        Session::flush();
        return redirect('/login');
    }
}
