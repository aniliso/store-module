<?php

namespace Modules\Store\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Media\Repositories\FileRepository;
use Modules\Store\Entities\Category;
use Modules\Store\Entities\Helpers\Status;
use Modules\Store\Http\Requests\Category\CreateCategoryRequest;
use Modules\Store\Http\Requests\Category\UpdateCategoryRequest;
use Modules\Store\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;
    /**
     * @var Status
     */
    private $status;
    /**
     * @var FileRepository
     */
    private $file;

    public function __construct(CategoryRepository $category, Status $status, FileRepository $file)
    {
        parent::__construct();

        $this->category = $category;
        $this->status = $status;
        $this->file = $file;

        view()->share('statuses', $this->status->lists());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->category->all();

        return view('store::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categoryList = ['' => trans('store::categories.form.no-category')] + Category::getNestedList('title', null, '-> ');
        return view('store::admin.categories.create', compact('categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return redirect()->route('admin.store.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('store::categories.title.categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        $categories = $this->category->lists($category->id);
        $categoryList = ['' => trans('store::categories.form.no-category')] + $categories;
        return view('store::admin.categories.edit', compact('category', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category $category
     * @param  Request $request
     * @return Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->category->update($category, $request->all());

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.store.category.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => $category->title]));
        }

        return redirect()->back()
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => $category->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $this->category->destroy($category);

        return redirect()->route('admin.store.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('store::categories.title.categories')]));
    }
}
