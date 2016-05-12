<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
*/
// Authentication routes...
use App\Http\Middleware\StoreApiLog;
$router->group(
    ['namespace' => 'Api', 'middleware' => StoreApiLog::class,'prefix' => 'api'],
    function ($router) {
        $router->get('latest', 'LatestController@index');
        $router->get('trash', 'ApiController@getDeleted');
        $router->get('country', 'Country\\CountryController@index');
        $router->post('sync', 'Post\\PostController@sync');
    }
);


