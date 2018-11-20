<?php

use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\AdminController;






Route::namespace('Admin')->prefix('admin')->group(function(){

    $this->get('/panel','PanelController@index');
    
    $this->post('/panel/upload-image','PanelController@uploadImageSubject');
    
    $this->resources(['articles' => 'ArticleController']);
    $this->resources(['courses' => 'CourseController']);
    $this->resource('episodes' , 'EpisodeController');
});





