@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('store::brands.title.create brand') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.store.brand.index') }}">{{ trans('store::brands.title.brands') }}</a></li>
        <li class="active">{{ trans('store::brands.title.create brand') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.store.brand.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-10">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('store::admin.brands.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
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
                            <option value="{{ $id }}" {{ old('status', 0) == $id ? 'selected' : '' }}>{{ $status }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    {!! Form::normalInput('ordering', trans('store::stores.form.ordering'), $errors) !!}
                    <hr/>
                    @mediaSingle('brandImage', null, null, trans('store::stores.form.image'))
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class='form-group{{ $errors->has("meta_robot_no_index") ? ' has-error' : '' }}'>
                        {!! Form::checkbox("meta_robot_no_index", 'noindex', old("meta_robot_no_index"), ['class' => 'flat-blue']) !!}
                        {!! Form::label("meta_robot_no_index", trans('page::pages.form.meta_robot_no_index')) !!}
                        {!! $errors->first("meta_robot_no_index", '<span class="help-block">:message</span>') !!}
                        <br/>
                        {!! Form::checkbox("meta_robot_no_follow", 'nofollow', old("meta_robot_no_follow"), ['class' => 'flat-blue']) !!}
                        {!! Form::label("meta_robot_no_follow", trans('page::pages.form.meta_robot_no_follow')) !!}
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
