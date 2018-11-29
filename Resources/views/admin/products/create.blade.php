@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('store::products.title.create product') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.store.product.index') }}">{{ trans('store::products.title.products') }}</a></li>
        <li class="active">{{ trans('store::products.title.create product') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.store.product.store'], 'method' => 'post', 'id'=>'product']) !!}
    <div class="row">
        <div class="col-md-10">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">

                    <div class="box-body">
                        <div class="form-group{{ $errors->has("categories") ? ' has-error' : '' }}">
                            {!! Form::label('product_category', trans('store::products.form.category')) !!}
                            <select name="categories[]" class="category ui fluid multiple search selection dropdown" multiple="" id="multi-select" style="width: 100%;">
                                @foreach($categoryLists as $key => $categoryList)
                                    <option value="{{ $key }}" @if(@in_array($key, old('categories')))selected @endif>{{ $categoryList }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first("categories", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('store::admin.products.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has("categories") ? ' has-error' : '' }}">
                            {!! Form::label('related_products', trans('store::products.form.related')) !!}
                            <select name="related_products[]" class="remote related ui fluid multiple search selection dropdown" multiple="" id="multi-select" style="width: 100%;">
                            </select>
                            {!! $errors->first("categories", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        {!! Form::normalInput('video', trans('store::products.form.video'), $errors) !!}
                    </div>

                    <div class="col-md-12">
                        @mediaMultiple('productImages', null, null, trans('store::products.form.image'))
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.store.product.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-md-2">

            @includeIf('store::admin.products.partials.settings-fields')

            <div class="box box-primary">
                <div class="box-body">

                    {!! Form::normalSelect('brand_id', trans('store::products.form.brand_id'), $errors, $brands, null, ['class'=>'brand ui search dropdown']) !!}

                    {!! Form::normalInput('sku', trans('store::products.form.sku'), $errors) !!}

                    {!! Form::normalInput('model', trans('store::products.form.model'), $errors) !!}

                    {!! Form::normalInput('price', trans('store::products.form.price'), $errors) !!}
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {!! Form::label("status", trans('blog::post.form.status').':') !!}
                        <select name="status" id="status" class="form-control">
                            <?php foreach ($statuses as $id => $status): ?>
                            <option value="{{ $id }}" {{ old('status', 0) == $id ? 'selected' : '' }}>{{ $status }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    {!! Form::normalInput('ordering', trans('store::stores.form.ordering'), $errors) !!}

                    @tags('asgardcms/store/product')

                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class='form-group{{ $errors->has("meta_robot_no_index") ? ' has-error' : '' }}'>
                        {!! Form::checkbox("meta_robot_no_index", 'noindex', old("meta_robot_no_index"), ['class' => 'flat-blue']) !!}
                        {!! Form::label("meta_robot_no_index", trans('store::stores.form.meta_robot_no_index')) !!}
                        {!! $errors->first("meta_robot_no_index", '<span class="help-block">:message</span>') !!}
                        <br/>
                        {!! Form::checkbox("meta_robot_no_follow", 'nofollow', old("meta_robot_no_follow"), ['class' => 'flat-blue']) !!}
                        {!! Form::label("meta_robot_no_follow", trans('store::stores.form.meta_robot_no_follow')) !!}
                        {!! $errors->first("meta_robot_no_follow", '<span class="help-block">:message</span>') !!}
                        <br/>
                        {!! Form::checkbox("sitemap_include", '1', old("sitemap_include", 1), ['class' => 'flat-blue']) !!}
                        {!! Form::label("sitemap_include", trans('core::sitemap.title.include')) !!}
                        {!! $errors->first("sitemap_include", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::normalSelect('sitemap_frequency', trans('core::sitemap.title.frequency'), $errors, $sitemapFrequencies, 'weekly') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::normalSelect('sitemap_priority', trans('core::sitemap.title.priority'), $errors, $sitemapPriorities, '0.9') !!}
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    @mediaSingle('productFiles', null, null, trans('store::products.form.file'))
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'b', route: "<?= route('admin.store.product.index') ?>"}
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $('.category.ui.dropdown').dropdown({
                fullTextSearch: true,
                forceSelection: false,
                saveRemoteData: true,
                match: 'text',
                message: {
                    noResults: '{{ trans('store::products.messages.no results') }}'
                }
            });
            $('.brand.ui.dropdown').dropdown({
                fullTextSearch: true,
                match: 'text',
                message: {
                    noResults: '{{ trans('store::products.messages.no results') }}'
                }
            });
            $('.remote.related.ui.dropdown').dropdown({
                message: {
                    noResults: '{{ trans('store::products.messages.no results') }}'
                },
                forceSelection: false,
                apiSettings: {
                    url: '{{ route('api.store.product.related') }}',
                    data: {_token: '{{ csrf_token() }}'},
                    cache: false,
                    beforeSend: function (settings) {
                        settings.data = {
                            categories: JSON.stringify($('.category.ui.dropdown').dropdown('get values')),
                            products: JSON.stringify($('.remote.related.ui.dropdown').dropdown('get values'))
                        };
                        return settings;
                    }
                }
            });
        });
    </script>
@stop
