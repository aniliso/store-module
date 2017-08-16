@extends('layouts.master')

@section('content')

<div class="c-layout-page">

    <div class="c-layout-breadcrumbs-1 c-raindrops c-fonts-uppercase c-fonts-bold">
        <div class="container">
            <div class="c-page-title c-pull-left">
                <h3 class="c-font-uppercase c-font-white c-font-sbold">{{ $product->title }}</h3>
                <h4 class="c-font-thin c-font-white c-opacity-07">{{ @$product->categories()->first()->title }}</h4>
            </div>
            {!! Breadcrumbs::renderIfExists('store.product') !!}
        </div>
    </div>

    <div class="c-content-box c-size-lg c-overflow-hide c-bg-white">
            <div class="container">
                <div class="c-shop-product-details-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="c-product-gallery">
                                <div class="c-product-gallery-content">
                                    @foreach($product->present()->images(null, 900, 'resize', 80) as $image)
                                    <div class="c-zoom">
                                        <img src="{{ $image }}">
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row c-product-gallery-thumbnail" style="height: 150px;">
                                    @foreach($product->present()->images(null, 150, 'resize', 80) as $image)
                                    <div class="col-xs-3 c-product-thumb" style="height: 150px;">
                                        <img src="{{ $image }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="c-product-meta">
                                <div class="c-content-title-1">
                                    <h3 class="c-font-uppercase c-font-bold">{{ $product->present()->titleWithBrand }}<br/>{{ $product->sku }}</h3>
                                    <h4 class="c-font-uppercase c-font-bold">{{ $product->present()->firstCategory }}</h4>
                                    <div class="c-line-left"></div>
                                </div>
                                @if($product->is_new)
                                <div class="c-product-badge">
                                    <div class="c-product-new">
                                        {!! trans('store::products.title.new') !!}
                                    </div>
                                </div>
                                @endif
                                <div class="c-product-review">

                                </div>
                                <div class="c-product-price">

                                </div>
                                <div class="c-product-short-desc">
                                    {!! $product->description !!}
                                </div>

                                <div class="c-product-tags">
                                    @foreach($product->tags()->get() as $tag)
                                    <span class="c-content-label c-font-uppercase c-font-bold c-bg-red">{{ $tag->name }}</span>
                                    @endforeach
                                </div>

                                @if($product->present()->file)
                                <div class="row c-product-variant">
                                    <a href="{{ url($product->present()->file) }}">{{ trans('store::products.buttons.download catalog') }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($product->related()->count()>0)

                    <div class="row">
                        <div class="c-content-title-1 wow animate fadeInDown" style="visibility: visible; animation-name: fadeInDown;">
                            <h3 class="c-font-uppercase c-center c-font-bold">{{ trans('store::products.title.same products') }}</h3>
                            <div class="c-line-center"></div>
                        </div>


                            @foreach($product->related()->get() as $related)
                                @if($related->categories()->exists())
                                    <div class="col-md-3 col-sm-4 c-margin-b-20">
                                        <div class="c-content-product-2 c-bg-white c-border">
                                            <div class="c-content-overlay">
                                                <div class="c-overlay-wrapper">
                                                    <div class="c-overlay-content">
                                                        <a href="{{ $related->url }}" class="btn btn-md c-btn-grey-1 c-btn-uppercase c-btn-bold c-btn-border-1x c-btn-square">{{ trans('store::stores.title.review') }}</a>
                                                    </div>
                                                </div>
                                                @if($file = $related->present()->firstImage(null, 230, 'resize', 80))
                                                    <div class="c-bg-img-center c-overlay-object" data-height="height" style="height: 230px; background-image: url({{ $file }});"></div>
                                                @endif
                                            </div>
                                            <div class="c-info">
                                                <p class="c-title c-font-12 c-font-slim"><a href="{{ $related->url }}">{{ $related->title }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                    </div>
                    @endif

                </div>
            </div>
        </div>

</div>

@endsection

@push('scripts')
{!! Theme::script('js/plugins/zoom-master/jquery.zoom.min.js') !!}
@endpush