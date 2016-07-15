<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
*/
use App\Http\Middleware\StoreApiLog;
header('Access-Control-Allow-Origin: *');
$router->group(
    ['namespace' => 'Api', 'middleware' => StoreApiLog::class, 'prefix' => 'api'],
    function ($router) {
        $router->get('latest', 'LatestController@index');
        $router->get('trash', 'ApiController@getDeleted');
        $router->get('country', 'Country\\CountryController@index');
        $router->post('sync', 'Post\\PostController@sync');
        $router->get('post/{id}', 'Post\\PostController@show')->where('id', '[0-9]+');
        $router->get('posts', 'Post\\PostController@index');
        $router->get('posts/{id}', 'Post\\PostController@detail')->where('id', '[0-9]+');
    }
);