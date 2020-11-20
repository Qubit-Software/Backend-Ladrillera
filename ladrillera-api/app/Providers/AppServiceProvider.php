<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FilesService;
use App\Service\DocumentoService;
use App\Service\EmpleadoService;
use App\Service\UserService;
use App\Service\UsuarioService;
use App\Service\ModulosService;
use App\Service\EmailService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        // DocumentoValidator::class => DocumentoValidator::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FilesService::class, function ($app) {
            return new FilesService();
        });

        $this->app->singleton(DocumentoService::class, function ($app) {
            return new DocumentoService();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        $this->app->singleton(UsuarioService::class, function ($app) {
            return new UsuarioService();
        });

        $this->app->singleton(EmpleadoService::class, function ($app) {
            return new EmpleadoService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
