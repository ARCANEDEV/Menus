<?php namespace Arcanedev\Menus\Entities;

use Arcanedev\Menus\Contracts\Renderable;
use Arcanedev\Support\Collection;

/**
 * Class     MenuItemAttributes
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuItemAttributes extends Collection implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render the instance to string.
     *
     * @return string
     */
    public function render()
    {
        $html = [];

        foreach ($this->all() as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            if (is_numeric($key)) {
                $key = $value;
            }

            $html[] = $key . '="' . e($value) . '"';
        }

        return implode(' ', array_filter($html));
    }

    /**
     * Render the instance to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
