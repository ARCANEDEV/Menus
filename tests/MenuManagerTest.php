<?php namespace Arcanedev\Menus\Tests;
use Arcanedev\Menus\Entities\Menu;
use Arcanedev\Menus\Entities\MenuItem;
use Arcanedev\Menus\MenusManager;

/**
 * Class     MenuManagerTest
 *
 * @package  Arcanedev\Menus\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuManagerTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  MenusManager  */
    private $manager;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->manager = new MenusManager;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->manager);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $managers = [
            new MenusManager,
            $this->app->make('arcanedev.menus.manager'),
            $this->app->make(\Arcanedev\Menus\Contracts\MenusManager::class),
        ];
        $expectations = [
            \Arcanedev\Menus\Contracts\MenusManager::class,
            \Arcanedev\Menus\MenusManager::class
        ];

        foreach ($managers as $manager) {
            /** @var MenusManager $manager */
            foreach ($expectations as $expected) {
                $this->assertInstanceOf($expected, $manager);
            }
            $this->assertFalse($manager->hasMenus());
        }
    }

    /** @test */
    public function it_can_make_menu()
    {
        $this->manager->make('public', function (Menu $menu) {
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
        });

        $this->assertTrue($this->manager->hasMenus());
    }
}
