<?php namespace Arcanedev\Menus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class     Menu
 *
 * @package  Arcanedev\Menus\Facades
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Menus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'arcanedev.menus.manager'; }
}
