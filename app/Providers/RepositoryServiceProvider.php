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

    }
}