<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Egulias\EmailValidator\Warning\Comment;

class User extends Authenticatable
{
    use Notifiable,HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function article()
    {
        return $this->hasMany(Article::class);    
    }
    public function activationCode(){
        return $this->hasMany(ActivationCode::class);
    }
    public function course()
    {
        return $this->hasMany(Course::class);    
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function comments(){
        return $this->hasmany(Comment::class);
    }

public function hasRole($role){
if(is_string($role)){
    return $this->roles->contains('name',$role);
}
return !! $role->intersect($this->role)->count();
}
     public function isAdmin(){
        return $this->level=='admin' ? true : false;
     }

}
