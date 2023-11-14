<?php

namespace App\Http\Controllers;

use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        if(auth()->check()) {
            $user = auth()->user();
            $user->notify(new WelcomeNotification());
        }

        return Inertia::render('Dashboard/Index');
    }
}
