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
$router->group(
    ['middleware' => 'auth'],
    function () use ($router) {
        $router->get('/home', ['as' => 'home', 'uses' => 'Post\PostController@index']);
        $router->resource('post', 'Post\\PostController');
        $router->get('search', ['as' => 'search', 'uses' => 'Search\\SearchController@index']);
        $router->get('user/{id}/edit', ['as' => 'user.edit', 'uses' => 'User\\UserController@edit']);
        $router->patch('user/{id}', ['as' => 'user.update', 'uses' => 'User\\UserController@update']);
        $router->post(
            'journey/subcategory/delete',
            ['as' => 'journey.subcategory.delete', 'uses' => 'Journey\JourneyController@deleteSubcategory']
        );
    }
);

$router->group(
    ['middleware' => 'role:admin'],
    function () use ($router) {
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
        $router->resource('user', 'User\\UserController', ['except' => ['edit', 'update']]);
        $router->resource('section', 'Section\\SectionController');
        $router->resource('section.category', 'CategoryAttribute\\CategoryAttributeController');
        $router->resource('category', 'Category\\CategoryController');
        $router->resource('pushnotification', 'PushNotification\\PushNotificationController');
        $router->resource('rss', 'Rss\RssController');
        $router->get(
            'rssnewsfeeds/fetch',
            [
                'as'   => 'rssnewsfeeds.fetch',
                'uses' => 'RssNewsFeeds\RssNewsFeedsController@fetch',
            ]
        );
        $router->resource('rssnewsfeeds', 'RssNewsFeeds\RssNewsFeedsController');
        $router->resource('blocks', 'Block\\BlockController');
        $router->get(
            'mobile/screens',
            function () {
                return view('block.screens');
            }
        )->name('mobile.screens');
        $router->resource('notice', 'Notice\\NoticeController');
        $router->resource('rss_category', 'Rss\\RssCategoryController');
        $router->resource('pages', 'Page\\PageController');
        $router->resource('screen', 'Screen\\ScreenController');
        $router->resource('screen.feed', 'Screen\FeedController');
    }
);