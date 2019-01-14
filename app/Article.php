<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Laravel\Scout\Searchable;
class Article extends Model
{
    use Sluggable;
    use Searchable;
    
    protected $guarded=[];
    protected $casts=[
        'images'=>'array'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

  public function path(){
    return "/articles/$this->slug"; 
}
//function for alogolia search package 
public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'tags' => $this->tags,
            'create_at' => $this->created_at,
            'categories' => $this->categories
        ];
    }
// public function scopeSearch($query , $keywords)
// {

//     $keywords = explode(' ',$keywords);
//     foreach ($keywords as $keyword) {
//         $query->whereHas('categories' , function ($query) use ($keyword){
//             $query->where('name' , 'LIKE' , '%' . $keyword . '%' );
//         })
//             ->orWhere('title' , 'LIKE' , '%' . $keyword . '%')
//             ->orWhere('tags' , 'LIKE' , '%' . $keyword . '%');
//     }
//     return $query;
// }
public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}
public function categories(){
    
    return $this->belongsToMany(Category::class);

}
}
