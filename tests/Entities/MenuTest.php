<?php namespace Arcanedev\Menus\Tests\Entities;

use Arcanedev\Menus\Entities\Menu;
use Arcanedev\Menus\Entities\MenuItem;
use Arcanedev\Menus\Tests\TestCase;

/**
 * Class     MenuTest
 *
 * @package  Arcanedev\Menus\Tests\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $menu = Menu::make('main');

        $this->assertInstanceOf(Menu::class, $menu);
        $this->assertFalse($menu->hasItems());
        $this->assertEquals(0, $menu->count());
    }

    /** @test */
    public function it_can_add_items()
    {
        $menu = Menu::make('main');

        $menu->url($this->baseUrl, 'Home', ['class' => 'nav-link']);
        $menu->action(
            'Arcanedev\\Menus\\Tests\\Stubs\\PagesController@about',
            'About us', ['slug' => 'us'], ['class' => 'nav-link']
        );
        $menu->add([
            'url'        => $this->baseUrl . '/portfolio',
            'content'    => 'Portfolio',
            'attributes' => [
                'class' => 'nav-link'
            ]
        ]);
        $menu->route('public::contact', 'Contact us', [], ['class' => 'nav-link']);

        $this->assertEquals(4, $menu->count());
        foreach ($menu->all() as $item) {
            /** @var MenuItem $item */
            $this->assertTrue($item->isRoot());
            $this->assertFalse($item->hasChildren());
        }
    }

    /** @test */
    public function it_can_add_items_with_callback()
    {
        $menu = Menu::make('main', function (Menu $item) {
            $item->url($this->baseUrl, 'Home', ['class' => 'nav-link']);
            $item->action(
                'Arcanedev\\Menus\\Tests\\Stubs\\PagesController@about',
                'About us', ['slug' => 'us'], ['class' => 'nav-link']
            );
            $item->add([
                'url'        => $this->baseUrl . '/portfolio',
                'content'    => 'Portfolio',
                'attributes' => [
                    'class' => 'nav-link'
                ]
            ]);
            $item->route('public::contact', 'Contact us', [], ['class' => 'nav-link']);
        });

        $this->assertEquals(4, $menu->count());
        foreach ($menu->all() as $item) {
            /** @var MenuItem $item */
            $this->assertTrue($item->isRoot());
            $this->assertFalse($item->hasChildren());
        }
    }
}
