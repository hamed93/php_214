<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redis;
use App\Course;
class CourseController extends Controller
{
    public function single(Course $course)
    {
   //for count visit courses with redis    
     $course->increment('viewCount');
    //        Redis::incr("views.{$course->id}.courses");
    $comments = $course->comments()->where('approved' , 1)->where('parent_id', 0)->latest()->with('comments')->get();
    return view('Home.courses' , compact('course' , 'comments'));
    }
}
