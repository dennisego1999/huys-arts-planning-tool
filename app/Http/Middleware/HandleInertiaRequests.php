<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Abort logged-out
        if (Auth::guest()) {
            return parent::share($request);
        }

        // Get the shared data
        $data = array_merge(parent::share($request), [
            //General setup
            'locales' => fn () => $this->getLocales(),
            'notifications' => fn () => $this->getNotifications($request),
            'current_route_name' => $request->route()->getName(),
            'policies' => fn() => $this->getPolicies(),
            'flash' => $this->getSessionFlashing($request),
        ]);

        // Only on the initial load
        if (!$request->header('X-Inertia')) {
            $data['app_name'] = config('app.name');
            $data['translations'] = $this->getTranslations();
        }

        return $data;
    }

    private function getNotifications(Request $request): Collection
    {
        return $request->user()?->notifications ?: collect();
    }

    protected function getSessionFlashing(Request $request): array
    {
        // The default data to flash
        $flash = [
            'uuid' => (string) Str::uuid(),
            'success' => Session::get('success'),
            'error' => Session::get('error')
        ];

        // Run additional checks when logged-in
        if ($user = $request->user()) {
            // The user has no two-factor authentication
            if (!$user->hasEnabledTwoFactorAuthentication()) {
                // The user has still a valid grace period
                if ($user->is_unlocked) {
                    $flash['bannerType'] = 'warning';
                    $flash['bannerMessage'] = trans('auth.two_factor.time_remaining', [
                        'time' => $user->two_factor_grace_remaining
                    ]);
                }

                // The user his grace period is overdue
                if (!$user->is_unlocked) {
                    $flash['bannerType'] = 'danger';
                    $flash['bannerMessage'] = trans('auth.two_factor.time_overdue', [
                        'time' => $user->two_factor_grace_remaining
                    ]);
                }
            }
        }

        return $flash;
    }

    protected function getTranslations(): array
    {
        // Get the locale settings
        $locale = config('app.locale');
        $fallbackLocale = config('app.fallback_locale');

        // Get the files that should be shared with the SPA
        $files = [
            'spa',
        ];

        // Load the translations of the current locale
        foreach ($files as $file) {
            $translations[$locale][$file] = trans($file);
        }

        // Add the fallback translations when required
        if ($locale !== $fallbackLocale) {
            foreach ($files as $file) {
                $translations[$fallbackLocale][$file] = trans($file, [], $fallbackLocale);
            }
        }

        return $translations;
    }

    protected function getLocales(): array
    {
        return [
            'currentLocale' => config('app.locale')
        ];
    }

    private function getPolicies()
    {
        return [
            'can' => [
                'manageUsers' => auth()->check() ? auth()->user()->can('manage-users', User::class) : false,
                'manageTranslations' => auth()->check() ? auth()->user()->can('manage-translations', User::class) : false,
                'manageDanceGroups' => auth()->check() ? auth()->user()->can('manage-dance-groups', User::class) : false,
                'manageCalendar' => auth()->check() ? auth()->user()->can('manage-calendar', User::class) : false,
                'impersonate' => auth()->check() ? auth()->user()->can('impersonate', User::class) : false,
            ]
        ];
    }
}
