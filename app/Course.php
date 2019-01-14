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
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
//search for Check box #endregion
public function scopeFilter($query)
{
    $category = request('category');
    if( isset($category) && trim($category) != '' && $category != 'all') {
        $query->whereHas('categories' , function ($query) use ($category) {
            $query->whereId($category);
        });
    }

    $type = request('type');
    if(isset($type) && trim($type) != '') {
        if(in_array($type , ['vip' , 'cash' , 'free'])) {
            $query->whereType($type);
        }
    }


    if(request('order') == '1') {
        $query->oldest();
    } else {
        $query->latest();
    }

    return $query;
}


}
