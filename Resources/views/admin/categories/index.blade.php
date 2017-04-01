@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('store::categories.title.categories') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('store::categories.title.categories') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.store.category.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('store::categories.button.create category') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ trans('store::categories.form.ordering') }}</th>
                            <th>{{ trans('store::categories.form.status') }}</th>
                            <th>{{ trans('store::products.title.products') }}</th>
                            <th>{{ trans('store::categories.form.parent') }}</th>
                            <th>{{ trans('store::categories.title.category') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                {{ $category->id }}
                            </td>
                            <td>
                                <a href="#" class="editable" id="ordering" data-url="{{ route('api.store.category.update') }}" data-type="text" data-pk="{{ $category->id }}" data-title="{{ trans('store::categories.form.ordering') }}">
                                    {{ $category->ordering }}
                                </a>
                            </td>
                            <td>
                                <a href="#" class="status" id="status" data-url="{{ route('api.store.category.update') }}" data-value="{{ $category->status }}" data-type="select" data-pk="{{ $category->id }}" data-title="{{ trans('store::categories.form.status') }}">
                                    {{ $category->present()->status }}
                                </a>
                            </td>
                            <td>
                                {{ $category->products()->count() }}
                            </td>
                            <td>
                                <a href="{{ route('admin.store.category.edit', [$category->id]) }}">
                                    {{ $category->present()->titleWithSelf(' > ') }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.store.category.edit', [$category->id]) }}">
                                    {{ $category->title }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.store.category.edit', [$category->id]) }}">
                                    {{ $category->created_at }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.store.category.edit', [$category->id]) }}" class="btn btn-default btn-xs btn-flat"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-flat btn-xs" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.store.category.destroy', [$category->id]) }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('store::categories.title.create category') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.store.category.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                "initComplete": function (settings, json) {
                    $('.editable').editable({
                        mode: 'inline',
                        container: 'body'
                    });
                    $('.status').editable({
                        mode: 'inline',
                        source: [
                            {value: 0, text: '{{ trans('global.form.status draft') }}'},
                            {value: 1, text: '{{ trans('global.form.status published') }}'}
                        ],
                        display: function(value) {
                            if(value == 1) {
                                return $(this).html('<span class="label bg-green">{{ trans('global.form.status published') }}</span>');
                            }
                            return $(this).html('<span class="label bg-red">{{ trans('global.form.status draft') }}</span>');
                        }
                    });
                }
            });
        });
    </script>
@stop
