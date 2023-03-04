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
        <table class="table table-sm ">
           <tr>
             <td class="td-title"><i class="fas fa-user p-1"></i>{{ sc_language_render('order.first_name') }}:</td><td>{!! $order->first_name !!}</td>
           </tr>

           @if (sc_config('customer_lastname'))
           <tr>
             <td class="td-title"><i class="fas fa-user p-1"></i>{{ sc_language_render('order.last_name') }}:</td><td>{!! $order->last_name !!}</td>
           </tr>
           @endif

           @if (sc_config('customer_phone'))
           <tr>
             <td class="td-title"><i class="fas fa-phone p-1"></i>{{ sc_language_render('order.phone') }}:</td><td>{!! $order->phone !!}</td>
           </tr>
           @endif

           <tr>
             <td class="td-title"><i class="fas fa-envelope p-1"></i>{{ sc_language_render('order.email') }}:</td><td>{!! empty($order->email)?'N/A':$order->email!!}</td>
           </tr>

           @if (sc_config('customer_company'))
           <tr>
             <td class="td-title"><i class="fas fa-user p-1"></i>{{ sc_language_render('order.company') }}:</td><td>{!! $order->company !!}</td>
           </tr>
           @endif

           @if (sc_config('customer_postcode'))
           <tr>
             <td class="td-title">{{ sc_language_render('order.postcode') }}:</td><td>{!! $order->postcode !!}</td>
           </tr>
           @endif

           <tr>
             <td class="td-title"><i class="fas fa-building p-1"></i>{{ sc_language_render('order.address1') }}:</td><td>{!! $order->address1 !!}</td>
           </tr>

           @if (sc_config('customer_address2'))
           <tr>
             <td class="td-title"><i class="fas fa-building p-1"></i>{{ sc_language_render('order.address2') }}:</td><td>{!! $order->address2 !!}</td>
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
    <table  class="table table-borderless">
        <tr><td class="td-title">{{ sc_language_render('order.order_status') }}:</td>
          <td class="badge badge-{{ $mapStyleStatus[$order->status]??'' }}">{{ $statusOrder[$order->status] }} - {{ $order->mensaje }}</td>
        </tr>

    </table>
  </div>
</div>

<div class="row">
        <div class="col-sm-12">
          <div class="">
          <div class="table-responsive">
            <table class="table    collapsed-box">
                <thead class="table-dark table-striped">
                  <tr>
                    <th>Producto</th>
                 
                    @if (empty($order->details[0]->modalidad_de_compra == 1))
                   
                    <th class="product_qty">{{ sc_language_render('product.quantity') }}</th>
                    <th class="product_price">Cuota</th>
                    <th class="product_price">Monto de la  Cuota</th>
                    <th class="product_total">Modalidad</th>
                        @else
                        <th class="product_price">{{ sc_language_render('product.price') }}</th>
                    <th class="product_qty">{{ sc_language_render('product.quantity') }}</th>
                    <th class="product_total">{{ sc_language_render('order.totals.sub_total') }}</th>
                    @endif
                   
                  </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $item)
                    @php
                     $cuotas = $item->nro_coutas;
                    if($item->abono_inicial > "0.00"){
                      $totalinicial=(number_format($item->abono_inicial)*$item->total_price)/100;
                      $monto = $item->total_price - $totalinicial;
                      $number1 =$monto;
                      if($item->nro_coutas>0)
                      $number1 =  $monto/$item->nro_coutas;
                    

                      $cuotas = number_format($number1,2 ,',', ' ') ;

                    }
                     
                    @endphp
                    

                          <tr>
                            <td >{{ $item->name }}
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
                            @if (empty($order->details[0]->modalidad_de_compra == 1))
                           
                            <td class="product_qty">x  {{ $item->qty }}</td>

                            <th>{{$item->nro_coutas}}</th>


                            <td class="product_price">{{ $cuotas }}$</td>
                            <td class="product_total item_id_{{ $item->id }}">
                              @if ($item->modalida_pago == 2)
                              Quincen
                                  @else
                                  Mensual
                              @endif
                            </td>
                                @else
                                <td class="product_price">{{ $item->price }}</td>
                            <td class="product_qty">x  {{ $item->qty }}</td>
                            <td class="product_total item_id_{{ $item->id }}">{{ sc_currency_render_symbol($item->total_price,$order->currency)}}</td>
                            @endif
                           
                          
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
          <div class="box collapsed-box table-responsive">
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

                @if(!$order->modalidad_de_compra==1)
                <tr class="data-balance"><td>{{ sc_language_render('order.totals.balance') }}:</td><td style="text-align:right">{{ sc_currency_format($order->balance) }}</td></tr>
                @endif
            </table>
          </div>

        </div>
      </div>


      @endif
      <div class="d-flex justify-content-end">
           @if($order->modalidad_de_compra==0)
        <div class=" align-self-end ">        <a  class="btn btn-info" href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
        </div>

        @endif

      </div>
      <table class="table  table-hover " >
        <thead class="table-dark table-striped">
          <tr>
            <th>No.</th>

            @if($order->modalidad_de_compra==1)
            <th>
              <span class="item_21_sku text-center">Monto de la Cuota</span>
            </th>
            @endif

            <th>Pagado</th>
            <th>Divisa</th>
            <th class="text-center">Forma de pago</th>
            <th class="text-center">estatus del pago</th>
             @if($order->modalidad_de_compra==0)
            <th>
              {{ sc_language_render('common.created_at') }}
            </th>
              @endif
            @if($order->modalidad_de_compra==1)
            <th class="text-center">Fecha de Pago</th>
            @endif
            <th>Accione</th>
            
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

         
        <td>
          <span class="item_21_sku">{{ $historial->importe_pagado}}</span>
        </td>
        
        <td>{{$historial->moneda ?? 'xx' }}</td>
        <td>
      
          <span class="item_21_sku">{!! isset($historial->metodo_pago->name) ? $historial->metodo_pago->name : 'x' !!}
          </span>
        </td>
        <td><span class="item_21_sku">{{ $historial->estatus->name }}</span></td>
            @if($order->modalidad_de_compra==1)
              <td colspan="1">
                {{$historial->fecha_venciento}}
              </td>
            @endif
        @if($order->modalidad_de_compra==0)
        <td>
          <span class="item_21_sku">
            {{$historial->fecha_venciento}}</span>
        </td>
          @endif
      

        @if($order->modalidad_de_compra==1 &&  $historial->payment_status != 2 && $historial->payment_status !=5)
        <td>   

          <button onclick="pagar({{$historial->order_id}})" value="{{$historial->id}}" id="pagar" type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal" >
            PAGAR
          </button>
          
        </td>



            @endif
            

         
      </tr>

      <!-- Button trigger modal -->

    
