<?php namespace Modules\Store\Widgets;


use Modules\Store\Repositories\CategoryRepository;

class StoreWidget
{
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {

        $this->category = $category;
    }

    public function latestProducts($slug='', $limit=5, $view='latest-products')
    {
        $category = $this->category->findBySlug($slug);
        if(isset($category)) {
            $products = $category->products()->orderBy('ordering')->get()->take($limit);
            return view('store::widgets.'.$view, compact('category', 'products'));
        }
    }
}