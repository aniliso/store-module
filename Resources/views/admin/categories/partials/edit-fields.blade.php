<div class="box-body">
    {!! Form::i18nInput("title", trans('store::categories.form.title'), $errors, $lang, $category, ['data-slug'=>'source']) !!}

    {!! Form::i18nInput("slug", trans('store::categories.form.slug'), $errors, $lang, $category, ['data-slug'=>'target']) !!}

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#desc_{{ $lang }}" data-toggle="tab">Açıklama</a></li>
            <li><a href="#seo_{{ $lang }}" data-toggle="tab">SEO</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="desc_{{ $lang }}">
                {!! Form::i18nTextarea("description", trans('store::categories.form.description'), $errors, $lang, $category) !!}
            </div>
            <div class="tab-pane" id="seo_{{ $lang }}">
                <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-{{$lang}}">
                                    {{ trans('store::categories.form.meta_data') }}
                                </a>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="collapseTwo-{{$lang}}" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class='form-group{{ $errors->has("{$lang}[meta_title]") ? ' has-error' : '' }}'>
                                    {!! Form::label("{$lang}[meta_title]", trans('store::categories.form.meta_title')) !!}
                                    {!! Form::text("{$lang}[meta_title]", old("$lang.meta_title"), ['class' => "form-control", 'placeholder' => trans('store::categories.form.meta_title')]) !!}
                                    {!! $errors->first("{$lang}[meta_title]", '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class='form-group{{ $errors->has("{$lang}[meta_description]") ? ' has-error' : '' }}'>
                                    {!! Form::label("{$lang}[meta_description]", trans('store::categories.form.meta_description')) !!}
                                    <textarea class="form-control" name="{{$lang}}[meta_description]" rows="10" cols="80">{{ old("$lang.meta_description") }}</textarea>
                                    {!! $errors->first("{$lang}[meta_description]", '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFacebook-{{$lang}}">
                                    {{ trans('store::categories.form.facebook_data') }}
                                </a>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="collapseFacebook-{{$lang}}" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class='form-group{{ $errors->has("{$lang}[og_title]") ? ' has-error' : '' }}'>
                                    {!! Form::label("{$lang}[og_title]", trans('store::categories.form.og_title')) !!}
                                    {!! Form::text("{$lang}[og_title]", old("{$lang}.og_title"), ['class' => "form-control", 'placeholder' => trans('store::categories.form.og_title')]) !!}
                                    {!! $errors->first("{$lang}[og_title]", '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class='form-group{{ $errors->has("{$lang}[og_description]") ? ' has-error' : '' }}'>
                                    {!! Form::label("{$lang}[og_description]", trans('store::categories.form.og_description')) !!}
                                    <textarea class="form-control" name="{{$lang}}[og_description]" rows="10" cols="80">{{ old("$lang.og_description") }}</textarea>
                                    {!! $errors->first("{$lang}[og_description]", '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-group{{ $errors->has("{$lang}[og_type]") ? ' has-error' : '' }}">
                                    <label>{{ trans('store::categories.form.og_type') }}</label>
                                    <select class="form-control" name="{{ $lang }}[og_type]">
                                        <option value="website" {{ old("$lang.og_type") == 'website' ? 'selected' : '' }}>{{ trans('store::categories.facebook-types.website') }}</option>
                                        <option value="product" {{ old("$lang.og_type") == 'product' ? 'selected' : '' }}>{{ trans('store::categories.facebook-types.product') }}</option>
                                        <option value="article" {{ old("$lang.og_type") == 'article' ? 'selected' : '' }}>{{ trans('store::categories.facebook-types.article') }}</option>
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
