<?php namespace Modules\Store\Widgets;


use Modules\Store\Entities\Category;
use Modules\Store\Entities\Product;
use Modules\Store\Repositories\BrandRepository;
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
    /**
     * @var BrandRepository
     */
    private $brand;

    public function __construct(
        CategoryRepository $category,
        ProductRepository $product,
        BrandRepository $brand
    )
    {
        $this->category = $category;
        $this->product = $product;
        $this->brand = $brand;
    }

    public function categories($limit=6, $view='category')
    {
        $categories = $this->category->roots()->where('status', 1)->take($limit);
        if($categories->count()>0) {
            return view('store::widgets.'.$view, compact('categories'));
        }
        return null;
    }

    public function subCategories(Category $category, $view='category')
    {
        if($category->children()->count()>0) {
            $categories = $category->children()->get();
            return view('store::widgets.'.$view, compact('categories'));
        }
        return null;
    }

    public function latest($limit=6, $view='product')
    {
        $products = $this->product->latest($limit);
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

    public function brands($limit=0, $view='brands')
    {
        $brands = $this->brand->all()->sortBy('ordering')->where('status', 1);

        if($brands->count()>0) {
            return view('store::widgets.'.$view, compact('brands'));
        }
        return null;
    }

    public function newProducts($limit=0, $view='new-products')
    {
        $products = $this->product->getNewProducts($limit);
        if($products->count()>0) {
            return view('store::widgets.'.$view, compact('products'));
        }
        return null;
    }
}