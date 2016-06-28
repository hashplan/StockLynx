<?php

namespace App\Providers;

use AdminTemplate;
use App\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Role::class => \App\Policies\RolePolicy::class,
        \App\Model\News::class => \App\Policies\NewsPolicy::class,
        \App\Model\Page::class => \App\Policies\PagesPolicy::class,
        \App\Model\Stocks::class => \App\Policies\StocksPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // Dynamically register permissions with Laravel's Gate.
        //
        // foreach ($this->getPermissions() as $permission) {
        //    $gate->define($permission->name, function ($user) use ($permission) {
        //        return $user->hasPermission($permission);
        //    });
        // }

        view()->composer(AdminTemplate::getViewPath('_partials.header'), function($view) {
            $view->getFactory()->inject(
                'navbar.right', view('auth.partials.navbar_admin', [
                    'user' => auth()->user()
                ])
            );
        });

        view()->composer(AdminTemplate::getViewPath('_partials.header'), function($view) {
            $view->getFactory()->inject(
                'navbar.valuation_market', view('auth.partials.valuation_market', [
                    'user' => auth()->user()
                ])
            );
        });

        view()->composer(AdminTemplate::getViewPath('_partials.header'), function($view) {
            $view->getFactory()->inject(
                'navbar.filtering_options', view('auth.partials.filtering_options', [
                    'user' => auth()->user()
                ])
            );
        });

        view()->composer(AdminTemplate::getViewPath('_partials.header'), function($view) {
            $view->getFactory()->inject(
                'navbar.actions', view('auth.partials.actions', [
                    'user' => auth()->user()
                ])
            );
        });

        view()->composer(AdminTemplate::getViewPath('_partials.footer'), function($view) {
            $view->getFactory()->inject(
                'footer.costs', view('auth.partials.footer_costs', [
                    'user' => auth()->user()
                ])
            );
        });
    }

    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
