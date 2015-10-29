<?php namespace Arcanedev\Menus;

use Arcanedev\Menus\Entities\Menu;
use Arcanedev\Menus\Entities\MenuCollection;
use Closure;

/**
 * Class     MenusManager
 *
 * @package  Arcanedev\Menus
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenusManager implements Contracts\MenusManager
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var MenuCollection
     */
    protected $menus;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make MenusManager instance.
     */
    public function __construct()
    {
        $this->menus = new MenuCollection;
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
     */
    public function make($name, Closure $callback)
    {
        $this->add($name, Menu::make($name, $callback));
    }

    /**
     * Add a menu to the collection.
     *
     * @param  string  $name
     * @param  Menu    $menu
     */
    public function add($name, Menu $menu)
    {
        $this->menus->put($name, $menu);
    }

    /**
     * Get a menu from collection.
     *
     * @param  string  $name
     *
     * @return \Arcanedev\Menus\Entities\Menu
     */
    public function get($name)
    {
        return $this->menus->get($name);
    }

    /**
     * Check if has menus.
     *
     * @return bool
     */
    public function hasMenus()
    {
        return ! $this->isEmpty();
    }

    /**
     * Check if the menus collection is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->menus->isEmpty();
    }

    /**
     * Get the menus count.
     *
     * @return int
     */
    public function count()
    {
        return $this->menus->count();
    }
}
