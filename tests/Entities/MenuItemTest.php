<?php namespace Arcanedev\Menus\Tests\Entities;

use Arcanedev\Menus\Entities\MenuItem;
use Arcanedev\Menus\Tests\TestCase;

/**
 * Class     MenuItemTest
 *
 * @package  Arcanedev\Menus\Tests\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuItemTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $item         = new MenuItem([]);
        $expectations = [
            \Arcanedev\Menus\Entities\MenuItem::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $item);
        }

        $this->assertFalse($item->isRoot());
        $this->assertEmpty($item->getUrl());
        $this->assertEmpty($item->getIcon());
        $this->assertEmpty($item->getContent());
        $this->assertEmpty($item->attributes()->all());
        $this->assertFalse($item->hasChildren());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make()
    {
        $item         = MenuItem::make([]);
        $expectations = [
            \Arcanedev\Menus\Entities\MenuItem::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $item);
        }

        $this->assertFalse($item->isRoot());
        $this->assertEmpty($item->getUrl());
        $this->assertEmpty($item->getIcon());
        $this->assertEmpty($item->getContent());
        $this->assertEmpty($item->attributes()->all());
        $this->assertFalse($item->hasChildren());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_root_item()
    {
        $item = MenuItem::make([
            'root' => true,
        ]);

        $this->assertTrue($item->isRoot());
        $this->assertEmpty($item->getUrl());
        $this->assertEmpty($item->getIcon());
        $this->assertEmpty($item->getContent());
        $this->assertEmpty($item->attributes()->all());
        $this->assertFalse($item->hasChildren());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_fill_item_properties()
    {
        $item = MenuItem::make([]);

        $this->assertFalse($item->isRoot());
        $this->assertEmpty($item->getUrl());
        $this->assertEmpty($item->getIcon());
        $this->assertEmpty($item->attributes()->all());
        $this->assertFalse($item->hasChildren());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());

        $item->fill([
            'root'       => true,
            'url'        => $this->baseUrl,
            'icon'       => 'fa fa-home',
            'content'    => 'Home',
            'active'     => true,
            'attributes' => [
                'class'  => 'nav-link',
                'style'  => 'color: green; background: red;' // If you know what i mean.
            ]
        ]);

        $this->assertTrue($item->isRoot());
        $this->assertEquals($this->baseUrl, $item->getUrl());
        $this->assertNotEmpty($item->getIcon());
        $this->assertNotEmpty($item->getContent());
        $this->assertNotEmpty($item->attributes()->all());
        $this->assertFalse($item->hasChildren());
        $this->assertTrue($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_url_item()
    {
        $urls = [
            $this->baseUrl,
            $this->baseUrl . '/about',
            $this->baseUrl . '/contact',
            $this->baseUrl . '/categories/category-1',
        ];

        foreach ($urls as $url) {
            $item = MenuItem::make(compact('url'));

            $this->assertEquals($url, $item->getUrl());
            $this->assertEmpty($item->getIcon());
            $this->assertEmpty($item->getContent());
            $this->assertEmpty($item->attributes()->all());
            $this->assertFalse($item->hasChildren());
            $this->assertFalse($item->isActive());
            $this->assertFalse($item->isDivider());
        }
    }

    /** @test */
    public function it_can_make_route_item()
    {
        $routes = [
            [
                'expected' => $this->baseUrl,
                'route'    => 'public::home',
                'params'   => []
            ],[
                'expected' => $this->baseUrl . '/about/us',
                'route'    => 'public::about',
                'params'   => ['us']
            ],[
                'expected' => $this->baseUrl . '/contact',
                'route'    => 'public::contact',
                'params'   => []
            ]
        ];

        foreach ($routes as $route) {
            $expected = $route['expected'];
            $route    = [$route['route'], $route['params']];
            $item     = MenuItem::make(compact('route'));

            $this->assertEquals($expected, $item->getUrl());
            $this->assertEmpty($item->getIcon());
            $this->assertEmpty($item->getContent());
            $this->assertEmpty($item->attributes()->all());
            $this->assertFalse($item->hasChildren());
            $this->assertFalse($item->isActive());
            $this->assertFalse($item->isDivider());
        }
    }

    /** @test */
    public function it_can_make_action_item()
    {
        $controller = 'Arcanedev\\Menus\\Tests\\Stubs\\PagesController';
        $actions   = [
            [
                'expected' => $this->baseUrl,
                'action'   => $controller . '@index',
                'params'   => []
            ],[
                'expected' => $this->baseUrl . '/about/us',
                'action'   => $controller . '@about',
                'params'   => ['us']
            ],[
                'expected' => $this->baseUrl . '/contact',
                'action'   => $controller . '@contact',
                'params'   => []
            ]
        ];

        foreach ($actions as $action) {
            $expected = $action['expected'];
            $action   = [$action['action'], $action['params']];
            $item     = MenuItem::make(compact('action'));

            $this->assertEquals($expected, $item->getUrl());
            $this->assertEmpty($item->getIcon());
            $this->assertEmpty($item->getContent());
            $this->assertEmpty($item->attributes()->all());
            $this->assertFalse($item->hasChildren());
            $this->assertFalse($item->isActive());
            $this->assertFalse($item->isDivider());
        }
    }

    /** @test */
    public function it_can_make_item_with_icon()
    {
        $url     = $this->baseUrl;
        $icon    = 'fa fa-home';
        $content = 'Home';
        $item    = MenuItem::make(compact('url', 'icon', 'content'));

        $this->assertEquals($url, $item->getUrl());
        $this->assertEquals('<i class="' . $icon . '"></i>', $item->getIcon());
        $this->assertEquals($content, $item->getContent());
        $this->assertEmpty($item->attributes()->all());
        $this->assertFalse($item->hasChildren());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_item_with_attributes()
    {
        $url        = $this->baseUrl;
        $content    = 'Home';
        $attributes = [
            'class'   => 'nav-link'
        ];

        $item = MenuItem::make(compact('url', 'content', 'attributes'));

        $this->assertEquals($url, $item->getUrl());
        $this->assertEquals($content, $item->getContent());
        $this->assertEquals($attributes, $item->attributes()->all());
        $this->assertFalse($item->hasChildren());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_item_add_children()
    {
        $item = MenuItem::make([
            'root'    => true,
            'url'     => $this->baseUrl,
            'content' => 'Home',
            'active'  => true,
        ], function (MenuItem $subItem) {
            $subItem->add([
                'url'     => $this->baseUrl . '/about/us',
                'content' => 'About us',
            ]);
            $subItem->add([
                'url'     => $this->baseUrl . '/contact',
                'content' => 'Contact',
            ]);
        });

        $this->assertTrue($item->hasChildren());
        $this->assertCount(2, $item->children());
        $this->assertEmpty($item->attributes()->all());
        $this->assertTrue($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_url_item_with_children()
    {
        $item = MenuItem::make([
            'root'    => true,
            'url'     => $this->baseUrl,
            'content' => 'Home',
            'active'  => true,
        ], function (MenuItem $subItem) {
            $subItem->url($this->baseUrl . '/about/us', 'About us');
            $subItem->url($this->baseUrl . '/contact', 'Contact');
        });

        $this->assertTrue($item->hasChildren());
        $this->assertCount(2, $item->children());
        $this->assertEmpty($item->attributes()->all());
        $this->assertTrue($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_route_item_with_children()
    {
        $item = MenuItem::make([
            'root'    => true,
            'route'   => 'public::home',
            'content' => 'Home',
        ], function (MenuItem $subItem) {
            $subItem->route('public::about', 'About us', ['slug' => 'us']);
            $subItem->route('public::contact', 'Contact');
        });

        $this->assertTrue($item->hasChildren());
        $this->assertCount(2, $item->children());
        $this->assertEmpty($item->attributes()->all());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_action_item_with_children()
    {
        $controller = 'Arcanedev\\Menus\\Tests\\Stubs\\PagesController';

        $item = MenuItem::make([
            'root'    => true,
            'action'  => [$controller . '@index'],
            'content' => 'Home',
        ], function (MenuItem $subItem) use ($controller) {
            $subItem->action($controller . '@about', 'About us', ['slug' => 'us']);
            $subItem->action($controller . '@contact', 'Contact');
        });

        $this->assertTrue($item->hasChildren());
        $this->assertCount(2, $item->children());
        $this->assertEmpty($item->attributes()->all());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_cant_get_url_from_route_item_with_children()
    {
        $item = MenuItem::make([
            'root'    => true,
            'route'   => 'public::home',
            'content' => 'Home',
        ], function (MenuItem $subItem) {
            $subItem->route('public::about', 'About us', ['slug' => 'us']);
            $subItem->route('public::contact', 'Contact');
        });

        $this->assertEquals('#', $item->getUrl());
        $this->assertFalse($item->isActive());
        $this->assertFalse($item->isDivider());
    }

    /** @test */
    public function it_can_make_divider_item()
    {
        $item = MenuItem::make(['type' => 'divider']);

        $this->assertTrue($item->isDivider());
        $this->assertFalse($item->isActive());
    }

    /** @test */
    public function it_can_make_divider_between_children()
    {
        $item = MenuItem::make([
            'root'    => true,
            'route'   => 'public::home',
            'content' => 'Home',
        ], function (MenuItem $subItem) {
            $subItem->route('public::about', 'About us', ['slug' => 'us']);
            $subItem->route('public::about', 'ARCANEDEV', ['slug' => 'arcanedev']);
            $subItem->divider();
            $subItem->route('public::contact', 'Contact');
        });

        $this->assertEquals('#', $item->getUrl());
        $this->assertFalse($item->isDivider());

        $divider = $item->children()->get(2);
        $this->assertTrue($divider->isDivider());
    }

    /** @test */
    public function it_can_make_header_between_children()
    {
        $item = MenuItem::make([
            'root'    => true,
            'route'   => 'public::home',
            'content' => 'Home',
        ], function (MenuItem $subItem) {
            $subItem->header('ARCANEDEV');
            $subItem->route('public::about', 'About us', ['slug' => 'us']);
            $subItem->route('public::about', 'ARCANEDEV', ['slug' => 'arcanedev']);
            $subItem->header('Other');
            $subItem->route('public::contact', 'Contact');
        });

        $this->assertEquals('#', $item->getUrl());
        $this->assertFalse($item->isDivider());

        $header = $item->children()->get(0);
        $this->assertTrue($header->isHeader());

        $header = $item->children()->get(3);
        $this->assertTrue($header->isHeader());
    }

    /** @test */
    public function it_can_make_dropdown_menu_item()
    {
        $item = MenuItem::make([
            'root'    => true,
            'route'   => 'public::home',
            'content' => 'Home',
        ], function (MenuItem $subItem) {
            $subItem->dropdown('Categories', function (MenuItem $dropdown) {
                $dropdown->route('public::category.show', 'Category 1', ['category-1']);
                $dropdown->route('public::category.show', 'Category 2', ['category-2']);
                $dropdown->route('public::category.show', 'Category 3', ['category-3']);
            });
        });

        $this->assertCount(1, $item->children());

        $dropdown = $item->children()->first();

        $this->assertTrue($dropdown->isDropdown());
        $this->assertCount(3, $dropdown->children());
    }
}
