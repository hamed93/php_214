<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function index(){
      //dd(auth()->user());
         auth()->loginUsingId(1);
        $this->authorize('show-user');
        $users=User::latest()->paginate(20);
        return view('admin.users.all',compact('users'));
    }
    public function destroy(User $user){

        $user->delete();
        return back();
    }
}
