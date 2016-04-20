<?php namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer(
            '*',
            function ($view) {
                $view->with('current_user', auth()->user());
            }
        );

        $this->app->bind(
            'App\Nrna\Repositories\Tag\TagRepositoryInterface',
            'App\Nrna\Repositories\Tag\TagRepository'
        );

        $this->app->bind(
            'App\Nrna\Repositories\Country\CountryRepositoryInterface',
            'App\Nrna\Repositories\Country\CountryRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\Question\QuestionRepositoryInterface',
            'App\Nrna\Repositories\Question\QuestionRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\Post\PostRepositoryInterface',
            'App\Nrna\Repositories\Post\PostRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\Answer\AnswerRepositoryInterface',
            'App\Nrna\Repositories\Answer\AnswerRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\CountryUpdate\UpdateRepositoryInterface',
            'App\Nrna\Repositories\CountryUpdate\UpdateRepository'
        );

        $this->app->bind(
            'App\Nrna\Repositories\Journey\JourneyRepositoryInterface',
            'App\Nrna\Repositories\Journey\JourneyRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\Place\PlaceRepositoryInterface',
            'App\Nrna\Repositories\Place\PlaceRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\CountryTag\CountryTagRepositoryInterface',
            'App\Nrna\Repositories\CountryTag\CountryTagRepository'
        );


    }
}