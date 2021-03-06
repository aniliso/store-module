<?php

namespace Modules\Store\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Store\Entities\Category;
use Modules\Store\Repositories\BrandRepository;
use Modules\Store\Repositories\CategoryRepository;
use Modules\Store\Repositories\ProductRepository;
use Breadcrumbs;

/**
 * Class PublicController
 * @package Modules\Store\Http\Controllers
 */
class PublicController extends BasePublicController
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
     * @var int
     */
    private $perPage;
    /**
     * @var Application
     */
    private $app;
    /**
     * @var BrandRepository
     */
    private $brand;

    /**
     * PublicController constructor.
     * @param CategoryRepository $category
     * @param ProductRepository $product
     */
    public function __construct(
        CategoryRepository $category,
        ProductRepository $product,
        BrandRepository $brand,
        Application $app
    )
    {
        parent::__construct();
        $this->app = $app;
        $this->category = $category;
        $this->product = $product;
        $this->brand = $brand;

        $this->perPage = setting('store::products-per-page');

        if(!app()->runningInConsole()) {
            Breadcrumbs::register('store', function ($breadcrumbs) {
                $breadcrumbs->push(trans('themes::store.product.titles.product'), route('store.index'));
            });
        }

        view()->share('categories', Category::roots()->active());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->product->allTranslatedInPaginate($this->locale, $this->perPage);

        /* Start Seo */
        $title = trans('themes::store.products.titles.product');
        $url   = route('store.index');

        $this->seo()
            ->setTitle($title)
            ->setDescription($title)
            ->meta()
            ->setUrl($url)
            ->addMeta('robots', "index, follow")
            ->addAlternates($this->getAlternateLanguages('store::routes.index'));

        $this->seoGraph()
             ->setTitle($title)
             ->setDescription($title)
             ->setUrl($url);

        $this->seoCard()
            ->setTitle($title)
            ->setDescription($title)
            ->setType('app');
        /* End Seo */

        Breadcrumbs::register('store.index', function ($breadcrumbs) {
            $breadcrumbs->parent('store');
        });

        return view('store::index', compact('categories', 'products'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product($id, $slug="")
    {
        $product = $this->product->find($id);

        $this->throw404IfNotFound($product);

        /* Start Seo */
        $this->seo()->setTitle($product->present()->meta_title)
             ->setDescription($product->present()->meta_description)
             ->setKeywords($product->present()->meta_keywords)
             ->meta()->setUrl($product->url)
             ->addMeta('robots', $product->robots)
             ->addAlternates($product->present()->languages);

        $this->seoGraph()
             ->setTitle($product->present()->meta_title)
             ->setType($product->og_type)
             ->setUrl($product->url);

        $this->seoCard()
            ->setTitle($product->present()->meta_title)
            ->setDescription($product->present()->meta_description)
            ->setType('app');
        /* End Seo */

        Breadcrumbs::register('store.product', function ($breadcrumbs) use ($product) {
            $breadcrumbs->parent('store');
            if($product->categories()->count()>0):
                foreach ($product->categories()->latest()->first()->getAncestorsAndSelf() as $category):
                    $breadcrumbs->push($category->title, $category->url);
                endforeach;
            endif;
            $breadcrumbs->push($product->title, $product->url);
        });

        return view('store::product', compact('product'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($slug)
    {
        $category = $this->category->findBySlug($slug);

        $this->throw404IfNotFound($category);

        $products = $category->products()->orderBy('ordering', 'asc')->active()->paginate($this->perPage);

        /* Start Seo */
         $this->seo()
             ->setTitle($category->present()->meta_title)
             ->setDescription($category->present()->meta_description)
             ->meta()->setUrl($category->url)
             ->addMeta('robots', $category->robots)
             ->addAlternates($category->present()->languages);

        $this->seoGraph()
            ->setTitle($category->present()->meta_title)
            ->setDescription($category->present()->meta_description)
            ->setType($category->og_type)
            ->setUrl($category->url);

        $this->seoCard()
            ->setTitle($category->present()->meta_title)
            ->setDescription($category->present()->meta_description)
            ->setType('app');

        /* End Seo */
        Breadcrumbs::register('store.category', function ($breadcrumbs) use ($category) {
            $breadcrumbs->parent('store');
            foreach ($category->getAncestorsAndSelf() as $children) {
                $breadcrumbs->push($children->title, $children->url);
            }
        });

        return view('store::category', compact('category', 'products'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand($slug)
    {
        $brand = $this->brand->findBySlug($slug);

        $this->throw404IfNotFound($brand);

        $products = $brand->products()->orderBy('ordering', 'asc')->active()->paginate($this->perPage);

        /* Start Seo */
        $this->seo()
            ->setTitle($brand->present()->meta_title)
            ->setDescription($brand->present()->meta_description)
            ->meta()->setUrl($brand->url)
            ->addMeta('robots', $brand->robots)
            ->addAlternates($brand->present()->languages);

        $this->seoGraph()
            ->setTitle($brand->present()->meta_title)
            ->setDescription($brand->present()->meta_description)
            ->setType($brand->og_type)
            ->setUrl($brand->url);

        $this->seoCard()
            ->setTitle($brand->present()->meta_title)
            ->setDescription($brand->present()->meta_description)
            ->setType('app');

        /* End Seo */
        Breadcrumbs::register('store.brand', function ($breadcrumbs) use ($brand) {
            $breadcrumbs->parent('store');
            $breadcrumbs->push($brand->title, $brand->url);
        });

        return view('store::brands', compact('brand', 'products'));
    }

    public function search(Request $request)
    {
        if(!$request->has('s')) {
            return redirect(route('store.index'));
        }
        $query = $request->get('s');
        $products = $this->product->search($query, $this->perPage);

        $this->setTitle($query)
            ->setDescription($query);

        $this->seoMeta()->addMeta('robots', 'noindex, nofollow');

        Breadcrumbs::register('store.search', function ($breadcrumbs) use ($query) {
            $breadcrumbs->parent('store');
            $breadcrumbs->push($query,route('store.product.search', ['s'=>$query]));
        });

        return view('store::search', compact('query', 'products'));
    }

    /**
     * Throw a 404 error page if the given page is not found
     * @param $product
     */
    private function throw404IfNotFound($product)
    {
        if (is_null($product)) {
            $this->app->abort('404');
        }
    }
}
