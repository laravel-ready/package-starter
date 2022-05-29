<?php

namespace LaravelReady\PackageStartser;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use LaravelReady\PackageStartser\Services\PackageService;
use LaravelReady\PackageStartser\Http\Middleware\PublicStoreMiddleware;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(Router $router): void
    {
        $this->bootPublishes();

        $this->loadMiddlewares($router);

        $this->loadRoutes();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'package-name-views');
    }

    public function register(): void
    {
        $this->registerConfigs();

        $this->registerDisks();

        // register package service
        $this->app->singleton('package-name', function () {
            return new PackageService();
        });
    }

    /**
     * Boot publishes
     */
    private function bootPublishes(): void
    {
        // package configs
        $this->publishes(paths: [
            __DIR__ . '/../config/package-name.php' => $this->app->configPath('package-name.php'),
        ], groups: 'package-name-config');

        // migrations
        $migrationsPath = __DIR__ . '/../database/migrations/';

        $this->publishes([
            $migrationsPath => database_path('migrations/vendor/package-name')
        ], 'package-name-migrations');

        $this->loadMigrationsFrom($migrationsPath);

        // assets
        $assetPath = Config::get('theme-store.assets_path', 'assets/store');

        $this->publishes([
            __DIR__ . '/../resources/public/' => public_path($assetPath)
        ], 'theme-store-assets');

        // views
        $this->publishes([
            __DIR__ . '/../resources/views/' => base_path('resources/views/vendor/theme-store')
        ], 'theme-store-views');
    }

    /**
     * Register package configs
     */
    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/package-name.php', 'package-name');
    }

    /**
     * Add package specific disks for file upload
     */
    private function registerDisks()
    {
        // public disk
        Config::set("filesystems.disks.theme_store_public", [
            'driver' => 'local',
            'root' => storage_path('app/public/theme-store'),
            'url' => request()->getSchemeAndHttpHost() . '/storage/theme-store',
            'visibility' => 'public',
        ]);

        // private disk
        Config::set("filesystems.disks.theme_store_private", [
            'driver' => 'local',
            'root' => storage_path('app/theme-store'),
            'visibility' => 'private',
        ]);
    }

    /**
     * Load api, web and panel routes
     */
    private function loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
    }

    /**
     * Load custom middlewares
     *
     * @param Router $router
     */
    private function loadMiddlewares(Router $router): void
    {
        $router->aliasMiddleware('theme-store-public', PublicStoreMiddleware::class);
    }
}
