<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class RoleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view)
        {
            $user = Auth::user();

            if (!isset($user)) 
                return;

            $roles = $user->roles;
            
            $userRole = null;

            if ($roles)
            {
                if ($roles->contains('name', Role::CAPTAIN))
                {
                    $userRole = Role::CAPTAIN;
                }
                elseif ($roles->contains('name', Role::OFFICIAL))
                {
                    $userRole = Role::OFFICIAL;
                }
                elseif ($roles->contains('name', Role::STAFF))
                {
                    $userRole = Role::STAFF;
                }
                elseif ($roles->contains('name', Role::RESIDENT))
                {
                    $userRole = Role::RESIDENT;
                }
            }

            $view->with('_user_role', $userRole);
        });
    }

    public function register()
    {
        //
    }
}
