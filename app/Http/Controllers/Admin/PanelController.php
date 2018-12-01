<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use App\Permission;
use App\Role;

class PanelController extends Controller
{
    public function index(){
       // Auth::logout();
        //Auth::logoutUsingId(3);
        
         
        //dd(auth()->user()->hasRole('manager'));
      //  return Role::whereName('manager')->first()->permissions()->sync([1,2];
        
        return view ('admin.panel');
    }
    
    //upload image with ckeditor
    public function uploadImageSubject(){
        $this->validate(request() , [
            'upload' => 'required|mimes:jpeg,png,bmp',
        ]);

        $year = Carbon::now()->year;
        $imagePath = "/upload/images/{$year}/";

        $file = request()->file('upload');
        $filename = $file->getClientOriginalName();

        if(file_exists(public_path($imagePath) . $filename)) {
            $filename = Carbon::now()->timestamp . $filename;
        }

        $file->move(public_path($imagePath) , $filename);
        $url = $imagePath . $filename;

        return "<script>window.parent.CKEDITOR.tools.callFunction(1 , '{$url}' , '')</script>";
    }
}
