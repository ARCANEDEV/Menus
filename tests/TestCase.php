<?php namespace Arcanedev\Menus\Tests;

use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\Menus\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->app->loadDeferredProviders();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Laravel Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Arcanedev\Menus\MenusServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->registerRoutes($app);
    }

    /**
     * Register routes for tests.
     *
     * @param  \Illuminate\Foundation\Application   $app
     */
    private function registerRoutes($app)
    {
        /** @var Router $router */
        $router = $app['router'];

        $router->group([
            'as'        => 'public::',
            'namespace' => 'Arcanedev\\Menus\\Tests\\Stubs',
        ], function (Router $router) {
            $router->get('/', [
                'as'   => 'home',
                'uses' => 'PagesController@index',
            ]);

            $router->get('about/{slug}', [
                'as'   => 'about',
                'uses' => 'PagesController@about',
            ]);

            $router->group(['prefix' => 'categories'], function (Router $router) {
                $router->get('{category_slug}', [
                    'as'   => 'category.show',
                    'uses' => 'PagesController@category',
                ]);

                $router->group([
                    'prefix' => '{category_slug}/sub-categories'
                ], function (Router $router) {
                    $router->get('{sub_category_slug}', [
                        'as'   => 'public::category.sub.show',
                        'uses' => 'PagesController@subCategory',
                    ]);
                });
            });

            $router->get('contact', [
                'as'   => 'contact',
                'uses' => 'PagesController@contact',
            ]);
        });
    }
}
