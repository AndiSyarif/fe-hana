<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }

        $response = Http::get($apiHost . '/index');

        $data = '';
        if ($response->successful()) {
            $data = $response->json()['data'];
        }
        
        return view('point.point', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('point.point-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }

        $validated = $request->validate([
            'user_fullname' => 'required',
            'user_point' => 'required|numeric',
        ]);

        $response = Http::post($apiHost . '/store', $request->all());

        $responseData = $response->json();

        if ($response->successful()) {
            Alert::success('Success', $responseData['message']);
            return redirect('/point');
        } else {
            Alert::error('Error', $responseData['user_fullname'] ??  $responseData['user_point'] ??  $responseData['message']);
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }

        $response = Http::get($apiHost . '/show/'. $user_id);

        $data = $response->json()['data'];

        return view('point.point-edit',[
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }

        $validated = $request->validate([
            'user_fullname' => 'required',
            'user_point' => 'required|numeric',
        ]);

        $response = Http::post($apiHost . '/update/'.$user_id, $request->all());

        $responseData = $response->json();

        if ($response->successful()) {
            Alert::success('Success', $responseData['message']);
            return redirect('/point');
        } else {
            Alert::error('Error', $responseData['user_fullname'] ??  $responseData['user_point'] ??  $responseData['message']);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        if (strpos(url()->current(), 'localhost')) {
            $apiHost = env('API_HOST_LOCAL');
        } else {
            $apiHost = env('API_HOST_SERVER');
        }

        $response = Http::delete($apiHost . '/destroy/'. $user_id);

        $responseData = $response->json();

        if ($response->successful()) {
            Alert::error('Success', $responseData['message']);
            return redirect('/point');
        } else {
            Alert::error('Error', $responseData['message']);
            return back();
        }
    }
}
