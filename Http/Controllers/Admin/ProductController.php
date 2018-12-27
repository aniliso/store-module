<?php

namespace Modules\Store\Http\Controllers\Admin;

use Datatables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Media\Repositories\FileRepository;
use Modules\Store\Entities\Brand;
use Modules\Store\Entities\Category;
use Modules\Store\Entities\Helpers\Status;
use Modules\Store\Entities\Product;
use Modules\Store\Http\Requests\Product\CreateProductRequest;
use Modules\Store\Http\Requests\Product\UpdateProductRequest;
use Modules\Store\Repositories\BrandRepository;
use Modules\Store\Repositories\CategoryRepository;
use Modules\Store\Repositories\ProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductController extends AdminBaseController
{
    /**
     * @var ProductRepository
     */
    private $product;
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var Status
     */
    private $status;
    /**
     * @var BrandRepository
     */
    private $brand;
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(ProductRepository $product, CategoryRepository $category, BrandRepository $brand, FileRepository $file, Status $status)
    {
        parent::__construct();

        $this->product = $product;
        $this->category = $category;
        $this->brand = $brand;
        $this->file = $file;
        $this->status = $status;

        view()->share('categoryLists', ['' => trans('store::categories.form.no-category')] + $this->category->lists());
        view()->share('statuses', $this->status->lists());
        view()->share('brands', $this->brand->all()->pluck('title', 'id')->toArray());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $products = $this->product->allWithBuilder();
            return Datatables::of($products)
                ->editColumn('ordering', function ($product) {
                    return '<a href="#" id="ordering" class="editable" data-type="text" data-pk="' . $product->id . '" data-url="' . route('api.store.product.update') . '" data-title="' . trans('store::products.form.ordering') . '">' . $product->ordering . '</a>';
                })
                ->editColumn('status', function ($product) {
                    return '<a href="#" id="status" class="status" data-value="' . $product->status . '" data-type="select" data-pk="' . $product->id . '" data-url="' . route('api.store.product.update') . '" data-title="' . trans('store::products.form.status') . '">' . "<span class=\"label {$product->present()->statusLabelClass}\">{$product->present()->status}</span>" . '</a>';
                })
                ->addColumn('category', function ($product) {
                    return $product->categories->map(function ($category) {
                        return $category->title;
                    })->implode(', ');
                })
                ->addColumn('action', function ($product) {
                    $is_new = $product->is_new == 1 ? 'bg-green' : 'bg-red';
                    $action_buttons = \Html::decode(link_to(
                        route('admin.store.product.edit',
                            [$product->id]),
                        '<i class="fa fa-home"></i>',
                        [
                            'class'      => "btn btn-default btn-xs btn-flat is_new $is_new",
                            'data-pk'    => $product->id,
                            'data-val'   => $product->is_new
                        ]
                    ));
                    $action_buttons .= \Html::decode(link_to(
                        route('admin.store.product.duplicate',
                            [$product->id]),
                        '<i class="fa fa-copy"></i>',
                        ['class' => 'btn btn-default btn-xs btn-flat']
                    ));
                    $action_buttons .= \Html::decode(link_to(
                        route('admin.store.product.edit',
                            [$product->id]),
                        '<i class="fa fa-pencil"></i>',
                        ['class' => 'btn btn-default btn-xs btn-flat']
                    ));
                    $action_buttons .= \Html::decode(\Form::button(
                        '<i class="fa fa-trash"></i>',
                        [
                             "data-toggle"        => "modal",
                             "data-action-target" => route("admin.store.product.destroy", [$product->id]),
                             "data-target"        => "#modal-delete-confirmation",
                             "class"              => "btn btn-xs btn-danger btn-flat"
                        ]
                    ));
                    return $action_buttons;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('store::admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('store::admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = $this->product->create($request->all());

        if ($brand_id = $request->get('brand_id')) {
            $brand = $this->brand->find($brand_id);
            $product->brand()->associate($brand);
            $product->save();
        }

        if ($request->get('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->get('related_products')) {
            $product->related()->sync($request->related_products);
        }

        return redirect()->route('admin.store.product.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('store::products.title.products')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        $productCategories = $product->categories()->get()->pluck('title', 'id')->toArray();
        return view('store::admin.products.edit', compact('product', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product $product
     * @param  Request $request
     * @return Response
     */
    public function update(Product $product, UpdateProductRequest $request)
    {
        $this->product->update($product, $request->all());

        if ($brand_id = $request->get('brand_id')) {
            $brand = $this->brand->find($brand_id);
            $product->brand()->associate($brand);
            $product->save();
        }

        if ($request->get('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->get('related_products')) {
            $product->related()->sync($request->related_products);
        }

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.store.product.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => $product->title]));
        }

        return redirect()->back()
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => $product->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $this->product->destroy($product);

        return redirect()->route('admin.store.product.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('store::products.title.products')]));
    }


    public function duplicate(Product $product)
    {
        $replicate = $product->replicateWithTranslations();
        foreach ($replicate->translations as $translate) {
            $translate->title = $translate->title . '-' . $product->id;
            $translate->slug  = $translate->slug  . '-' . $product->id;
        }
        $replicate->brand()->associate($product->brand);
        $replicate->save();
        $replicate->categories()->sync($product->categories);
        $this->product->clearCache();

        return redirect()->route('admin.store.product.index')
            ->withSuccess(trans('core::core.messages.resource replicated'));
    }
}
