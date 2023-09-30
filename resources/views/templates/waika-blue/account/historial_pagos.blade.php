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



    <div id="flush-{{$pedido->id}}" class="accordion-collapse collapse" aria-labelledby="{{$pedido->id}}" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">

        @php
    echo reportePagosH($pedido->id,true);
      @endphp

      </div>
    </div>

  </div>
 
 @endforeach
</div>

      
    @endif
@endsection