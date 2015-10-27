<?php namespace Arcanedev\Menus\Tests;
use Arcanedev\Menus\MenusServiceProvider;

/**
 * Class     MenuServiceProviderTest
 *
 * @package  Arcanedev\Menus\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuServiceProviderTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var MenusServiceProvider */
    private $provider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(MenusServiceProvider::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->provider);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanedev\Menus\MenusServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            'arcanedev.menus.manager',
            \Arcanedev\Menus\Contracts\MenusManager::class,
        ];

        $this->assertEquals($expected, $this->provider->provides());
    }
}
