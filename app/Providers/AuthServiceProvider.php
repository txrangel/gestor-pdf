<?php

namespace App\Providers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Permission;
use App\Policies\ProfilePolicy;
use App\Policies\UserPolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Profile::class => ProfilePolicy::class,
        Permission::class => PermissionPolicy::class,
        Pdf::class => PdfPolicy::class,
        Txt::class => TxtPolicy::class,
        Request::class => RequestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}