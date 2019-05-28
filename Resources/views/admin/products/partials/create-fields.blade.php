<div class="box-body">
    {!! Form::i18nInput("title", trans('store::products.form.title'), $errors, $lang, null, ['data-slug'=>'source']) !!}

    {!! Form::i18nInput("slug", trans('store::products.form.slug'), $errors, $lang, null, ['data-slug'=>'target']) !!}

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#desc_{{ $lang }}" data-toggle="tab">{{ trans('store::stores.tabs.description') }}</a></li>
            <li><a href="#tech_{{ $lang }}" data-toggle="tab">{{ trans('store::stores.tabs.tech') }}</a></li>
            <li><a href="#seo_{{ $lang }}" data-toggle="tab">{{ trans('store::stores.tabs.seo') }}</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="desc_{{ $lang }}">
                {!! Form::i18nTextarea("description", trans('store::products.form.description'), $errors, $lang) !!}
            </div>
            <div class="tab-pane" id="tech_{{ $lang }}">
                {!! Form::i18nTextarea("technical_description", trans('store::products.form.technical_description'), $errors, $lang) !!}
            </div>
            <div class="tab-pane" id="seo_{{ $lang }}">
                <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-{{$lang}}">
                                    {{ trans('store::products.form.meta_data') }}
                                </a>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="collapseTwo-{{$lang}}" class="panel-collapse collapse">
                            <div class="box-body">
                                {!! Form::i18nInput("meta_title", trans('store::products.form.meta_title'), $errors, $lang) !!}

                                {!! Form::i18nInput("meta_description", trans('store::products.form.meta_description'), $errors, $lang) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFacebook-{{$lang}}">
                                    {{ trans('store::products.form.facebook_data') }}
                                </a>
                            </h4>
                        </div>
                        <div style="height: 0px;" id="collapseFacebook-{{$lang}}" class="panel-collapse collapse">
                            <div class="box-body">

                                {!! Form::i18nInput("og_title", trans('store::products.form.og_title'), $errors, $lang) !!}

                                {!! Form::i18nInput("og_description", trans('store::products.form.og_description'), $errors, $lang) !!}

                                {!! Form::i18nSelect("og_type", trans('store::products.form.og_type'), $errors, $lang, array_combine(['website','product','article'],['website','product','article'])) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>
