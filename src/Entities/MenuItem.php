<?php namespace Arcanedev\Menus\Entities;

use Arcanedev\Menus\Contracts\Entities\MenuItemInterface;
use Closure;

/**
 * Class     MenuItem
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuItem implements MenuItemInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Menu item type.
     *
     * @var string
     */
    protected $type;

    /**
     * Menu item root status.
     *
     * @var bool
     */
    protected $root = false;

    /**
     * Menu item properties.
     *
     * @var array
     */
    protected $properties;

    /**
     * Menu item attributes.
     *
     * @var MenuItemAttributes
     */
    protected $attributes;

    /**
     * Menu item children.
     *
     * @var MenuItemCollection
     */
    protected $children;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make menu item instance.
     *
     * @param  array  $properties
     */
    public function __construct(array $properties)
    {
        $this->children   = new MenuItemCollection;
        $this->setProperties($properties);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set the menu item type.
     *
     * @param  array  $properties
     */
    private function setType(array &$properties)
    {
        $type = array_pull($properties, 'type', null);

        if (is_null($type)) {
            $type = $this->guessType($properties);
        }

        $this->type = $type;
    }

    /**
     * Set the menu item root status.
     *
     * @param  array  $properties
     */
    private function setRoot(array &$properties)
    {
        $this->root = array_pull($properties, 'root', false);
    }

    /**
     * Get the menu item property.
     *
     * @param  string      $name
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function getProperty($name, $default = null)
    {
        return array_get($this->properties, $name, $default);
    }

    /**
     * Set the item properties.
     *
     * @param  array  $properties
     *
     * @return self
     */
    private function setProperties(array $properties)
    {
        $this->setType($properties);
        $this->setRoot($properties);
        $this->attributes = MenuItemAttributes::make(
            array_pull($properties, 'attributes', [])
        );
        $this->properties = array_only($properties, [
            'url', 'route', 'action', 'content', 'icon', 'active', 'position',
        ]);

        return $this;
    }

    /**
     * Get the menu item attributes.
     *
     * @return \Arcanedev\Menus\Entities\MenuItemAttributes
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Get all sub-items.
     *
     * @return \Arcanedev\Menus\Entities\MenuItemCollection
     */
    public function children()
    {
        return $this->children;
    }

    /**
     * Get the menu item url.
     */
    public function getUrl()
    {
        if ($this->hasChildren()) {
            return '#';
        }

        switch ($this->type) {
            case 'url':
                return $this->getProperty('url');

            case 'route':
                list($route, $parameters) = $this->getProperty('route');
                return route($route, $parameters);

            case 'action':
                list($action, $parameters) = $this->getProperty('action');
                return action($action, $parameters);

            default:
                return '';
        }
    }

    /**
     * Get the menu item icon.
     *
     * @param  string  $tag
     *
     * @return string
     */
    public function getIcon($tag = 'i')
    {
        $icon = array_get($this->properties, 'icon', null);

        if (is_null($icon)) {
            return '';
        }

        $attributes = MenuItemAttributes::make([
            'class' => $icon
        ]);

        return "<$tag " . $attributes . "></$tag>";
    }

    /**
     * Get the menu item content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getProperty('content', '');
    }

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
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public static function make($properties, Closure $callback = null)
    {
        $item = new self($properties);

        if (is_callable($callback)) {
            call_user_func($callback, $item);
        }

        return $item;
    }

    /**
     * Fill the menu item properties.
     *
     * @param  array  $properties
     *
     * @return \Arcanedev\Menus\Entities\MenuItem
     */
    public function fill(array $properties)
    {
        $this->setProperties($properties);

        return $this;
    }

    /**
     * Add an url sub-item to the parent.
     *
     * @param  string  $url
     * @param  string  $content
     * @param  array   $attributes
     */
    public function url($url, $content, array $attributes = [])
    {
        $this->makeSubItem('url', compact('url', 'content', 'attributes'));
    }

    /**
     * Add a route sub-item to the parent.
     *
     * @param  string  $route
     * @param  string  $content
     * @param  array   $parameters
     * @param  array   $attributes
     */
    public function route($route, $content, array $parameters = [], array $attributes = [])
    {
        $route = [$route, $parameters];

        $this->makeSubItem('route', compact('route', 'content', 'attributes'));
    }

    /**
     * Add an action sub-item to parent.
     *
     * @param  string  $action
     * @param  string  $content
     * @param  array   $parameters
     * @param  array   $attributes
     */
    public function action($action, $content, array $parameters = [], array $attributes = [])
    {
        $action = [$action, $parameters];

        $this->makeSubItem('action', compact('action', 'content', 'attributes'));
    }

    /**
     * Add a dropdown sub-item to the parent.
     *
     * @param  string    $content
     * @param  \Closure  $callback
     * @param  array     $attributes
     */
    public function dropdown($content, Closure $callback, array $attributes = [])
    {
        $this->makeSubItem('dropdown', compact('content', 'attributes'), $callback);
    }

    /**
     * Add a divider sub-item to the parent.
     */
    public function divider()
    {
        $this->makeSubItem('divider');
    }

    /**
     * Add a header item to the parent.
     *
     * @param  string  $content
     */
    public function header($content)
    {
        $this->makeSubItem('header', compact('content'));
    }

    /**
     * Add an item to the parent.
     *
     * @param  array     $properties
     * @param  \Closure  $callback
     */
    public function add(array $properties, Closure $callback = null)
    {
        $this->makeSubItem(null, $properties, $callback);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if the menu item is root.
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->root;
    }

    /**
     * Check if the menu item is a header.
     *
     * @return bool
     */
    public function isHeader()
    {
        return $this->type === 'header';
    }

    /**
     * Check if menu item is a divider.
     *
     * @return bool
     */
    public function isDivider()
    {
        return $this->type === 'divider';
    }

    /**
     * Check if menu item is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool) $this->getProperty('active', false);
    }

    /**
     * Check if the menu item has sub-items.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return ! $this->children()->isEmpty();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make an child item and add it to the parent item.
     *
     * @param  string         $type
     * @param  array          $properties
     * @param  \Closure|null  $callback
     *
     * @return self
     */
    private function makeSubItem($type, array $properties = [], Closure $callback = null)
    {
        $properties = array_merge($properties, [
            'type'   => $type,
        ]);

        $item = self::make($properties, $callback);
        $this->addChild($item);

        return $item;
    }

    /**
     * Add a child item to collection.
     *
     * @param  self  $item
     */
    private function addChild(MenuItem $item)
    {
        $this->children->push($item);
    }

    /**
     * Guess the menu item type.
     *
     * @param  array  $properties
     *
     * @return string|null
     */
    private function guessType(array $properties)
    {
        $types = ['url', 'route', 'action'];

        foreach ($types as $type) {
            if (array_key_exists($type, $properties)) {
                return $type;
            }
        }

        return null;
    }
}
