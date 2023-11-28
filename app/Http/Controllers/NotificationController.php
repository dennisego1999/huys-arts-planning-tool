<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadNotificationRequest;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function read(ReadNotificationRequest $request, Notification $notification)
    {
        // Authorize
        $this->authorize('send', $notification);

        // Validate request
        $request->validated();

        // Mark as read
        $notification->markAsRead();

        // Redirect to url
        if($notification['url']) {
            return redirect($notification['url'])->with('success', trans('spa.notifications.messages.mark_as_read'));
        }

        return redirect()->back()->with('success', trans('spa.notifications.messages.mark_as_read'));
    }
}
