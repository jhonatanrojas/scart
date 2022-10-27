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
      <table class="table box table-bordered" width="100%">
        <thead>
          <tr>
            <th style="width: 50px;">No.</th>
            <th style="width: 100px;">ID</th>
            <th>{{ sc_language_render('order.total') }}</th>
            <th>estatus del pago</th>
            <th>{{ sc_language_render('common.created_at') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
      
        </tbody>
      </table>

@endsection