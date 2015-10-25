<?php namespace Arcanedev\Menus\Contracts;

/**
 * Interface  Renderable
 *
 * @package   Arcanedev\Menus\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Renderable
{
    /**
     * Render the instance to string.
     *
     * @return string
     */
    public function render();
}
