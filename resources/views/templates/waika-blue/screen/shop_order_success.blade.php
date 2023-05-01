@php
/*
$layout_page = shop_order_success
**Variables:**
- $orderInfo
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<h6 class="aside-title">{{ $title }}</h6>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-page text-center">{{ $title }}</h2>
        </div>
        <div class="col-md-12 text-success">
            <h2  class="text-center" >{{ sc_language_render('checkout.order_success_msg') }}</h2>
            <h3  class="text-center" >{{ sc_language_render('checkout.order_success_order_info', ['order_id'=>session('orderID')]) }}</h3>
            <h4 class="text-center" style="color: #007bff;">              
                <a href="{{ sc_route('customer.order_detail', ['id' => session('orderID') ]) }}">
                    <i class="fa fa-indent" aria-hidden="true"></i>  
                    VER {{ sc_language_render('order.detail') }}</a><br>
       </h4>
       
        </div>
    </div>
</div>
@endsection


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush
