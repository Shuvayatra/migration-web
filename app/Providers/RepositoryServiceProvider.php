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
        $this->app->bind(
            'App\Nrna\Repositories\ApiLog\ApiLogRepositoryInterface',
            'App\Nrna\Repositories\ApiLog\ApiLogRepository');
        $this->app->bind(
            'App\Nrna\Repositories\User\UserRepositoryInterface',
            'App\Nrna\Repositories\User\UserRepository'
        );

        $this->app->bind(
            'App\Nrna\Repositories\Section\SectionRepositoryInterface',
            'App\Nrna\Repositories\Section\SectionRepository'
        );

        $this->app->bind(
            'App\Nrna\Repositories\CategoryAttribute\CategoryAttributeRepositoryInterface',
            'App\Nrna\Repositories\CategoryAttribute\CategoryAttributeRepository'
        );

        $this->app->bind(
            'App\Nrna\Repositories\Category\CategoryRepositoryInterface',
            'App\Nrna\Repositories\Category\CategoryRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\PushNotification\PushNotificationRepositoryInterface',
            'App\Nrna\Repositories\PushNotification\PushNotificationRepository'
        );

        $this->app->bind(
            'App\Nrna\Repositories\Rss\RssRepositoryInterface',
            'App\Nrna\Repositories\Rss\RssRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\RssNewsFeeds\RssNewsFeedsRepositoryInterface',
            'App\Nrna\Repositories\RssNewsFeeds\RssNewsFeedsRepository'
        );
        $this->app->bind(
            'App\Nrna\Repositories\Block\BlockRepositoryInterface',
            'App\Nrna\Repositories\Block\BlockRepository'
        );

        $this->app->bind(
            'App\Nrna\Repositories\Screen\ScreenRepositoryInterface',
            'App\Nrna\Repositories\Screen\ScreenRepository'
        );
    }
}