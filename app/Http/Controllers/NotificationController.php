<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->unreadNotifications
            ->map
            ->only(['id','data']);
    }

    public function read(DatabaseNotification $notification)
    {
        // Authorize
        $this->authorize('view', $notification);

        // Mark as read
        $notification->markAsRead();
    }
}
