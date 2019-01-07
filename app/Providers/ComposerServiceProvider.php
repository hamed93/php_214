<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'app',
            'App\Http\Providers\ComposerServiceProvider'
        );
        view()->composer('admin.section.header' , function($view) {
            $commentUnsuccessfulCount = Comment::whereApproved(0)->count();
            $commentSuccessCount = Comment::whereApproved(1)->count();
    
            $paymentUnsuccessfulCount = Payment::wherePayment(0)->count();
            $paymentSuccessCount = Payment::wherePayment(1)->count();
            $view->with([
                'commentUnsuccessfulCount' => $commentUnsuccessfulCount,
                'commentSuccessfulCount' => $commentSuccessCount,
                'paymentSuccessCount' => $paymentSuccessCount,
                'paymentUnsuccessfulCount' => $paymentUnsuccessfulCount,
                ]);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
