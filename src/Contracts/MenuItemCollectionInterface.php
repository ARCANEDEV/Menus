<?php namespace Arcanedev\Menus\Contracts;

use Closure;

/**
 * Interface  MenuItemCollectionInterface
 *
 * @package   Arcanedev\Menus\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface MenuItemCollectionInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the first menu item from the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed          $default
     *
     * @return \Arcanedev\Menus\Entities\MenuItem|null
     */
    public function first(callable $callback = null, $default = null);

    /**
     * Add a menu item to collection.
     *
     * @param  array     $attributes
     * @param  \Closure  $callback
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function addItem(array $attributes, Closure $callback = null);

    /**
     * Add a menu header item to collection.
     *
     * @param  string    $title
     * @param  int|null  $order
     */
    public function addHeader($title, $order);

    /**
     * Adding a menu divider item.
     *
     * @param  int|null  $order
     */
    public function addDivider($order);
}
