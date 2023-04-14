{{-- breadcrumb --}}
@if (!empty($breadcrumbs) && count($breadcrumbs))
<section class="breadcrumbs-custom">
    @if (!empty($layout_page))
        @php
            $bannerBreadcrumbImage = '';
            $bannerBreadcrumbTmp = [];
            $arrBreadcrumbPage = [
                'shop_product_list',
                'shop_contact', 
                'shop_page', 
                'shop_news',
                'shop_news_detail', 
                'shop_item_list',
                'shop_product_detail',
                'shop_search'
            ];
            $arrBreadcrumbHome = [
                'shop_home',
                'vendor_home',
                'vendor_product_list'
            ];
            if (in_array($layout_page, $arrBreadcrumbPage)) {
                $bannerBreadcrumbTmp = $modelBanner->start()->getBreadcrumb()->getData()->first();
                $brPosition = 'bg-br-page';
            } elseif (in_array($layout_page, $arrBreadcrumbHome)) {
                if (isset($storeId)) {
                    $bannerBreadcrumbTmp = $modelBanner->start()->setStore($storeId)->getBannerStore()->getData()->first();
                } else {
                    $bannerBreadcrumbTmp = $modelBanner->start()->getBannerStore()->getData()->first();
                }
                $brPosition = 'bg-br-home';
            }
            if ($bannerBreadcrumbTmp) {
                $bannerBreadcrumbImage = sc_file($bannerBreadcrumbTmp['image'] ?? '');
            }
        @endphp

        {{-- @if ($bannerBreadcrumbImage)
        <section id="parallax-vertical" >
            <div class="ma-parallax text-center jumbotron bg-faded " style="background: url(&quot;{{ $bannerBreadcrumbImage }}&quot;) center -59px no-repeat;" data-paroller-factor="0.3">
            </div>
        </section>
   
        <div class="parallax-container" data-parallax-img="{{ $bannerBreadcrumbImage }}">
            <div class="material-parallax parallax"> 
            <img src="{{ $bannerBreadcrumbImage }}" alt="" style="display: block; transform: translate3d(-50%, 83px, 0px);">
            </div>
            <div class="breadcrumbs-custom-body parallax-content context-dark">
            <div class="container">
                <h2 class="breadcrumbs-custom-title">{{ $title ?? '' }}</h2>
            </div>
            </div>
        </div>
        @endif --}}
    @endif

    <div class="container">
        <div class="row">
            <div class="col-12 py-3">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center"><a href="{{ sc_route('home') }}">{{ sc_language_render('front.home') }}</a></li>
                      @foreach ($breadcrumbs as $key => $item)
                        @if (($key + 1) == count($breadcrumbs))
                            <li class="breadcrumb-item active d-flex align-items-center" aria-current="page">{{ $item['title'] }}</li>
                        @else
                            <li class="breadcrumb-item d-flex align-items-center" aria-current="page"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
                        @endif
                      @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
</section>
@endif
{{-- //breadcrumb --}}