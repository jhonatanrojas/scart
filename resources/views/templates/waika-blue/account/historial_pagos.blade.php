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
      <table class="table table-hover box-body text-wrap " width="100%">
        <thead class="text-center">
          <tr>
           
            <th >Convenio</th>
            <th >Solicitud</th>
            <th >Articulo</th>
            <th>Pagado</th>
            <th style="width: 90px">Divisa</th>
            <th style="width: 100px ; text-align: center; margin: auto">Referencia$</th>
            <th>Tasa</th>
            <th>Pago</th>
            <th>Estatus</th>
            <th>Fecha de reporte</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($historial_pagos as $historial)
            <tr>
              
            <td><span class="item_21_sku">{{$historial->nro_convenio}}</span></td>
            <td>
              <span class="item_21_sku"> {!!substr($historial->order_id, 0, -5)!!}</span>
            </td>

           

            <td>
              <span class="item_21_sku">{{ $historial->nombre_product }}</span>
            </td>


            <td><span class="text-dark">
              {{ $historial->importe_pagado}}
            </span></td>
            <td>{{$historial->moneda}}</td>
            <td class="text-dark">
              @php
                $monedas = $historial->importe_pagado;
                  if($historial->moneda == 'Bs'){
                    $monedas =  number_format((float)$historial->importe_pagado / $historial->tasa_cambio, 2, '.', ''); ;

                  }
              @endphp

              {{$monedas}}
             
            </td>
            <td>{{$historial->tasa_cambio}}</td>
            <td><span class="item_21_sku ">
              {!! isset($historial->metodo_pago->name ) ?$historial->metodo_pago->name  :'';  !!}
            </span></td>


            @php

            $statusstyle= '';
            if($historial->payment_status === 5 ){
              $statusstyle = 'success';

            }else if($historial->payment_status === 2 ){
              $statusstyle = 'primary';

            }else if($historial->payment_status === 4 ){
              $statusstyle = 'warning';

            }else if($historial->payment_status === 8 ){
              $statusstyle = 'danger';

            }
                
            @endphp

            
         
            <td><span class="item_21_sku  text-{{ $statusstyle }}">{!! isset($historial->estatus->name ) ?$historial->estatus->name  :'';  !!}</span></td>
            <td><span class="item_21_sku">{{ $historial->fecha_pago}}</span></td>
            <td>              <a href="{{ sc_route('customer.order_detail', ['id' =>  $historial->order_id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ sc_language_render('order.detail') }}</a><br>
            </td>
          </tr>

         

@endforeach
        </tbody>
      </table>

    </div>
      
    @endif
@endsection