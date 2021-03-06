<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('show-comment',function($user){
        //     return $user->hasRole(Permission::whereName('show-comment')->first()->roles);
        // });
        
        
        // foreach($this->getPermissions() as $permission){

        //     Gate::define($permission->name ,function($user) use ($permission){
                
        //         return $user->hasRole($permission->roles);
        //     });

      //  }
        
    
    }
    // public function getPermissions(){
           
    
    //     return Permission::with('roles')->get();

    //  }
    protected function getPermissions()
{
    try {
        return Permission::with('roles')->get();
    } catch (\Exception $e) {
        return [];
    }
}


}

