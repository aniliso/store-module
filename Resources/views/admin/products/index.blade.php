@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('store::products.title.products') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('store::products.title.products') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.store.product.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('store::products.button.create product') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header"></div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ trans('store::products.form.ordering') }}</th>
                            <th>{{ trans('store::products.form.status') }}</th>
                            <th>{{ trans('store::products.form.sku') }}</th>
                            <th>{{ trans('store::products.form.category') }}</th>
                            <th>{{ trans('store::products.form.title') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
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
        <dd>{{ trans('store::products.title.create product') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.store.product.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "orderCellsTop": true,
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('admin.store.product.index') }}',
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "stateSave": true,
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'ordering', name: 'ordering'},
                    {data: 'status', name: 'status'},
                    {data: 'sku', 'name': 'sku'},
                    {data: 'category', name: 'category'},
                    {data: 'title', name: 'translations.title'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                "drawCallback": function (settings, json) {
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
                    $('a.is_new').on('click', function (e) {
                        e.preventDefault();
                        var is_new = $(this);
                        var id = is_new.data('pk');
                        var val = is_new.data('val') == 0 ? 1 : 0;
                        $.ajax({
                            method: "POST",
                            url: "{{ route('api.store.product.update') }}",
                            data: { pk: id, name: 'is_new', value: val }
                        }).done(function(){
                            is_new.data('val', val);
                            val == 1 ? is_new.toggleClass('bg-red bg-green') : is_new.toggleClass('bg-green bg-red');
                        });
                    });
                }
            });
        });
    </script>
@stop
