<?php namespace Arcanedev\Menus\Contracts\Entities;

use Closure;

/**
 * Interface  MenuItemInterface
 *
 * @package   Arcanedev\Menus\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface MenuItemInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the menu item property.
     *
     * @param  string      $name
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function getProperty($name, $default = null);

    /**
     * Get the menu item attributes.
     *
     * @return \Arcanedev\Menus\Entities\MenuItemAttributes
     */
    public function attributes();

    /**
     * Get all sub-items.
     *
     * @return \Arcanedev\Menus\Entities\MenuItemCollection
     */
    public function children();

    /**
     * Get the menu item url.
     */
    public function getUrl();

    /**
     * Get the menu item icon.
     *
     * @param  string  $tag
     *
     * @return string
     */
    public function getIcon($tag = 'i');

    /**
     * Get the menu item content.
     *
     * @return string
     */
    public function getContent();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make MenuItem instance.
     *
     * @param  array     $properties
     * @param  \Closure  $callback
     *
     * @return \Arcanedev\Menus\Contracts\Entities\MenuItemInterface
     */
    public static function make($properties, Closure $callback = null);

    /**
     * Fill the menu item properties.
     *
     * @param  array  $properties
     *
     * @return \Arcanedev\Menus\Contracts\Entities\MenuItemInterface
     */
    public function fill(array $properties);

    /**
     * Add an url sub-item to the parent.
     *
     * @param  string  $url
     * @param  string  $content
     * @param  array   $attributes
     */
    public function url($url, $content, array $attributes = []);

    /**
     * Add a route sub-item to the parent.
     *
     * @param  string  $route
     * @param  string  $content
     * @param  array   $parameters
     * @param  array   $attributes
     */
    public function route($route, $content, array $parameters = [], array $attributes = []);

    /**
     * Add an action sub-item to parent.
     *
     * @param  string  $action
     * @param  string  $content
     * @param  array   $parameters
     * @param  array   $attributes
     */
    public function action($action, $content, array $parameters = [], array $attributes = []);

    /**
     * Add a dropdown sub-item to the parent.
     *
     * @param  string    $content
     * @param  \Closure  $callback
     * @param  array     $attributes
     */
    public function dropdown($content, Closure $callback, array $attributes = []);

    /**
     * Add a divider sub-item to the parent.
     */
    public function divider();

    /**
     * Add a header item to the parent.
     *
     * @param  string  $content
     */
    public function header($content);

    /**
     * Add an item to the parent.
     *
     * @param  array     $properties
     * @param  \Closure  $callback
     */
    public function add(array $properties, Closure $callback = null);

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if the menu item is root.
     *
     * @return bool
     */
    public function isRoot();

    /**
     * Check if the menu item is a header.
     *
     * @return bool
     */
    public function isHeader();

    /**
     * Check if menu item is a divider.
     *
     * @return bool
     */
    public function isDivider();

    /**
     * Check if menu item is active.
     *
     * @return bool
     */
    public function isActive();

    /**
     * Check if the menu item has sub-items.
     *
     * @return bool
     */
    public function hasChildren();
}
