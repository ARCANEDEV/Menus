<?php namespace Arcanedev\Menus\Entities;

use Closure;
use IteratorAggregate;

/**
 * Class     Menu
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Menu implements IteratorAggregate
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The menu name.
     *
     * @var string
     */
    protected $name  = '';

    /**
     * The menu item collection.
     *
     * @var MenuItemCollection
     */
    protected $items;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a Menu instance.
     *
     * @param  string  $name
     */
    private function __construct($name)
    {
        $this->name  = $name;
        $this->items = new MenuItemCollection;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the menu items iterator.
     *
     * @return \Arcanedev\Menus\Entities\MenuItemCollection
     */
    public function getIterator()
    {
        return $this->items;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a menu.
     *
     * @param  string    $name
     * @param  \Closure  $callback
     *
     * @return Menu
     */
    public static function make($name, Closure $callback = null)
    {
        $menu = new self($name);
        if ( ! is_null($callback)) {
            call_user_func($callback, $menu);
        }

        return $menu;
    }

    /**
     * Add an url item to the menu.
     *
     * @param  string  $url
     * @param  string  $content
     * @param  array   $attributes
     */
    public function url($url, $content, array $attributes = [])
    {
        $this->makeItem('url', compact('url', 'content', 'attributes'));
    }

    /**
     * Add a route item to the menu.
     *
     * @param  string  $route
     * @param  string  $content
     * @param  array   $parameters
     * @param  array   $attributes
     */
    public function route($route, $content, array $parameters = [], array $attributes = [])
    {
        $route = [$route, $parameters];

        $this->makeItem('route', compact('route', 'content', 'attributes'));
    }

    /**
     * Add a action item to the menu.
     *
     * @param  string  $action
     * @param  string  $content
     * @param  array   $parameters
     * @param  array   $attributes
     */
    public function action($action, $content, array $parameters = [], array $attributes = [])
    {
        $action = [$action, $parameters];

        $this->makeItem('action', compact('action', 'content', 'attributes'));
    }

    /**
     * Add a dropdown item to the menu.
     *
     * @param  string   $content
     * @param  Closure  $callback
     * @param  array    $attributes
     */
    public function dropdown($content, Closure $callback, array $attributes = [])
    {
        $this->makeItem('dropdown', compact('content', 'attributes'), $callback);
    }

    /**
     * Add a divider item to the menu.
     */
    public function divider()
    {
        $this->makeItem('divider');
    }

    /**
     * Add a header item to the menu.
     *
     * @param  string  $content
     */
    public function header($content)
    {
        $this->makeItem('header', compact('content'));
    }

    /**
     * Add an item to the menu.
     *
     * @param  array     $properties
     * @param  \Closure  $callback
     */
    public function add($properties, Closure $callback = null)
    {
        $this->makeItem('mixed', $properties, $callback);
    }

    /**
     * Get all the menu items.
     *
     * @return array
     */
    public function all()
    {
        return $this->items->all();
    }

    /**
     * Get the menu items count.
     *
     * @return int
     */
    public function count()
    {
        return $this->items->count();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if menu has items.
     *
     * @return bool
     */
    public function hasItems()
    {
        return ! $this->items->isEmpty();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make an parent item and add it to the menu.
     *
     * @param  string        $type
     * @param  array         $properties
     * @param  Closure|null  $callback
     *
     * @return MenuItem
     */
    private function makeItem($type, $properties = [], Closure $callback = null)
    {
        $properties = array_merge($properties, [
            'type' => $type,
            'root' => true,
        ]);

        $item = MenuItem::make($properties, $callback);
        $this->addItem($item);

        return $item;
    }

    /**
     * Add an item to the menu.
     *
     * @param  MenuItem  $item
     */
    private function addItem(MenuItem $item)
    {
        $this->items->push($item);
    }
}
