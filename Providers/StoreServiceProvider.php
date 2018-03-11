<?php

namespace Modules\Store\Providers;

use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Media\Image\ThumbnailManager;
use Modules\Store\Composers\MenuModify;
use Modules\Store\Composers\StoreAdminAssets;
use Modules\Store\Entities\Category;
use Modules\Store\Entities\Product;
use Modules\Store\Events\Handlers\RegisterStoreSidebar;
use Modules\Store\Observers\CategoryObserver;
use Modules\Tag\Repositories\TagManager;

class StoreServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->app->extend('asgard.ModulesList', function($app) {
            array_push($app, 'store');
            return $app;
        });

        view()->composer(['store::admin.products.index', 'store::admin.categories.index'], StoreAdminAssets::class);

        if(view()->exists('partials.header')) {
            view()->composer('partials.header', MenuModify::class);
        }

        $this->app->register(\Baum\Providers\BaumServiceProvider::class);

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('store', RegisterStoreSidebar::class)
        );

        \Widget::register('latestProducts', 'Modules\Store\Widgets\storeWidget@latestProducts');
    }

    public function boot()
    {
        $this->publishConfig('store', 'config');
        $this->publishConfig('store', 'permissions');
        $this->publishConfig('store', 'settings');

        $this->app[TagManager::class]->registerNamespace(new Product());
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Category::observe(CategoryObserver::class);

        //$this->registerThumbnails();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Store\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Store\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Store\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Store\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Store\Repositories\ProductRepository',
            function () {
                $repository = new \Modules\Store\Repositories\Eloquent\EloquentProductRepository(new \Modules\Store\Entities\Product());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Store\Repositories\Cache\CacheProductDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Store\Repositories\BrandRepository',
            function () {
                $repository = new \Modules\Store\Repositories\Eloquent\EloquentBrandRepository(new \Modules\Store\Entities\Brand());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Store\Repositories\Cache\CacheBrandDecorator($repository);
            }
        );
    }

    private function registerThumbnails()
    {
        $this->app[ThumbnailManager::class]->registerThumbnail('categoryImage', [
            'fit' => [
                'width' => '150',
                'height' => '150',
                'callback' => function ($constraint) {
                    $constraint->upsize();
                },
            ],
        ]);
        $this->app[ThumbnailManager::class]->registerThumbnail('productImages', [
            'fit' => [
                'width' => '150',
                'height' => '150',
                'callback' => function ($constraint) {
                    $constraint->upsize();
                },
            ],
        ]);
    }
}
