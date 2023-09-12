@php
use SCart\Core\Front\Models\ShopOrderDetail;
use App\Models\HistorialPago;
/*
$layout_page = shop_profile
** Variables:**
- $statusOrder
- $orders
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')

@if(count($order) ==0)
<div class="text-danger">
  {{sc_language_render('front.data_notfound') }}
</div>
@else
<div class="panel-heading animate__animated animate__backInRight">
  <h5 class="panel-title">{{ $title }}</h5>

</div>
<div class="accordion accordion-flush" id="accordionFlushExample">

  @foreach($order as $pedido)

  @php 
           $itemDetail = (new ShopOrderDetail)->where('order_id', $pedido->id)->first();
     
           $historial_pagos =  HistorialPago::where('sc_historial_pagos.order_id', $pedido->id)->whereIn('sc_historial_pagos.payment_status',   [ 2, 3, 4, 5, 6])->orderByDesc('id','DESC')
          ->join('sc_shop_order', 'sc_historial_pagos.order_id', '=', 'sc_shop_order.id')
        ->join('sc_convenios', 'sc_historial_pagos.order_id', '=', 'sc_convenios.order_id')
        ->join('sc_metodos_pagos', 'sc_metodos_pagos.id', '=', 'sc_historial_pagos.metodo_pago_id')
        ->select('sc_historial_pagos.*', 'sc_shop_order.first_name', 'sc_shop_order.last_name', 'sc_convenios.lote',
         'sc_shop_order.last_name' , 'sc_metodos_pagos.name as metodoPago' , 'sc_shop_order.cedula' , 'sc_shop_order.vendedor_id')
         ->distinct()
         ->get();


  @endphp

  <div class="accordion-item">
    <h2 class="accordion-header" id="{{$pedido->id}}">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{$pedido->id}}" aria-expanded="false" aria-controls="flush-collapseOne">
        Convenio #{{ $pedido->nro_convenio}}- {{ $itemDetail->name ??''  }}
      </button>
    </h2>
  @foreach ( $historial_pagos as $pago)
    

    <div id="flush-{{$pedido->id}}" class="accordion-collapse collapse" aria-labelledby="{{$pedido->id}}" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">

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
                  <span class="item_21_sku">{{ $itemDetail->name }}</span>
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
      </div>
    </div>
    @endforeach
  </div>
 
 @endforeach
</div>

      
    @endif
@endsection