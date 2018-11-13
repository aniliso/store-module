<?php namespace Modules\Store\Widgets;


use Modules\Store\Entities\Product;
use Modules\Store\Repositories\CategoryRepository;
use Modules\Store\Repositories\ProductRepository;

class StoreWidget
{
    /**
     * @var CategoryRepository
     */
    private $category;
    /**
     * @var ProductRepository
     */
    private $product;

    public function __construct(
        CategoryRepository $category,
        ProductRepository $product
    )
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function categories($limit=6, $view='category')
    {
        $categories = $this->category->all()->where('status', 1)->take($limit);
        if($categories->count()>0) {
            return view('store::widgets.'.$view, compact('categories'));
        }
        return null;
    }

    public function latest($limit=6, $view='product')
    {
        $products = $this->product->getByAttributes(['is_new'=>1]);
        if($products->count()>0) {
            return view('store::widgets.'.$view, compact('products'));
        }
        return null;
    }

    public function related(Product $product, $limit=6, $view='related')
    {
        if($product->related()->count()>0) {
            $products = $product->related()->get();
            return view('store::widgets.'.$view, compact('products'));
        }
        return null;
    }
}