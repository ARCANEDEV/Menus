<?php namespace Arcanedev\Menus\Entities;

use Arcanedev\Support\Collection;

/**
 * Class     MenuCollection
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuCollection extends Collection
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get a menu from collection.
     *
     * @param  string      $name
     * @param  mixed|null  $default
     *
     * @return Menu|null
     */
    public function get($name, $default = null)
    {
        return parent::get($name, $default);
    }
}
