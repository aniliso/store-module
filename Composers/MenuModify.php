<?php  namespace Modules\Store\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Modules\Menu\Entities\Menuitem;
use Modules\Store\Repositories\CategoryRepository;
use Modules\Store\Services\HeaderMenuRenderer;

class MenuModify
{
    /**
     * @var HeaderMenuRenderer
     */
    private $menuRenderer;
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(HeaderMenuRenderer $menuRenderer, CategoryRepository $category)
    {

        $this->menuRenderer = $menuRenderer;
        $this->category = $category;
    }

    public function compose(View $view)
    {
        $menuItem = Menuitem::whereHas('translations', function(Builder $q) {
            $q->where('title', 'Ürünler');
        })->first();
        if(count($menuItem)>0) {
            \Menu::modify('header', function ($menu) use ($menuItem) {
                $this->menuRenderer->routeMenu(
                    $menuItem->uri,
                    $menu,
                    $this->category->roots()
                );
            });
        }
    }
}