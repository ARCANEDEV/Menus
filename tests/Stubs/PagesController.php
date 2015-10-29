<?php namespace Arcanedev\Menus\Tests\Stubs;

use Illuminate\Routing\Controller;

/**
 * Class     PagesController
 *
 * @package  Arcanedev\Menus\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PagesController extends Controller
{
    public function index()
    {
        return 'Index page';
    }

    public function about($slug)
    {
        return 'About page : ' . $slug;
    }

    public function category($categorySlug)
    {
        return 'Category page : ' . $categorySlug;
    }

    public function subCategory($categorySlug, $subCategorySlug)
    {
        return 'Sub-Category page : ' . $categorySlug . ' => ' . $subCategorySlug;
    }

    public function contact()
    {
        return 'Contact page';
    }
}
