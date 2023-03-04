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

@if(count($historial_pagos) ==0)
<div class="text-danger">
  {{sc_language_render('front.data_notfound') }}
</div>
@else
<div class="panel-heading animate__animated animate__backInRight">
  <h5 class="panel-title">{{ $title }}</h5>

</div>
    <div class="table-responsive">

      <table class="table table-hover box-body text-wrap table-fixed" width="100%">
        <thead class="table-dark">
          <tr>
            <th style="width: 50px;">No.</th>
            <th style="width: 100px;">Convenio</th>
            <th style="width: 100px;">Solicitud</th>
            <th >Producto</th>
            <th>Pagado</th>
            <th>Divisa</th>
            <th>Tasa </th>
            <th>Forma de pago</th>
            <th>estatus</th>
            <th>Fecha de reporte</th>
            <th>Acciones</th>
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
            
            <td><span class="item_21_sku">{{$historial->nro_convenio}}</span></td>
            <td>
              <span class="item_21_sku">{{ $historial->order_id }}</span>
            </td>

            <td>
              <span class="item_21_sku">{{ $historial->nombre_product }}</span>
            </td>


            <td><span class="item_21_sku">{{ $historial->importe_pagado}}</span></td>

            <th>{{$historial->moneda}}</th>
            <td>{{$historial->tasa_cambio}}</td>
            <td><span class="item_21_sku">
              {!! isset($historial->metodo_pago->name ) ?$historial->metodo_pago->name  :'';  !!}
            </span></td>
            
            <td><span class="item_21_sku">{!! isset($historial->estatus->name ) ?$historial->estatus->name  :'';  !!}</span></td>
            <td><span class="item_21_sku">{{ $historial->created_at->format('d/m/Y')}}</span></td>
            <td>              <a href="{{ sc_route('customer.order_detail', ['id' =>  $historial->order_id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ sc_language_render('order.detail') }}</a><br>
            </td>
          </tr>

         

@endforeach
        </tbody>
      </table>

    </div>
      
    @endif
@endsection