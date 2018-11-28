<div class="row">
    <div class="col-md-3 form-group{{ $errors->has("settings.title_color") ? ' has-error' : '' }}">
        {!! Form::label("settings.size", "Ölçü".':') !!}
        {!! Form::input('text', 'settings[size]', !isset($product->settings->size) ? '' : $product->settings->size, ['class'=>'form-control']) !!}
        {!! $errors->first("settings.size", '<span class="help-block">:message</span>') !!}
    </div>
</div>