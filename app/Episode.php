<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class Episode extends Model
{
    protected $guarded=[];
     public function course(){
         return $this->belongsTo(Course::class);
     }
     public function path(){
         return "/courses/{$this->course->slug}/episode/{$this->number}";
     }
     public function download()
     {
         if(! auth()->check()) return '#';
 
         $status = false;
         switch ($this->type) {
             case 'free' :
                 $status = true;
                 break;
             case 'vip' :
                 if(user()->isActive()) $status = true;
                 break;
             case 'cash' :
                 if(user()->checkLearning($this->course)) $status = true;
                 break;
         }
         $timestamp = Carbon::now()->addHours(5)->timestamp;
         $hash = Hash::make('fds@#T@#56@sdgs131fasfq' . $this->id . request()->ip() . $timestamp);
 
         return $status ? "/download/$this->id?mac=$hash&t=$timestamp" : "#";
     }
}
