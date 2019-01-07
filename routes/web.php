<?php

use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Events\UserActivation;
use App\User;
use Illuminate\Support\Facades\Auth;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Validation\Validator;

//Route for main page
Route::get('/' , 'HomeController@index');
//Route::get('/articles' , 'ArticleController@index');
//Route::get('/courses' , 'CourseController@index');
// Explicit Binding for ArticleController and CourceController
Route::get('/articles/{articleSlug}' , 'ArticleController@single');
Route::get('/courses/{courseSlug}' , 'CourseController@single');
//---------------------

Route::post('/comment' , 'HomeController@comment');
Route::get('/user/active/email/{token}' , 'UserController@activation')->name('activation.account');
//download route('routeName', array)
Route::get('/download/{episode}','CourseController@download');

//Route::get('user/active/email/{token}','UserController@activation')->name('activation.account');
//login and regiester with goole
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');\
//for payement zarinpall;
Route::group(['middleware' => 'auth:web'] , function () {
    $this->post('/course/payment' , 'CourseController@payment');
    $this->get('/course/payment/checker' , 'CourseController@checker');

    $this->group(['prefix' => '/user/panel'] , function(){
        $this->get('/' , 'UserController@index')->name('user.panel');
        $this->get('/history' , 'UserController@history')->name('user.panel.history');
        $this->get('/vip' , 'UserController@vip')->name('user.panel.vip');
  
         $this->post('/payment' , 'UserController@vipPayment')->name('user.panel.vip.payment');
         $this->get('/checker' , 'UserController@vipChecker')->name('user.panel.vip.checker');
     });
  });


// namespace('Admin')->prefix('admin')
Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){

    $this->get('/panel','PanelController@index');
    $this->post('/panel/upload-image','PanelController@uploadImageSubject');
    $this->resources(['articles' => 'ArticleController']);
    $this->resources(['courses' => 'CourseController']);
    
    //comment section
    
    $this->get('comments/unsuccessful' , 'CommentController@unsuccessful');
    $this->resource('comments' , 'CommentController');
    //payment section
    
    $this->get('payments/unsuccessful' , 'PaymentController@unsuccessful');
    $this->resource('payments' , 'PaymentController');


    $this->resource('episodes' , 'EpisodeController');
    $this->resource('roles','RoleController');
    $this->resource('permissions','PermissionController');
    
    $this->group(['prefix'=>'users'],function(){
        $this->get('/','UserController@index');
        $this->resource('level','LevelManageController',['parameters'=>['level'=>'user']]);
        $this->delete('{user}/destroy','UserController@destroy')->name('users.destroy');
    });
});

       



Route::auth();
Route::group(['namespace' => 'Auth'] , function (){
    // Authentication Routes...
    $this->get('login', 'LoginController@showLoginForm')->name('login');
    $this->post('login', 'LoginController@login');
    $this->get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    $this->get('register', 'RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'ResetPasswordController@reset');
});

Route::post('/getDate',function(){
    //alert()->success('فعال سازی','لینک فعال سازی حساب به ایمیل شما ارسال شد.')->persistent('حله');
    $validator=\Validator::make(request()->all(),[
        'message'=>'required',
        'g-recaptcha-response'=>'recaptcha'
    ]);
    if($validator->fails()){
        return 'fail';
    }
    else{
        return request('message');
    }
    });
    Route::get('/home', 'HomeController@index')->name('home');
