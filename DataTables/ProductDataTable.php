<?php namespace Modules\Store\DataTables;

use Modules\Store\Repositories\ProductRepository;
use Yajra\Datatables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
                    ->eloquent($this->query())
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
                                'class'      => "btn btn-default btn-flat is_new $is_new",
                                'data-pk'    => $product->id,
                                'data-val'   => $product->is_new
                            ]
                        ));
                        $action_buttons .= \Html::decode(link_to(
                            route('admin.store.product.edit',
                                [$product->id]),
                            '<i class="fa fa-pencil"></i>',
                            ['class' => 'btn btn-default btn-flat']
                        ));
                        $action_buttons .= \Html::decode(\Form::button(
                            '<i class="fa fa-trash"></i>',
                            [
                                "data-toggle"        => "modal",
                                "data-action-target" => route("admin.store.product.destroy", [$product->id]),
                                "data-target"        => "#modal-delete-confirmation",
                                "class"              => "btn btn-danger btn-flat"
                            ]
                        ));
                        return $action_buttons;
                    })
                    ->make(true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = app(ProductRepository::class)->query();
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->addAction(['width'=>'80px'])
                    ->parameters([
                        'buttons' => ['excel']
                    ]);
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return [
            'id',
            'title',
            'slug',
            'created_at',
            'updated_at'
        ];
    }
}