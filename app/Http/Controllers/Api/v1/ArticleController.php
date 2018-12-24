<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    //controller for API
    public function articles()
    {
       // $articles=Article::latest()->get();
        $articles = Article::select('title' , 'slug' , 'description' , 'user_id')->latest()->get();
        return response(['data' => ['articles' => $articles ] , 'status' => 200] , 200);
    }

    public function comment(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required',
            'comment' => 'required'
        ]);

        if($validator->fails()) {
            return response(['data' => $validator->errors()->all() , 'status' => 403] , 403);
        }
    }
}
