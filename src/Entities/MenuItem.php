<?php namespace Arcanedev\Menus\Entities;

use Arcanedev\Menus\Contracts\MenuItemInterface;
use Closure;

/**
 * Class     MenuItem
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string  url
 * @property  string  route
 * @property  string  title
 * @property  string  name
 * @property  string  icon
 * @property  string  parent
 * @property  array   attributes
 * @property  bool    active
 * @property  int     order
 */
class MenuItem implements MenuItemInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The menu item properties.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * The menu item attributes.
     *
     * @var MenuAttributes
     */
    protected $attrs;

    /**
     * The menu sub-items.
     *
     * @var MenuItemCollection
     */
    protected $subItems;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make the MenuItem instance.
     *
     * @param  array  $properties
     */
    public function __construct(array $properties = [])
    {
        $this->subItems = new MenuItemCollection;
        $this->setProperties($properties);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the menu item properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set the menu item properties.
     *
     * @param  array  $properties
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    private function setProperties(array $properties)
    {
        $this->properties = $properties;
        $this->attrs      = MenuAttributes::make($properties);

        return $this;
    }

    /**
     * Get the menu item attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = $this->attrs;

        return $attributes->forget(['active', 'icon'])->toArray();
    }

    /**
     * Get the menu sub-items collection.
     *
     * @return \Arcanedev\Menus\Entities\MenuItemCollection
     */
    public function getChildren()
    {
        return $this->subItems;
    }

    /**
     * Get menu item attribute.
     *
     * @param  string  $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->attrs->get($name, null);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make the MenuItem instance.
     *
     * @param  array  $properties
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public static function make(array $properties)
    {
        return new self($properties);
    }

    /**
     * Add a sub menu item.
     * @see \Arcanedev\Menus\Entities\MenuItem::add()
     *
     * @param  array  $properties
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function child(array $properties)
    {
        return $this->add($properties);
    }

    /**
     * Add new child item.
     *
     * @param array $properties
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function add(array $properties)
    {
        $this->addSubItem($properties);

        return $this;
    }

    /**
     * Adding new menu item by route.
     *
     * @param  string    $route
     * @param  string    $title
     * @param  array     $parameters
     * @param  int|null  $order
     * @param  array     $attributes
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function route($route, $title, $parameters = [], $order = 0, $attributes = [])
    {
        $route = [$route, $parameters];

        return $this->add(compact('route', 'title', 'order', 'attributes'));
    }

    /**
     * Adding new menu item by url.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  int     $order
     * @param  array   $attributes
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function url($url, $title, $order = 0, $attributes = [])
    {
        return $this->add(compact('url', 'title', 'order', 'attributes'));
    }

    /**
     * Add a sub menu item with dropdown menu.
     *
     * @param  string    $title
     * @param  int       $order
     * @param  \Closure  $callback
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function dropdown($title, $order = 0, Closure $callback)
    {
        $this->addSubItem(compact('title', 'order'), $callback);

        return $this;
    }

    /**
     * Add a header item (alias).
     * @see    \Arcanedev\Menus\Entities\MenuItem::addHeader()
     *
     * @param  string  $title
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function header($title)
    {
        return $this->addHeader($title);
    }

    /**
     * Add a header item.
     *
     * @param  string  $title
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function addHeader($title)
    {
        $this->subItems->addHeader($title, null);

        return $this;
    }

    /**
     * Add a divider item (alias).
     * @see    \Arcanedev\Menus\Entities\MenuItem::addDivider()
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function divider()
    {
        return $this->addDivider();
    }

    /**
     * Add a divider item.
     *
     * @param int $order
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function addDivider($order = null)
    {
        $this->subItems->addDivider($order);

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'properties' => $this->getProperties(),
            'attributes' => $this->getAttributes(),
            'sub-items'  => $this->subItems->toArray(),
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Adding a sub menu item.
     *
     * @param  array          $properties
     * @param  \Closure|null  $callback
     */
    private function addSubItem(array $properties, Closure $callback = null)
    {
        $this->subItems->addItem($properties, $callback);
    }
}
