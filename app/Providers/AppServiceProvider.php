<?php

namespace App\Providers;

use App\Models\Organization;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        /**
         * Whenever the 'components.layouts.nav' view is rendered, this code is executed.
         * Render with organization selected by user.
         */
        View::composer('components.layouts.nav', function($view) {
            $organization_id = session('organization_id');
            $organization = Organization::find($organization_id);
            $view->with(['organization' => $organization]);
        });

        User::observe(UserObserver::class);
    }
}
