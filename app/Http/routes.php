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

// Registration routes...
$router->get('auth/register', 'Auth\AuthController@getRegister');
$router->post('auth/register', 'Auth\AuthController@postRegister');

$router->resource('post', 'Post\\PostController');
$router->resource('question', 'Question\\QuestionController');
$router->resource('tag', 'Tag\\TagController');
$router->get('/home', ['as' => 'home', 'uses' => 'Post\PostController@index']);
$router->resource('country', 'Country\\CountryController');
$router->resource('answer', 'Answer\\AnswerController');

$router->get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

//ajax
$router->get(
    'ajax/question/answers',
    ['as' => 'ajax.question.answers', 'uses' => 'Question\QuestionController@questionAnswers']
);
