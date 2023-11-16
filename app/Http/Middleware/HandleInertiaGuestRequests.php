<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleInertiaGuestRequests extends HandleInertiaRequests
{
    public function share(Request $request): array
    {
        // Abort logged-in
        if (Auth::check()) {
            return [];
        }

        // Get the shared data
        $data = [
            ...parent::share($request),
            'locales' => fn() => $this->getLocales()
        ];

        // Only on the initial load
        if (!$request->inertia()) {
            $data['app_name'] = config('app.name');
            $data['translations'] = $this->getTranslations();
        }

        return $data;
    }
}
