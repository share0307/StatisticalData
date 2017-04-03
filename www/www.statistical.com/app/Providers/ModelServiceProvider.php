<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //关键词模型
        $this->app->bind('WordsModel',\App\Model\Words::class);
        //Comment模型
        $this->app->bind('CommentsModel',\App\Model\Comments::class);
    }
}
