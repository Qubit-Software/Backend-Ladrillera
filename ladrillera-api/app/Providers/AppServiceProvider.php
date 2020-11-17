<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FilesService;
use App\Service\DocumentoService;

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
