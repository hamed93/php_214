<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Redis;
class ArticleController extends Controller
{
    public function single(Article $article)
    {
        //for count visit articles with redis
        $article->increment('viewCount');
         $comments = $article->comments()->where('approved' , 1)->where('parent_id', 0)->latest()->with(['comments' => function($query) {
            $query->where('approved' , 1)->latest();
         }])->get();
        // return $comments;
//        Redis::incr("views.{$article->id}.articles");
        return view('Home.article' , compact('article' , 'comments'));
    }
}
