<?php namespace Arcanedev\Menus\Tests\Entities;

use Arcanedev\Menus\Entities\MenuAttributes;
use Arcanedev\Menus\Tests\TestCase;

/**
 * Class     MenuAttributesTest
 *
 * @package  Arcanedev\Menus\Tests\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuAttributesTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var MenuAttributes */
    private $attributes;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->attributes = new MenuAttributes;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->attributes);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\Collection::class,
            \Arcanedev\Support\Collection::class,
            \Arcanedev\Menus\Entities\MenuAttributes::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->attributes);
        }

        $this->assertTrue($this->attributes->isEmpty());
    }

    /** @test */
    public function it_can_fill_the_fillable_properties()
    {
        $properties = [
            'url'        => $this->baseUrl,
            'route'      => 'public::home',
            'title'      => 'Home',
            'name'       => 'public::home',
            'icon'       => 'fa fa-fw fa-home',
            'parent'     => null,
            'attributes' => ['color' => 'menu-item'],
            'active'     => true,
            'order'      => 1,
        ];

        $this->attributes = new MenuAttributes($properties);

        $this->assertCount(count($properties), $this->attributes);

        foreach ($properties as $name => $value) {
            $this->assertTrue($this->attributes->has($name));
            $this->assertEquals($value, $this->attributes->get($name));
        }
    }

    /** @test */
    public function it_can_ignore_other_properties()
    {
        $properties = [
            'onClick' => 'alert("Hello world");'
        ];

        $this->attributes = new MenuAttributes($properties);

        $this->assertTrue($this->attributes->isEmpty());
    }
}
