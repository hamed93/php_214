<?php

use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;






Route::namespace('Admin')->prefix('admin')->group(function(){

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





