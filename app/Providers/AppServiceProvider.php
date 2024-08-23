<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * call resourceRoutes Macro
         *
         * @author Khaled
         */
        $this->resourceRoutes();

        /**
         * call apiResourceRoutes Macro
         *
         * @author Khaled
         */
        $this->apiResourceRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        // Blade::componentNamespace('app\\Core\\CoreComponents', 'Core.CoreComponents');

    }



    public function resourceRoutes()
    {
        Route::macro('resourceRoutes', function ($resource, $controller, $function = null) {
            Route::post($resource . '/update-status/{id}', [$controller, 'updateStatus'])->name($resource . '.update-status');

            Route::delete($resource . '/delete-all', [$controller, 'delete_all'])->name($resource . '.delete-all');
            Route::post($resource . '/trash-all', [$controller, 'trash_all'])->name($resource . '.trash-all');

            Route::get($resource . '/trash', [$controller, 'trash'])->name($resource . '.trash');
            Route::put($resource . '/restore/{id}', [$controller, 'restore'])->name($resource . '.restore');
            Route::delete($resource . '/force-delete/{id}', [$controller, 'forceDelete'])->name($resource . '.force-delete');

            Route::resource($resource, $controller);

            // Route::get($resource.'-datatable/list', [$controller, 'getDatatableIndex'])->name($resource.'.datatable');
            // Route::get($resource.'-trash-datatable/list', [$controller, 'getDatatableTrash'])->name($resource.'.trash-datatable');


            // Route::post($resource.'/update/{id}' , [$controller, 'update'])->name($resource.'update');

            // Route::patch($resource . '/delete/group', $controller . '@deleteGroup');
            // Route::match(["put", "patch"], "$resource/{id}/status", "$controller@updateStatus");
            // Route::match(["put", "patch"], "$resource/order/list", "$controller@order");
            // Route::match(["post", "patch"], (str_contains($resource, '-') ? str_replace('-', '_', $resource) : $resource) . "/import", "$controller@import");

            if (is_callable($function))
                Route::group(['prefix' => $resource], function () use ($function, $controller, $resource) {
                    call_user_func($function, $controller, $resource);
                });
            return $this;
        });
    }

    public function apiResourceRoutes()
    {
        Route::macro('apiResourceRoutes', function ($resource, $controller, $function = null) {
            Route::apiResource($resource, $controller);

            // Route::patch($resource . '/delete/group', $controller . '@deleteGroup');
            // Route::match(["put", "patch"], "$resource/{id}/status", "$controller@updateStatus");
            // Route::match(["put", "patch"], "$resource/order/list", "$controller@order");
            // Route::match(["post", "patch"], (str_contains($resource, '-') ? str_replace('-', '_', $resource) : $resource) . "/import", "$controller@import");

            if (is_callable($function))
                Route::group(['prefix' => $resource], function () use ($function, $controller, $resource) {
                    call_user_func($function, $controller, $resource);
                });
            return $this;
        });
    }
}
