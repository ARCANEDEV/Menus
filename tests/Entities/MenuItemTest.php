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
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var MenuItem */
    private $menuItem;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->menuItem = new MenuItem;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->menuItem);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(MenuItem::class, $this->menuItem);
        $this->assertEmpty($this->menuItem->getProperties());
        $this->assertCount(0, $this->menuItem->getChildren());
    }

    /** @test */
    public function it_can_make()
    {
        $properties     = $this->getHomeProperties();
        $this->menuItem = MenuItem::make($properties);

        $this->assertInstanceOf(MenuItem::class, $this->menuItem);
        $this->assertEquals($properties, $this->menuItem->getProperties());

        $array = $this->menuItem->toArray();

        $this->assertArrayHasKey('properties', $array);
        $this->assertEquals($properties, $array['properties']);

        $this->assertArrayHasKey('attributes', $array);
        $this->assertEquals(array_except($properties, ['active', 'icon']), $array['attributes']);

        $this->assertArrayHasKey('sub-items', $array);
        $this->assertEmpty($array['sub-items']);
    }

    /** @test */
    public function it_can_access_menu_item_attributes()
    {
        $properties     = $this->getHomeProperties();
        $this->menuItem = MenuItem::make($properties);

        foreach ($properties as $name => $value) {
            $this->assertEquals($value, $this->menuItem->{$name});
        }
    }

    /** @test */
    public function it_can_add_a_sub_item()
    {
        $this->menuItem->add([
            'url'   => 'about',
            'title' => 'About',
        ]);

        $this->assertCount(1, $this->menuItem->getChildren());

        $this->menuItem->add([
            'url'   => 'contact',
            'title' => 'Contact us',
        ]);

        $this->assertCount(2, $this->menuItem->getChildren());
    }

    /** @test */
    public function it_can_add_a_sub_item_by_child_method()
    {
        $this->menuItem->child([
            'url'   => 'about',
            'title' => 'About',
        ]);

        $this->assertCount(1, $this->menuItem->getChildren());

        $this->menuItem->child([
            'url'   => 'contact',
            'title' => 'Contact us',
        ]);

        $this->assertCount(2, $this->menuItem->getChildren());
    }

    /** @test */
    public function it_can_add_a_sub_item_by_route()
    {
        $this->menuItem->route('public::about', 'About');

        $this->assertCount(1, $this->menuItem->getChildren());

        $this->menuItem->route('public::contact', 'Contact us');

        $this->assertCount(2, $this->menuItem->getChildren());
    }

    /** @test */
    public function it_can_add_a_sub_item_by_url()
    {
        $this->menuItem->url('about', 'About');

        $this->assertCount(1, $this->menuItem->getChildren());

        $this->menuItem->url('contact', 'Contact us');

        $this->assertCount(2, $this->menuItem->getChildren());
    }

    /** @test */
    public function it_can_add_a_sub_item_by_dropdown()
    {
        $this->menuItem->dropdown('Services', 1, function (MenuItem $item) {
            $item->url('service-1', 'Service 1');
            $item->url('service-2', 'Service 2');
            $item->url('service-3', 'Service 3');
        });

        $children = $this->menuItem->getChildren();

        $this->assertCount(1, $children);

        $dropdown = $children->first();

        $this->assertCount(3, $dropdown->getChildren());
    }

    /** @test */
    public function it_can_add_header_sub_item()
    {
        $title  = 'Header item';
        $this->menuItem->addHeader($title);
        $header = $this->menuItem->getChildren()->get(0);

        $this->assertEquals('header', $header->name);
        $this->assertEquals($title,   $header->title);

        $title  = 'Second header';
        $this->menuItem->header($title);
        $header = $this->menuItem->getChildren()->get(1);

        $this->assertEquals('header', $header->name);
        $this->assertEquals($title,   $header->title);
    }

    /** @test */
    public function it_can_add_divider_sub_item()
    {
        $this->menuItem->addDivider();

        $divider = $this->menuItem->getChildren()->get(0);

        $this->assertEquals('divider', $divider->name);

        $this->menuItem->divider();

        $divider = $this->menuItem->getChildren()->get(1);

        $this->assertEquals('divider', $divider->name);
    }
}
