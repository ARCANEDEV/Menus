<?php namespace Arcanedev\Menus\Entities;

use Arcanedev\Support\Collection;

/**
 * Class     MenuAttributes
 *
 * @package  Arcanedev\Menus\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MenuAttributes extends Collection
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make MenuAttributes instance.
     *
     * @param  array  $items
     */
    public function __construct(array $items = [])
    {
        $items = $this->filterProperties($items);

        parent::__construct($items);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Extract the fillable properties.
     *
     * @param  array  $items
     *
     * @return array
     */
    private function filterProperties(array $items)
    {
        if (count($items) == 0) {
            return $items;
        }

        return array_intersect_key($items, array_flip([
            'url', 'route', 'title', 'name', 'icon', 'parent', 'attributes', 'active', 'order',
        ]));
    }
}
