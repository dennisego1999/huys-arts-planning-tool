<?php

namespace App\Http\Controllers;

use App\Models\User;

class ImpersonateController extends Controller
{
    public function __invoke(User $user)
    {
        if(auth()->check()) {
            //Impersonate user
            auth()->user()->impersonate($user);
        }

        //Redirect back
        return redirect()->back();
    }
}
