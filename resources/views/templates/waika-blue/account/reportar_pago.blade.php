@php
/*
$layout_page = shop_profile
** Variables:**
- $statusOrder
- $orders
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
<h6 class="title-store">{{ $title }}</h6>
    
<div class="d-flex justify-content-end">
    <div class="d-flex align-items-end">
        <button class="btn btn-info mb-2"> Reportar Pago </button>
    </div>
</div>
    

@endsection