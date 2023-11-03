<?php

namespace App\Http\Middleware;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
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
        //Get the shared data
        $data = array_merge(parent::share($request), [
            //General setup
            'locales' => fn () => $this->getLocales(),
            'currentRouteName' => $request->route()->getName(),
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
            ],
            'policies' => fn() => $this->getPolicies(),
        ]);

        //Only on the initial load
        if (!$request->header('X-Inertia')) {
            $data['app_name'] = config('app.name');
            $data['translations'] = $this->getTranslations();
        }

        return $data;
    }

    protected function getTranslations(): array
    {
        //Get the locale settings
        $locale = config('app.locale');
        $fallbackLocale = config('app.fallback_locale');

        //Get the files that should be shared with the SPA
        $files = [
            'spa',
        ];

        //Load the translations of the current locale
        foreach ($files as $file) {
            $translations[$locale][$file] = trans($file);
        }

        //Add the fallback translations when required
        if ($locale !== $fallbackLocale) {
            foreach ($files as $file) {
                $translations[$fallbackLocale][$file] = trans($file, [], $fallbackLocale);
            }
        }

        return $translations;
    }

    private function getLocales(): array
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
            ]
        ];
    }
}
