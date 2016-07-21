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
            $router->get('destinations', 'Category\\CategoryController@destination');
            $router->get('destinations/{id}/subcategory', 'Category\\CategoryController@journeySubcategory');
            $router->get('journey', 'Category\\CategoryController@journey');
            $router->get('journey/{id}/subcategory', 'Category\\CategoryController@journeySubcategory');
            $router->get('category/{id}', 'Category\\CategoryController@show')->where('id', '[0-9]+');
    }
);