@extends('layouts.master')

@section('content')
    <div class="c-layout-page">

        <div class="c-layout-breadcrumbs-1 c-raindrops c-fonts-uppercase c-fonts-bold">
            <div class="container">
                <div class="c-page-title c-pull-left">
                    <h3 class="c-font-uppercase c-font-white c-font-sbold">{{ trans('store::products.title.products') }}</h3>
                    <h4 class="c-font-thin c-font-white c-opacity-07"></h4>
                </div>
                {!! Breadcrumbs::renderIfExists('store.category') !!}
            </div>
        </div>

        <div class="container">
            <div class="c-layout-sidebar-menu c-theme ">
                <!-- BEGIN: LAYOUT/SIDEBARS/SHOP-SIDEBAR-MENU -->
                <div class="c-sidebar-menu-toggler">
                    <h3 class="c-title c-font-uppercase c-font-bold">{{ trans('store::categories.title.categories') }}</h3>
                    <a href="javascript:;" class="c-content-toggler" data-toggle="collapse" data-target="#sidebar-menu-1">
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                    </a>
                </div>

                <ul class="c-sidebar-menu c-bg-dark-1 m-bot-0 hidden-xs">
                    <li class="c-dropdown c-font-white c-font-bold" style="padding: 15px 25px;">
                        {{ trans('store::categories.title.categories') }}
                    </li>
                </ul>

                {!! app(\Modules\Store\Services\CategoryMenu::class)->render() !!}

            </div>
            <div class="c-layout-sidebar-content ">
                <div class="c-bs-grid-small-space">
                    <div class="row">
                        @if(count($products)>0)
                            @foreach($products as $product)
                                @if($product->categories()->exists())
                                    <div class="col-md-4 col-sm-6 col-xs-12 c-margin-b-20">
                                        <div class="c-content-product-2 c-bg-white c-border">
                                            <div class="c-content-overlay">
                                                <div class="c-overlay-wrapper">
                                                    <div class="c-overlay-content">
                                                        <a href="{{ $product->url }}" class="btn btn-md c-btn-grey-1 c-btn-uppercase c-btn-bold c-btn-border-1x c-btn-square">{{ trans('store::products.title.review') }}</a>
                                                    </div>
                                                </div>
                                                <div class="c-bg-img-center c-overlay-object" data-height="height" style="height: 230px; background-image: url({{ $product->present()->firstImage(null, 230, 'resize', 90) }});"></div>
                                            </div>
                                            <div class="c-info">
                                                <p class="c-title c-font-14 c-font-slim"><a href="{{ $product->url }}">{{ $product->title }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else

                        @endif
                    </div>
                </div>
                <!-- END: CONTENT/SHOPS/SHOP-2-7 -->
                <div class="c-margin-t-20 m-bot-20"></div>
                @if(count($products)>0)
                    @if(view()->exists('store.pagination.default'))
                        {!! $products->render('store.pagination.default') !!}
                    @else
                        {!! $products->render('store::pagination.default') !!}
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@push('css_inline')
<style>
    .row {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
        flex-wrap: wrap;
    }
    .row > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }
</style>
@endpush