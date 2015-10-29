<?php namespace Arcanedev\Menus\Tests;

use Arcanedev\Menus\Entities\Menu;
use Arcanedev\Menus\Entities\MenuItem;
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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
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

    /**
     * Make a main menu for tests.
     *
     * @param  Menu  $menu
     *
     * @return Menu
     */
    protected function populateMenu(Menu $menu)
    {
        $menu->url($this->baseUrl, 'Home', ['class' => 'nav-link']);
        $menu->route('public::about', 'About', ['slug' => 'about-us'], ['class' => 'nav-link']);
        $menu->action('ContactController@getForm', 'Contact', ['slug' => 'contact-us'], ['class' => 'nav-link']);
        $menu->divider();
        $menu->header('This is a header');
        $menu->dropdown('Categories', function (MenuItem $item) {
            $item->url($this->baseUrl . '/categories/category-1', 'Category 1', ['class' => 'nav-link']);
            $item->route('public::category.show', 'Category 2', ['category-2'], ['class' => 'nav-link']);
            $item->action('CategoriesController@show', 'Category 3', ['category-3'], ['class' => 'nav-link']);
            $item->add([
                'url'        => $this->baseUrl . '/categories/category-4',
                'content'    => 'Category 4',
                'attributes' => ['class' => 'nav-link'],
            ]);
            $item->divider();
            $item->header('This is a header');
            $item->dropdown('Sub-categories', function (MenuItem $item) {
                $item->url($this->baseUrl . '/categories/category-1/sub-categories/sub-category-1', 'Sub-Category 1', ['class' => 'nav-link']);
                $item->route('public::category.sub.show', 'Sub-Category 2', ['category-1', 'sub-category-2'], ['class' => 'nav-link']);
                $item->action('CategoriesController@showSub', 'Sub-Category 3', ['category-1', 'sub-category-3'], ['class' => 'nav-link']);
                $item->add([
                    'url'        => $this->baseUrl . '/categories/category-1/sub-categories/sub-category-4',
                    'content'    => 'Sub-Category 4',
                    'attributes' => ['class' => 'nav-link'],
                ]);
            });
        });

        return $menu;
    }
}
