@php
/*
$layout_page = shop_product_list
**Variables:**
- $subCategory: paginate
Use paginate: $subCategory->appends(request()->except(['page','_token']))->links()
- $products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/  

@endphp

@extends($sc_templatePath.'.layout')

{{-- block_main_content_center --}}
@section('block_main_content_center')
  {{-- sub category --}}
  @isset ($subCategory)
    @if($subCategory->count())
    <h6 class="aside-title">{{ sc_language_render('front.sub_categories') }}</h6>
    <div class="row item-folder">
        @foreach ($subCategory as $key => $item)
        <div class="col-6 col-sm-6 col-md-3">
            <div class="item-folder-wrapper product-single">
                <div class="single-products">
                    <div class="productinfo text-center product-box-{{ $item->id }}">
                        <a href="{{ $item->getUrl() }}"><img src="{{ sc_file($item->getThumb()) }}"
                                alt="{{ $item->title }}" /></a>
                        <a href="{{ $item->getUrl() }}">
                            <p>{{ $item->title }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

      {{-- Render pagination --}}
      @include($sc_templatePath.'.common.pagination', ['items' => $subCategory])
      {{--// Render pagination --}}
      
    </div>
    @endif
  @endisset
  {{-- //sub category --}}

  @if (count($products))
  <div class="product-top-panel row align-items-center">
    <div class="col-6">
      <!-- Render pagination result -->
      {{-- @include($sc_templatePath.'.common.pagination_result', ['items' => $products]) --}}
      <!--// Render pagination result -->

      <form class="form-header d-flex flex-fill mb-0" action="{{ sc_route('search') }}" method="GET" role="search">
        <div class="input-group">
          <input type="text" value="<?php echo isset($_REQUEST['keyword']) ? $_REQUEST['keyword']:'' ?>" name="keyword" class="form-control" placeholder="buscar ej.  265/70R-17 " aria-label="Introducir parametros de busqueda" aria-describedby="button-Search">
          <button class="btn btn-outline-secondary" type="submit" id="button-Search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
      </form>
  
    </div>
    <div class="col-6">
      <!-- Render include filter sort -->
      @include($sc_templatePath.'.common.product_filter_sort', ['filterSort' => $filter_sort])
      <!--// Render include filter sort -->
    </div>
    
  </div>
 

    <!-- Product list -->
    <article class="product_grip_shop py-3">
      @foreach ($products as $key => $product)
          <!-- Render product single -->
          @include($sc_templatePath.'.common.product_single', ['product' => $product])
          <!-- //Render product single -->
      @endforeach
    </article>
    <!-- //Product list -->

    <!-- Render pagination -->
    @include($sc_templatePath.'.common.pagination', ['items' => $products])
    <!--// Render pagination -->
  @else
  <div class="product-top-panel group-md">
    <p style="text-align:center">{!! sc_language_render('front.no_item') !!}</p>
  </div>
  @endif

@endsection
{{-- //block_main_content_center --}}


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush