<?php

namespace App\Providers;

use App\Models\Purchase;
use App\Models\UserSkill;
use App\Policies\PurchasePolicy;
use App\Policies\UserSkillPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        UserSkill::class => UserSkillPolicy::class,
        Purchase::class => PurchasePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
