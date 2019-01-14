<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Course;
use App\Comment;
use Illuminate\Support\Carbon;
use App\Jobs\SendMail;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   public function search()
   {
   $keywords=request('search');
    return $articles=Article::search($keywords)->latest()->get();
   }
     
   
   public function index()
    {
    
       $job=new SendMail(User::find(14),'salammm');
       dispatch($job);
       return 'done';
        if(cache()->has('articles')) {
            $articles = cache('articles');
        } else {
           $articles = Article::latest()->take(8)->get();
            cache(['articles' => $articles] , Carbon::now()->addMinutes(1));
        }

        if(cache()->has('courses')) {
            $courses = cache('courses');
        } else {
           $courses = Course::latest()->take(4)->get();
            cache(['courses' => $courses] , Carbon::now()->addMinutes(1));
        }

         return view('Home.index' , compact('articles' , 'courses'));
    
    }
    public function comment()
    {
        $this->validate(request(),[
            'comment' => 'required'
        ]);

       Comment::create(array_merge([
           'user_id' => auth()->user()->id
       ], \request()->all()));
//return \request()->all();

       // auth()->user()->comments()->create(\request()->all());
        return back();
    }
}
