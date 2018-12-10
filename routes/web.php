<?php

use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Events\UserActivation;
use App\User;

Route::get('/',function(){
//event (new \App\Events\UserActivation(\App\User::find(3)));

return 'done';
});
Route::get('user/active/email/{token}','UserController@activation')->name('activation.account');



Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){

    $this->get('/panel','PanelController@index');
    
    $this->post('/panel/upload-image','PanelController@uploadImageSubject');
    
    $this->resources(['articles' => 'ArticleController']);
    $this->resources(['courses' => 'CourseController']);
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
// Route::group(['namespace' => 'Auth'] , function (){
//     // Authentication Routes...
//     $this->get('login', 'LoginController@showLoginForm')->name('login');
//     $this->post('login', 'LoginController@login');
//     $this->get('logout', 'LoginController@logout')->name('logout');

//     // Registration Routes...
//     $this->get('register', 'RegisterController@showRegistrationForm')->name('register');
//     $this->post('register', 'RegisterController@register');

//     // Password Reset Routes...
//     $this->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
//     $this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//     $this->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
//     $this->post('password/reset', 'ResetPasswordController@reset');
// });
