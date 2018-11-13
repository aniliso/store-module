<?php

namespace Modules\Store\Http\Controllers;

use Modules\Sitemap\Http\Controllers\BaseSitemapController;
use Modules\Store\Repositories\CategoryRepository;

class SitemapController extends BaseSitemapController
{
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    public function index()
    {
        foreach ($this->category->roots() as $category)
        {
            if (!$category->sitemap_include) continue;
            $this->sitemap->add(
                $category->url,
                $category->updated_at,
                $category->sitemap_priority,
                $category->sitemap_frequency,
                [],
                null,
                $category->present()->languages('language')
            );
            if($category->products()->exists()) {
                foreach ($category->products()->get() as $product) {
                    if (!$product->sitemap_include) continue;

                    $images = [];
                    if($product->files()->exists())
                    {
                        $images[] = ['url' => url($product->present()->firstImage(500,500,'resize',80)), 'title' => $product->title];
                    }
                    $this->sitemap->add(
                        $product->url,
                        $product->updated_at,
                        $product->sitemap_priority,
                        $product->sitemap_frequency,
                        $images,
                        null,
                        $product->present()->languages('language')
                    );
                }
            }
        }
        return $this->sitemap->render('xml');
    }
}
