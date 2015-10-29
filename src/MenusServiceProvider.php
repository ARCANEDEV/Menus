<?php namespace Arcanedev\Menus;

use Arcanedev\Support\PackageServiceProvider;

/**
 * Class     MenusServiceProvider
 *
 * @package  Arcanedev\Menus
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenusServiceProvider extends PackageServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor  = 'arcanedev';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'menus';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer   = true;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerConfig();

        $this->registerMenuManagerService();
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();

        $this->publishes([
            $this->getConfigFile() => config_path("{$this->package}.php"),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanedev.menus.manager',
            \Arcanedev\Menus\Contracts\MenusManager::class,
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Services Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the MenusManager service.
     */
    private function registerMenuManagerService()
    {
        $this->singleton('arcanedev.menus.manager', function () {
            return new MenusManager;
        });

        $this->app->bind(
            \Arcanedev\Menus\Contracts\MenusManager::class,
            \Arcanedev\Menus\MenusManager::class
        );
    }
}
