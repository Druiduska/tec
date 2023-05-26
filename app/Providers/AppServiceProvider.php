<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\Boats\BoatsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->bind(BoatsRepository::class, function (){
//            $message = app('model.message_provider');
//            return new BoatsRepository();
//        });
    }
}
