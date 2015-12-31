<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
*/
// Authentication routes...

$router->group(
    ['namespace' => 'Api', 'prefix' => 'api'],
    function ($router) {
        $router->get('latest', 'LatestController@index');
        $router->get('trash', 'ApiController@getDeleted');
    }
);