@endforeach

        </tbody>
      </table>

    </div>

    <div class="modal  " id="myModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered   " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Seleccione la forma de pago</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
           
          </div>

          @if($order->modalidad_de_compra==1)
                <div class="modal-body  d-flex justify-content-between">
                    <div class=" ">
                      <a onclick="bioPago()" id="bioPago"    class="btn btn-danger">
                        <span class="d-flex">
                          <img width="15px" class="img-fluid" src="/images/BiopagoBDV-logo.png" alt="Biopago">
                          Biopago BDV
                        </span>
                        
    
                      </a>
                    </div>
                 

                      <div class=" ">
                        <a onclick="transferencia()"  id="tranferencia"   class="btn btn-info">
                          <span class="d-flex">
                            <img width="20px" class="img-fluid" src="/images/tranfenrencia.png" alt="Biopago">
                            Transferencia
                          </span>
      
                        </a>
                      </div>

                      <div class=" ">
                        <a id="pagoMovil" onclick="pagoMovil()"  class="btn btn-warning">
                          <span class="d-flex">
                            <img width="20px" class="img-fluid" src="/images/pagomovil.png" alt="Biopago">
                            Pago movil
                          </span>
      
                        </a>
                      </div>
                 

            
            
           
                </div>
                @endif
                  
                  <div class="modal-footer mb-4">
                    <button  type="button" class="btn btn-danger"        data-dismiss="modal">
                      Cancelar
                    </button>
                    
                  </div>
          </div>
          
        </div><!-- /.modal-content -->
      </div>
    


    
@endsection


<script type="text/javascript">
 
   function  pagar(id){
    document.getElementById('tranferencia').value = id
    document.getElementById('pagoMovil').value = id
    document.getElementById('bioPago').value = id

    }


      function transferencia (){
          location.href=`{{ sc_route('customer.reportar_pago',['id' => $order->id ])}}?Transferencia=Tranferencia`
        }

        
      function pagoMovil (){
          
          location.href=`{{ sc_route('customer.reportar_pago',['id' => $order->id ])}}?Pago Movil=Pago Movil`
        }

        function bioPago (){
          location.href=`{!! sc_route("biopago", ['id' => $order->id ,'id_pago'])!!}=${number}" `
        }

    
</script>

