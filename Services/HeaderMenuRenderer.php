<?php namespace Modules\Store\Services;

use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Store\Entities\Category;

class HeaderMenuRenderer
{
    private $categoryRoute = 'store.category.slug';
    /**
     * @var MenuItemRepository
     */
    private $menuItem;

    public function __construct(MenuItemRepository $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    public function routeMenu($uri, $menu, $categories)
    {
        if($menuItem = $this->menuItem->findByUriInLanguage($uri, locale()))
        {
            $menu->whereTitle($menuItem->title, function ($sub) use ($categories) {
                foreach ($categories as $category) {
                    if($category->active()) {
                        $this->addRouteMenu($sub, $category);
                    }
                }
            });
        }
        return $menu;
    }

    private function addRouteMenu($menu, Category $category)
    {
        if($category->exists()) {
            if ($category->children()->exists()) {
                $menu->dropdown($category->title, route($this->categoryRoute, [$category->slug]), function ($sub) use ($category) {
                    foreach ($category->children()->active()->get() as $child) {
                        $this->addRouteMenu($sub, $child);
                    }
                });
            } else {
                $menu->add([
                   'title' => $category->title,
                   'url' => $category->url
                ]);
            }
        }
        return $menu;
    }

    /**
     * @return string
     */
    public function getCategoryRoute()
    {
        return $this->categoryRoute;
    }

    /**
     * @param $categoryRoute
     * @return $this
     */
    public function setCategoryRoute($categoryRoute)
    {
        $this->categoryRoute = $categoryRoute;
        return $this;
    }
}