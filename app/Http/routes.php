<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    $trackPath = '/home/manoj/annie-hi.mp3';
    $params = array('track[name]' => 'Cool remix');
    dd(Soundcloud::getAuthUrl());
    $response = Soundcloud::upload($trackPath, $params);
    dd($response->getHeaders());
    dd(Soundcloud::getAuthUrl());
    exit;
    return view('welcome');
});
