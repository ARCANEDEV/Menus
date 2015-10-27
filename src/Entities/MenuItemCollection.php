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
     * @return \Arcanedev\Menus\Entities\MenuItem|null
     */
    public function get($key, $default = null)
    {
        return parent::get($key, $default = null);
    }
}
