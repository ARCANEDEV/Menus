<?php namespace Arcanedev\Menus\Tests\Entities;

use Arcanedev\Menus\Entities\MenuItemAttributes;
use Arcanedev\Menus\Tests\TestCase;

/**
 * Class     MenuItemAttributesTest
 *
 * @package  Arcanedev\Menus\Tests\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuItemAttributesTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var MenuItemAttributes */
    private $attributes;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->attributes = new MenuItemAttributes;
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
            \Arcanedev\Menus\Entities\MenuItemAttributes::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->attributes);
        }
    }

    /** @test */
    public function it_can_render()
    {
        $this->attributes = MenuItemAttributes::make([
            'id'    => 'id',
            'name'  => 'name',
            'class' => 'class other-class',
            'null'  => null,
            'required'
        ]);

        $expected = 'id="id" name="name" class="class other-class" required="required"';

        $this->assertEquals($expected, $this->attributes->render());
        $this->assertEquals($expected, (string) $this->attributes);
    }
}
