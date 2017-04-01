<?php

namespace Modules\Store\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Store\Entities\Category;
use Modules\Store\Repositories\CategoryRepository;

class CategoryController extends AdminBaseController
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

    public function lists(Request $request)
    {
        if ($request->ajax()) {
            $selectedCategories = json_decode($request->get('categories')) ? json_decode($request->get('categories')) : [];
            $categories = collect(Category::getNestedList('title', null, ' > '))->map(function ($value, $key) {
                return [
                    'name'  => $value,
                    'value' => $key,
                    'text'  => $value
                ];
            })->filter(function($value, $key) use($selectedCategories) {
                if(!in_array($key, $selectedCategories)) {
                    return $value;
                }
            })->filter(function($value, $key) use($request) {
                if($keyword = $request->get('keyword')) {
                    if(preg_match("/$keyword/", $value['text'])) {
                        return $value;
                    }
                } else {
                    return $value;
                }
            });

            return response()->json([
                'success' => true,
                'results' => isset($filtered) ? $filtered : $categories
            ]);
        }
    }

    public function update(Request $request)
    {
        if($request->ajax())
        {
            if($request->get('pk'))
            {
                if($request->get('title')) {
                    $request->slug = str_slug($request->get('title'), '-');
                }
                $category = $this->category->find($request->get('pk'));
                if($this->category->update($category, [$request->get('name') => $request->get('value')])) {
                    return response()->json([
                        'success' => true
                    ], Response::HTTP_ACCEPTED);
                }
                return response()->json([
                    'success' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
