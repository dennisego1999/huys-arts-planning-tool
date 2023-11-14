<?php

namespace App\Providers;

use App\Models\DanceGroup;
use App\Models\Team;
use App\Models\User;
use App\Policies\DanceGroupPolicy;
use App\Policies\LanguageLinePolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\TranslationLoader\LanguageLine;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        DanceGroup::class => DanceGroupPolicy::class,
        LanguageLine::class => LanguageLinePolicy::class,
        Team::class => TeamPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
