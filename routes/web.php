<?php

use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\AdminController;





Route::namespace('Admin')->prefix('admin')->group(function(){

    $this->get('/panel','PanelController@index');
    
    // $this->get('/articles','ArticleController@index');
    
    $this->resources(['articles' => 'ArticleController']);
});




