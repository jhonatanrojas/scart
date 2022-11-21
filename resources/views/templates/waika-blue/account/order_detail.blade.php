@php
/*
$layout_page = shop_profile
** Variables:**
- $statusOrder
- $statusShipping
- $order
- $countries
- $attributesGroup
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
      <h6 class="title-store">{{ $title }}</h6>
      @if (!$order)
      <div class="text-danger">
        {{ sc_language_render('front.data_notfound') }}
      </div>
      @else
      <div class="row" id="order-body">

       
      <div class="col-sm-6">
        <table class="table table-bordered">
           <tr>
             <td class="td-title">{{ sc_language_render('order.first_name') }}:</td><td>{!! $order->first_name !!}</td>
           </tr>

           @if (sc_config('customer_lastname'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.last_name') }}:</td><td>{!! $order->last_name !!}</td>
           </tr>
           @endif

           @if (sc_config('customer_phone'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.phone') }}:</td><td>{!! $order->phone !!}</td>
           </tr>
           @endif

           <tr>
             <td class="td-title">{{ sc_language_render('order.email') }}:</td><td>{!! empty($order->email)?'N/A':$order->email!!}</td>
           </tr>

           @if (sc_config('customer_company'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.company') }}:</td><td>{!! $order->company !!}</td>
           </tr>
           @endif

           @if (sc_config('customer_postcode'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.postcode') }}:</td><td>{!! $order->postcode !!}</td>
           </tr>
           @endif

           <tr>
             <td class="td-title">{{ sc_language_render('order.address1') }}:</td><td>{!! $order->address1 !!}</td>
           </tr>

           @if (sc_config('customer_address2'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.address2') }}:</td><td>{!! $order->address2 !!}</td>
           </tr>
           @endif

           @if (sc_config('customer_address3'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.address3') }}:</td><td>{!! $order->address3 !!}</td>
           </tr>
           @endif

           @if (sc_config('customer_country'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.country') }}:</td><td>{!! $countries[$order->country] ?? $order->country !!}</td>
           </tr>
           @endif

       </table>
   </div>


   <div class="col-sm-6">
    <table  class="table table-bordered">
        <tr><td class="td-title">{{ sc_language_render('order.order_status') }}:</td><td>{{ $statusOrder[$order->status] }}</td></tr>

    </table>
  </div>
</div>

<div class="row">
        <div class="col-sm-12">
          <div class="box collapsed-box">
          <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Producto</th>

                    <th class="product_price">{{ sc_language_render('product.price') }}</th>
                    <th class="product_qty">{{ sc_language_render('product.quantity') }}</th>
                    <th class="product_total">{{ sc_language_render('order.totals.sub_total') }}</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $item)
                          <tr>
                            <td>{{ $item->name }}
                              @php
                              $html = '';
                                if($item->attribute && is_array(json_decode($item->attribute,true))){
                                  $array = json_decode($item->attribute,true);
                                      foreach ($array as $key => $element){
                                        $html .= '<br><b>'.$attributesGroup[$key].'</b> : <i>'.$element.'</i>';
                                      }
                                }
                              @endphp
                            {!! $html !!}
                            </td>
                  
                            <td class="product_price">{{ $item->price }}</td>
                            <td class="product_qty">x  {{ $item->qty }}</td>
                            <td class="product_total item_id_{{ $item->id }}">{{ sc_currency_render_symbol($item->total_price,$order->currency)}}</td>
                          
                          </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
        </div>

      </div>

      @php
          $dataTotal = \SCart\Core\Front\Models\ShopOrderTotal::getTotal($order->id)
      @endphp
      <div class="row">
        <div class="col-md-12">
          <div class="box collapsed-box">
              <table   class="table table-bordered">
                @foreach ($dataTotal as $element)
                  @if ($element['code'] =='subtotal')
                    <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif
                  @if ($element['code'] =='tax')
                  <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif

                  @if ($element['code'] =='shipping')
                    <tr><td>{!! $element['title'] !!}:</td><td style="text-align:right">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif
                
                   @if ($element['code'] =='total')
                    <tr style="background:#f5f3f3;font-weight: bold;"><td>{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif

                  @if ($element['code'] =='received')
                    <tr><td>{!! $element['title'] !!}(-):</td><td style="text-align:right">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif

                @endforeach
                <tr class="data-balance"><td>{{ sc_language_render('order.totals.balance') }}:</td><td style="text-align:right">{{ sc_currency_format($order->balance) }}</td></tr>
            </table>
          </div>

        </div>
      </div>


      @endif
      <div class="d-flex justify-content-end">
           @if($order->modalidad_de_compra==0)
        <div class=" align-self-end ">        <a  class="btn btn-info" href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
        </div>

        @endif;

      </div>
      <table class="table box table-bordered" width="100%">
        <thead>
          <tr>
            <th style="width: 50px;">No.</th>
                @if($order->modalidad_de_compra==1)
            <th><span class="item_21_sku"> Cuota</span></th>
            @endif
            <th>Pagado</th>
            <th>Forma de pago</th>
            <th>estatus del pago</th>
             @if($order->modalidad_de_compra==0)
            <th>{{ sc_language_render('common.created_at') }}</th>
                @endif
                  @if($order->modalidad_de_compra==1)
            <th>Fecha de vencimiento</th>
                @endif
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($historial_pagos as $historial)
          <tr>
          @php
          $n = (isset($n)?$n:0);
          $n++;
            if($order->modalidad_de_compra==0)
              $n=$historial->nro_coutas;
          @endphp
        <td><span class="item_21_id">{{ $n }}</span></td>
            @if($order->modalidad_de_compra==1)
        <td><span class="item_21_sku">{{ $historial->importe_couta}}</span></td>
            @endif
        <td><span class="item_21_sku">{{ $historial->importe_pagado}}</span></td>
        <td><span class="item_21_sku">{!! isset($historial->metodo_pago->name) ? $historial->metodo_pago->name : '' !!}</span></td>
        <td><span class="item_21_sku">{{ $historial->estatus->name }}</span></td>
                     @if($order->modalidad_de_compra==1)
            <td>{{ $historial->fecha_venciento}}</td>
                @endif
              @if($order->modalidad_de_compra==0)
        <td><span class="item_21_sku">{{ $historial->created_at->format('d/m/Y')}}</span></td>
                  @endif
        <td>      
  @if($order->modalidad_de_compra==1 &&  $historial->payment_status != 2 && $historial->payment_status !=5)
              <a href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ,'id_pago'=>$historial->id]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
      @endif
        </td>
      </tr>

@endforeach

        </tbody>
      </table>

    </div>
@endsection