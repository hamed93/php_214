<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Egulias\EmailValidator\Warning\Comment;
use Illuminate\Support\Carbon;
//use Faker\Provider\el_GR\Payment;

class User extends Authenticatable
{
    use Notifiable,HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active','viptime'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //for findout user vip or not ?
    public function isActive(){
        return $this->viptime > Carbon::now() ? true : false ;

    }
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
    public function payments(){
        return $this->hasmany(Payment::class);
    }
    //user ghablan course ro kharide ya na?
    public function checkLearning($course)
    {
        return !! Learning::where('user_id' , $this->id)->where('course_id' , $course->id)->first();
        // !! yani age object bud true age nabud fasle return kon
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
