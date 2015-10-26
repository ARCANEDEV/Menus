<?php namespace Arcanedev\Menus\Contracts;

use Closure;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Interface  MenuItemInterface
 *
 * @package   Arcanedev\Menus\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface MenuItemInterface extends Arrayable
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the menu item properties.
     *
     * @return array
     */
    public function getProperties();

    /**
     * Get the menu item attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Get the menu sub-items collection.
     *
     * @return \Arcanedev\Menus\Entities\MenuItemCollection
     */
    public function getChildren();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make the MenuItem instance.
     *
     * @param  array  $properties
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public static function make(array $properties);

    /**
     * Add a sub menu item.
     * @see \Arcanedev\Menus\Entities\MenuItem::add()
     *
     * @param  array  $properties
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function child(array $properties);

    /**
     * Add new child item.
     *
     * @param array $properties
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function add(array $properties);

    /**
     * Adding new menu item by route.
     *
     * @param  string    $route
     * @param  string    $title
     * @param  array     $parameters
     * @param  int|null  $order
     * @param  array     $attributes
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function route($route, $title, $parameters = [], $order = 0, $attributes = []);

    /**
     * Adding new menu item by url.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  int     $order
     * @param  array   $attributes
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function url($url, $title, $order = 0, $attributes = []);

    /**
     * Add a sub menu item with dropdown menu.
     *
     * @param  string    $title
     * @param  int       $order
     * @param  \Closure  $callback
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function dropdown($title, $order = 0, Closure $callback);

    /**
     * Add a header item (alias).
     * @see    \Arcanedev\Menus\Contracts\MenuItemInterface::addHeader()
     *
     * @param  string  $title
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function header($title);

    /**
     * Add a header item.
     *
     * @param  string  $title
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function addHeader($title);

    /**
     * Add a divider item (alias).
     * @see    \Arcanedev\Menus\Contracts\MenuItemInterface::addDivider()
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function divider();

    /**
     * Add a divider item.
     *
     * @param int $order
     *
     * @return \Arcanedev\Menus\Contracts\MenuItemInterface
     */
    public function addDivider($order = null);
}
