<?php namespace Arcanedev\Menus\Contracts;

use Closure;

/**
 * Interface  MenusManager
 *
 * @package   Arcanedev\Menus\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface MenusManager
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a menu.
     *
     * @param  string    $name
     * @param  \Closure  $callback
     */
    public function make($name, Closure $callback);

    /**
     * Check if has menus.
     *
     * @return bool
     */
    public function hasMenus();

    /**
     * Check if the menus collection is empty.
     *
     * @return bool
     */
    public function isEmpty();
}
