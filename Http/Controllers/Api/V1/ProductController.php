<?php namespace Modules\Store\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Store\Entities\Product;
use Modules\Store\Repositories\ProductRepository;

class ProductController extends AdminBaseController
{
    /**
     * @var ProductRepository
     */
    private $product;

    /**
     * ProductController constructor.
     * @param ProductRepository $product
     */
    public function __construct(ProductRepository $product)
    {
        parent::__construct();
        $this->product = $product;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function related(Request $request)
    {
        if($request->ajax())
        {
            $exceptProducts = $request->products ? json_decode($request->products) : [];
            $selectedCategories = $request->categories ? json_decode($request->categories) : [];
            $products = Product::whereHas('categories', function(Builder $q) use ($selectedCategories) {
                if(is_array($selectedCategories)) {
                    $q->whereIn('category_id', $selectedCategories);
                }
            })->SearchByKeyword($request->get('keyword'))
                ->get()
                ->except($request->exceptProduct)
                ->except($exceptProducts)
                ->map(function($product) {
                return [
                    'name' => $product->title,
                    'value' => $product->id,
                    'text' => $product->title
                ];
            });
            return response()->json([
                'success' => true,
                'results' => $products
            ], Response::HTTP_ACCEPTED);
        }
        return response()->json([
           'success' => false
        ], Response::HTTP_BAD_REQUEST);
    }

    public function update(Request $request)
    {
        if($request->ajax())
        {
            if($request->get('pk'))
            {
                $product = $this->product->find($request->get('pk'));
                if($this->product->update($product, [$request->get('name') => $request->get('value')])) {
                    return response()->json([
                        'success' => true
                    ], Response::HTTP_ACCEPTED);
                }
                return response()->json([
                    'success' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        return response()->json([
            'success' => false
        ], Response::HTTP_BAD_REQUEST);
    }
}