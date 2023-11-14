<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return auth()->user()->unreadNotifications
            ->map
            ->only(['id','data']);
    }

    public function read(DatabaseNotification $notification)
    {
        $this->authorize('view', $notification);
        $notification->markAsRead();
    }
}
