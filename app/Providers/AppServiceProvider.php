<?php

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

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
        RedirectResponse::macro('withFlash', function ($title, $message = '', $style = 'success') {
            return $this->with('flash-notification', [
                'title' => $title,
                'message' => $message,
                'style' => $style,
                'time' => time(),
            ]);
        });
    }
}
