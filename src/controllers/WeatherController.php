<?php

namespace Bene\Weather\Controllers;

use Bene\Weather\City;
use Bene\Weather\User;
use Bene\Weather\Weather;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index()
    {
        $city = City::orderBy('created_at', 'DESC')->first();
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $city->city . '&APPID=6f3aa95336edac6e5b6296a6e5f37bf2');
        $res = json_decode($res->getBody()->getContents(), true);
        return view('weathers.index', ['res' => $res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request)
    {
        City::create($request->all());
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $request->city . '&APPID=6f3aa95336edac6e5b6296a6e5f37bf2');
        $res = json_decode($res->getBody()->getContents(), true);
        return view('weathers.index', ['res' => $res]);
    }

    /**
     * Display the specified resource.
     *
     * @p
     * aram  \App\Weather $weather
     * @return \Psr\Http\Message\StreamInterface
     */
    public function show(Weather $weather)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Weather $weather
     * @return void
     */
    public function edit(Weather $weather)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function update(Request $request)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Weather $weather
     * @return void
     */
    public function destroy(Weather $weather)
    {
        //
    }
}
