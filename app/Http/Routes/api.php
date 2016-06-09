<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
*/
use App\Http\Middleware\StoreApiLog;
$router->group(
    ['namespace' => 'Api', 'middleware' => StoreApiLog::class,'prefix' => 'api'],
    function ($router) {
        $router->get('latest', 'LatestController@index');
        $router->get('trash', 'ApiController@getDeleted');
        $router->get('country', 'Country\\CountryController@index');
        $router->post('sync', 'Post\\PostController@sync');
        $router->get('post/{id}', 'Post\\PostController@show')->where('id', '[0-9]+');
    }
);