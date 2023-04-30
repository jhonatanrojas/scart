@php
/*
$layout_page = 'shop_home'

*/ 
@endphp

@extends($sc_templatePath.'.layout')

{{--  block_main_content_center  --}}
@section('block_main_content_center')
 
  @if (count($products))
    <div class="product-top-panel row align-items-center">
      <div class="col-6">
        <!-- Render pagination result -->
        @include($sc_templatePath.'.common.pagination_result', ['items' => $products])
        <!--// Render pagination result -->
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
{{--  //block_main_content_center  --}}


@push('styles')
@endpush

@push('scripts')
<!-- //script here -->
@endpush