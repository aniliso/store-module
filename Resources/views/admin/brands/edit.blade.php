@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('store::brands.title.edit brand') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.store.brand.index') }}">{{ trans('store::brands.title.brands') }}</a></li>
        <li class="active">{{ trans('store::brands.title.edit brand') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.store.brand.update', $brand->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-10">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('store::admin.brands.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat" name="button" value="index" >
                            <i class="fa fa-angle-left"></i>
                            {{ trans('core::core.button.update and back') }}
                        </button>
                        <button type="submit" class="btn btn-primary btn-flat">
                            {{ trans('core::core.button.update') }}
                        </button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.store.brand.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-md-2">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label("status", trans('store::stores.form.status').':') !!}
                        <select name="status" id="status" class="form-control">
                            <?php foreach ($statuses as $id => $status): ?>
                            <option value="{{ $id }}" {{ old('status', $brand->status) == $id ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    {!! Form::normalInput('ordering', trans('store::stores.form.ordering'), $errors, $brand) !!}
                    <hr/>
                    @mediaSingle('brandImage', $brand, null, trans('store::brands.form.image'))
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class='form-group{{ $errors->has("meta_robot_no_index") ? ' has-error' : '' }}'>
                        {!! Form::hidden("meta_robot_no_index", 'index') !!}
                        {!! Form::checkbox("meta_robot_no_index", 'noindex', old("meta_robot_no_index", ($brand->meta_robot_no_index == 'index' ? 0 : 1)), ['class' => 'flat-blue']) !!}
                        {!! Form::label("meta_robot_no_index", trans('blog::post.form.meta_robot_no_index')) !!}
                        {!! $errors->first("meta_robot_no_index", '<span class="help-block">:message</span>') !!}
                        <br/>
                        {!! Form::hidden("meta_robot_no_follow", 'follow') !!}
                        {!! Form::checkbox("meta_robot_no_follow", 'nofollow', old("meta_robot_no_follow", ($brand->meta_robot_no_follow == 'follow' ? 0 : 1)), ['class' => 'flat-blue']) !!}
                        {!! Form::label("meta_robot_no_follow", trans('blog::post.form.meta_robot_no_follow')) !!}
                        {!! $errors->first("meta_robot_no_follow", '<span class="help-block">:message</span>') !!}
                        <br/>
                        {!! Form::hidden("sitemap_include", 0) !!}
                        {!! Form::checkbox("sitemap_include", 1, old("sitemap_include", ($brand->sitemap_include == 1 ? 1 : 0)), ['class' => 'flat-blue']) !!}
                        {!! Form::label("sitemap_include", trans('core::sitemap.title.include')) !!}
                        {!! $errors->first("sitemap_include", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::normalSelect('sitemap_frequency', trans('core::sitemap.title.frequency'), $errors, $sitemapFrequencies, $brand->sitemap_frequency) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::normalSelect('sitemap_priority', trans('core::sitemap.title.priority'), $errors, $sitemapPriorities, $brand->sitemap_priority) !!}
                    </div>
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
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.store.brand.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@stop
