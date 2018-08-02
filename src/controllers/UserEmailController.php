<?php

namespace Bene\Weather\Controllers;

use Bene\Weather\UserEmail;
use Bene\Weather\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('email.email');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isSet = DB::table('user_emails')->where('email', $request->email)->first();
        if (!isset($isSet))
            UserEmail::create($request->all());

        $city = City::orderBy('created_at', 'DESC')->first();
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $city->city . '&APPID=6f3aa95336edac6e5b6296a6e5f37bf2');
        $res = json_decode($res->getBody()->getContents(), true);
        return view('weathers.index', ['res' => $res]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserEmail $userEmail
     * @return \Illuminate\Http\Response
     */
    public function show(UserEmail $userEmail)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserEmail $userEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(UserEmail $userEmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\UserEmail $userEmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserEmail $userEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserEmail $userEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserEmail $userEmail)
    {
        //
    }
}
