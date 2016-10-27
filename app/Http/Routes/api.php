<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
*/
use App\Http\Middleware\StoreApiLog;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With,token");

$router->group(
    ['namespace' => 'Api', 'middleware' => StoreApiLog::class, 'prefix' => 'api'],
    function ($router) {
        $router->get('latest', 'LatestController@index');
        $router->get('trash', 'ApiController@getDeleted');
        $router->get('country', 'Country\\CountryController@index');
        $router->post('sync', 'Post\\PostController@sync');
        $router->get('post/{id}', 'Post\\PostController@show')->where('id', '[0-9]+');
        $router->get('posts', ['as' => 'api.posts', 'uses' => 'Post\\PostController@index']);
        $router->get('posts/{id}', 'Post\\PostController@detail')->where('id', '[0-9]+');
        $router->get('destinations', 'Category\\CategoryController@destination');
        $router->get('destinations/{id}/subcategory', 'Category\\CategoryController@journeySubcategory');
        $router->get('journey', 'Category\\CategoryController@journey');
        $router->get('journey/{id}/subcategory', 'Category\\CategoryController@journeySubcategory');
        $router->get('category/{id}', 'Category\\CategoryController@show')->where('id', '[0-9]+');
        $router->get('category', 'Category\\CategoryController@index');
        $router->get('tags', 'TagController@index');
        $router->post('/post/{id}/favorite', 'Post\\PostController@favorite')->where('id', '[0-9]+');
        $router->post('/post/{id}/share', 'Post\\PostController@share')->where('id', '[0-9]+');
        $router->get('screen/home', 'Screen\\HomeController@index');
        $router->get('screen/destination/{id}', 'Screen\\DestinationController@destination');
        $router->get('screen/journey', 'Screen\\DestinationController@journey');
        $router->get('podcasts', 'Radio\\RadioController@index');
    }
);