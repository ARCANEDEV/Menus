<?php namespace Arcanedev\Menus\Entities;

use Arcanedev\Menus\Contracts\MenuItemCollectionInterface;
use Arcanedev\Support\Collection;
use Closure;

/**
 * Class     MenuItemCollection
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuItemCollection extends Collection implements MenuItemCollectionInterface
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
    public function first(callable $callback = null, $default = null)
    {
        return parent::first($callback, $default);
    }

    /**
     * Add a menu item to collection.
     *
     * @param  array     $attributes
     * @param  \Closure  $callback
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function addItem(array $attributes, Closure $callback = null)
    {
        $item = $this->makeItem($attributes, $callback);

        $this->push($item);

        return $item;
    }

    /**
     * Add a menu header item to collection.
     *
     * @param  string    $title
     * @param  int|null  $order
     */
    public function addHeader($title, $order)
    {
        $name = 'header';

        $this->addItem(compact('name', 'title', 'order'));
    }

    /**
     * Adding a menu divider item.
     *
     * @param  int|null  $order
     */
    public function addDivider($order)
    {
        $name = 'divider';

        $this->addItem(compact('name', 'order'));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a menu item.
     *
     * @param  array     $attributes
     * @param  \Closure  $callback
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    private function makeItem(array $attributes, Closure $callback = null)
    {
        $item = MenuItem::make($attributes);

        if ( ! is_null($callback)) {
            call_user_func($callback, $item);
        }

        return $item;
    }
}
