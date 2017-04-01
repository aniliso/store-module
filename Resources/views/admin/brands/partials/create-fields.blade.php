<div class="box-body">
    {!! Form::i18nInput("title", trans('store::brands.form.title'), $errors, $lang, null, ['data-slug'=>'source']) !!}

    {!! Form::i18nInput("slug", trans('store::brands.form.slug'), $errors, $lang, null, ['data-slug'=>'target']) !!}

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#desc_{{ $lang }}" data-toggle="tab">{{ trans('store::stores.tabs.description') }}</a></li>
            <li><a href="#seo_{{ $lang }}" data-toggle="tab">{{ trans('store::stores.tabs.seo') }}</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="desc_{{ $lang }}">
                {!! Form::i18nTextarea("description", trans('store::brands.form.description'), $errors, $lang) !!}
            </div>
            <div class="tab-pane" id="seo_{{ $lang }}">
                <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-{{$lang}}">
                                    {{ trans('store::stores.form.meta_data') }}
                                </a>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="collapseTwo-{{$lang}}" class="panel-collapse collapse">
                            <div class="box-body">
                                {!! Form::i18nInput("meta_title", trans('store::stores.form.meta_title'), $errors, $lang) !!}

                                {!! Form::i18nInput("meta_description", trans('store::stores.form.meta_description'), $errors, $lang) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFacebook-{{$lang}}">
                                    {{ trans('store::stores.form.facebook_data') }}
                                </a>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="collapseFacebook-{{$lang}}" class="panel-collapse collapse">
                            <div class="box-body">

                                {!! Form::i18nInput("og_title", trans('store::stores.form.og_title'), $errors, $lang) !!}

                                {!! Form::i18nInput("og_description", trans('store::stores.form.og_description'), $errors, $lang) !!}

                                <div class="form-group{{ $errors->has("{$lang}[og_type]") ? ' has-error' : '' }}">
                                    <label>{{ trans('store::stores.form.og_type') }}</label>
                                    <select class="form-control" name="{{ $lang }}[og_type]">
                                        <option value="website" {{ old("$lang.og_type") == 'website' ? 'selected' : '' }}>{{ trans('store::stores.facebook-types.website') }}</option>
                                        <option value="product" {{ old("$lang.og_type") == 'product' ? 'selected' : '' }}>{{ trans('store::stores.facebook-types.product') }}</option>
                                        <option value="article" {{ old("$lang.og_type") == 'article' ? 'selected' : '' }}>{{ trans('store::stores.facebook-types.article') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-content -->
    </div>

</div>
