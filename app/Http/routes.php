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
// Authentication routes...
$router->get('/', 'Auth\AuthController@getLogin');
$router->get('/auth/login', 'Auth\AuthController@getLogin');
$router->post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
$router->get('auth/logout', 'Auth\AuthController@getLogout');
$router->get('/home', ['as' => 'home', 'uses' => 'Post\PostController@index']);

$router->resource('post', 'Post\\PostController');

$router->post(
    'journey/subcategory/delete',
    ['as' => 'journey.subcategory.delete', 'uses' => 'Journey\JourneyController@deleteSubcategory']
);


$router->group(['middleware' => 'role:admin'], function () use($router) {
    $router->post('sort', '\Rutorika\Sortable\SortableController@sort');
    $router->resource('question', 'Question\\QuestionController');
    $router->resource('tag', 'Tag\\TagController');
    $router->resource('country', 'Country\\CountryController');
    $router->resource('answer', 'Answer\\AnswerController');
    $router->resource('update', 'Country\\UpdateController');
    $router->resource('journey', 'Journey\\JourneyController');

    $router->get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    //ajax
    $router->get(
        'ajax/question/answers',
        ['as' => 'ajax.question.answers', 'uses' => 'Question\QuestionController@questionAnswers']
    );
    $router->resource('place', 'Place\\PlaceController');
    $router->resource('countrytag', 'CountryTag\\CountryTagController');
    $router->resource('apilogs', 'Api\\ApiLog\\ApiLogController');
    $router->resource('user', 'User\\UserController');
    $router->resource('section', 'Section\\SectionController');
    $router->resource('section.category', 'CategoryAttribute\\CategoryAttributeController');
    $router->resource('catagory', 'Category\\CatagoryController');
});

