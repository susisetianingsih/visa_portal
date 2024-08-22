<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use App\Events\LabelDeleted;
use App\Listeners\UpdateAssessmentsVisibilityOnLabelDeletion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        LabelDeleted::class => [
            UpdateAssessmentsVisibilityOnLabelDeletion::class,
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role_id === 1;
        });
        Gate::define('vendor', function (User $user) {
            return $user->role_id === 2;
        });
        Gate::define('admin-vendor', function (User $user) {
            return $user->role_id === 1 || $user->role_id === 2;
        });
        Gate::define('admin-guest', function (User $user) {
            return $user->role_id === 1 || $user->role_id === 3;
        });
        Gate::define('vendor-guest', function (User $user) {
            return $user->role_id === 2 || $user->role_id === 3;
        });
        // Paginator::defaultView('pagination::default')
    }
}
