<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * Este método registrará las rutas necesarias para emitir
     * tokens de acceso y revocar tokens de acceso, clientes y tokens de acceso personal
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        // Gate::define('viewWebSocketsDashboard', function ($user = null) {
        //     return in_array(
        //         $user->email,
        //         [
        //             //
        //         ],
        //     );
        // });
    }
}
