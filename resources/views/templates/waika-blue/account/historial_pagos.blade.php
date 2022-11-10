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
    

      <table class="table box table-bordered" width="100%">
        <thead>
          <tr>
            <th style="width: 50px;">No.</th>
            <th style="width: 100px;">Id Orden</th>
            <th>Pagado</th>
            <th>Forma de pago</th>
            <th>estatus del pago</th>
            <th>{{ sc_language_render('common.created_at') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($historial_pagos as $historial)
          <tr>
          @php
          $n = (isset($n)?$n:0);
          $n++;
          @endphp
        <td><span class="item_21_id">{{ $n }}</span></td>
        <td><span class="item_21_sku">{{ $historial->order_id }}</span></td>
        <td><span class="item_21_sku">{{ $historial->importe_pagado}}</span></td>
        <td><span class="item_21_sku">{{ $historial->metodo_pago->name}}</span></td>
        <td><span class="item_21_sku">{!! isset($historial->estatus->name ) ?$historial->estatus->name  :'';  !!}</span></td>
        <td><span class="item_21_sku">{{ $historial->created_at->format('d/m/Y')}}</span></td>
        <td>              <a href="{{ sc_route('customer.order_detail', ['id' =>  $historial->order_id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ sc_language_render('order.detail') }}</a><br>
        </td>
      </tr>
@endforeach
        </tbody>
      </table>

@endsection