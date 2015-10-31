<?php namespace Arcanedev\Menus\Entities;

use Arcanedev\Support\Collection;

/**
 * Class     MenuItemCollection
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuItemCollection extends Collection
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get a menu item from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     *
     * @return \Arcanedev\Menus\Entities\MenuItem|mixed
     */
    public function get($key, $default = null)
    {
        return parent::get($key, $default);
    }

    /**
     * Get the first item from the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed          $default
     *
     * @return \Arcanedev\Menus\Entities\MenuItem|mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last item from the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed          $default
     *
     * @return \Arcanedev\Menus\Entities\MenuItem|mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        return parent::last($callback, $default);
    }
}
