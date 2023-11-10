<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class ImpersonateController extends Controller
{
    public function __invoke(User $user)
    {
        if(auth()->check()) {
            //Impersonate user
            auth()->user()->impersonate($user);
        }

        //Redirect back with hard page reload
        return Inertia::location(route('dashboard'));
    }
}
