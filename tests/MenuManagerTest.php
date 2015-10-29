<?php namespace Arcanedev\Menus\Tests;

use Arcanedev\Menus\Entities\Menu;
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
    public function it_can_add_multiple_menus()
    {
        $this->assertFalse($this->manager->hasMenus());

        $this->manager->make('main', function (Menu $menu) {});

        $this->assertTrue($this->manager->hasMenus());
        $this->assertEquals(1, $this->manager->count());

        $this->manager->make('auth', function (Menu $menu) {});

        $this->assertTrue($this->manager->hasMenus());
        $this->assertEquals(2, $this->manager->count());
    }

    /** @test */
    public function it_can_make_menu()
    {
        $this->manager->make('main', function (Menu $menu) {
            $this->populateMenu($menu);
        });

        $this->assertTrue($this->manager->hasMenus());
    }

    /** @test */
    public function it_can_get_a_menu()
    {
        $this->manager->make('main', function (Menu $menu) {
            $this->populateMenu($menu);
        });

        $this->assertTrue($this->manager->hasMenus());
        $this->assertEquals(1, $this->manager->count());

        $menu = $this->manager->get('main');

        $this->assertInstanceOf(\Arcanedev\Menus\Entities\Menu::class, $menu);
    }
}
