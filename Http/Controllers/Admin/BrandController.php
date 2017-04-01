<?php

namespace Modules\Store\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Repositories\FileRepository;
use Modules\Store\Entities\Brand;
use Modules\Store\Entities\Helpers\Status;
use Modules\Store\Http\Requests\Brand\CreateBrandRequest;
use Modules\Store\Http\Requests\Brand\UpdateBrandRequest;
use Modules\Store\Repositories\BrandRepository;

class BrandController extends AdminBaseController
{
    /**
     * @var BrandRepository
     */
    private $brand;
    /**
     * @var Status
     */
    private $status;
    /**
     * @var FileRepository
     */
    private $file;

    public function __construct(BrandRepository $brand, Status $status, FileRepository $file)
    {
        parent::__construct();
        $this->brand = $brand;
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
        $brands = $this->brand->all();

        return view('store::admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('store::admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CreateBrandRequest $request)
    {
        $this->brand->create($request->all());

        return redirect()->route('admin.store.brand.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('store::brands.title.brands')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Brand $brand
     * @return Response
     */
    public function edit(Brand $brand)
    {
        return view('store::admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Brand $brand
     * @param  Request $request
     * @return Response
     */
    public function update(Brand $brand, UpdateBrandRequest $request)
    {
        $this->brand->update($brand, $request->all());

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.store.brand.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => $brand->title]));
        }

        return redirect()->back()
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => $brand->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Brand $brand
     * @return Response
     */
    public function destroy(Brand $brand)
    {
        $this->brand->destroy($brand);

        return redirect()->route('admin.store.brand.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('store::brands.title.brands')]));
    }
}
