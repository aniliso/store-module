<?php

namespace Modules\Store\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\User\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('store::stores.title.stores'), function (Item $item) {
                $item->icon('fa fa-tags');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('store::products.title.products'), function (Item $item) {
                    $item->icon('fa fa-cube');
                    $item->weight(0);
                    $item->append('admin.store.product.create');
                    $item->route('admin.store.product.index');
                    $item->authorize(
                        $this->auth->hasAccess('store.products.index')
                    );
                });
                $item->item(trans('store::brands.title.brands'), function (Item $item) {
                    $item->icon('fa fa-user');
                    $item->weight(0);
                    $item->append('admin.store.brand.create');
                    $item->route('admin.store.brand.index');
                    $item->authorize(
                        $this->auth->hasAccess('store.brands.index')
                    );
                });
                $item->item(trans('store::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-th-large');
                    $item->weight(0);
                    $item->append('admin.store.category.create');
                    $item->route('admin.store.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('store.categories.index')
                    );
                });
            });
        });

        return $menu;
    }
}
