<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use App\Comment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    Schema::defaultStringLength(191);
    //make custom validator for captcha
    Validator::extend('recaptcha' , function ($attribute , $value , $parameters , $validator){
        // POST
        $client = new Client();
       // dd($attribute , $value , $parameters , $validator);
       //make validate captcha with gazzle
       $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret'),
                'response' => $value,
                'remoteip' => request()->ip()
            ]
        ]);
       //sent number of approved comment for view admin.section.header
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
//=====================================
        $response = json_decode($response->getBody());
        //  dd($response);
        return $response->success;
    });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
