<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Course extends Model
{
    protected $guarded=[];
    protected $casts=[
        'images'=>'array'
    ];
    use Sluggable;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function path(){
        return "/courses/$this->slug"; 
    }
    public function setBodyAttribute($value)
    {
        $this->attributes['description'] = str_limit(preg_replace('/<[^>]*>/' , '' , $value) , 200);
        $this->attributes['body'] = $value;
    }
    public function episodes(){
        return $this->hasMany(Episode::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
