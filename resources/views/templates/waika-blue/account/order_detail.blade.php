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
<section class="mb-5">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
          <b class="title-store">{{ $title }}</b>
          <span>
            <b>{{ sc_language_render('order.order_status') }}:</b>
            <span class="badge text-bg-{{ $mapStyleStatus[$order->status]??'' }}">{{ $statusOrder[$order->status] }} - {{ $order->mensaje }}</span>
          </span>
        </div>
      </div>
      <div class="col-12">
        @if (!$order)
          <div class="text-danger text-center">
            {{ sc_language_render('front.data_notfound') }}
          </div>
        @else
          <div class="row" id="order-body"> 
            <div class="col-12 col-lg-6">
              <div class="table-responsive">
                  <table class="table table-bordered">
                    <tr>
                      <td class="td-title"><i class="fas fa-user p-1"></i><b>{{ sc_language_render('order.first_name') }}:</b></td><td>{!! $order->first_name !!}</td>
                    </tr>
    
                    @if (sc_config('customer_lastname'))
                    <tr>
                      <td class="td-title"><i class="fas fa-user p-1"></i><b>{{ sc_language_render('order.last_name') }}:</b></td><td>{!! $order->last_name !!}</td>
                    </tr>
                    @endif
    
                    @if (sc_config('customer_phone'))
                    <tr>
                      <td class="td-title"><i class="fas fa-phone p-1"></i><b>{{ sc_language_render('order.phone') }}:</b></td><td>{!! $order->phone !!}</td>
                    </tr>
                    @endif
    
                    <tr>
                      <td class="td-title"><i class="fas fa-envelope p-1"></i><b>{{ sc_language_render('order.email') }}:</b></td><td>{!! empty($order->email)?'N/A':$order->email!!}</td>
                    </tr>
    
                    @if (sc_config('customer_company'))
                    <tr>
                      <td class="td-title"><i class="fas fa-user p-1"></i><b>{{ sc_language_render('order.company') }}:</b></td><td>{!! $order->company !!}</td>
                    </tr>
                    @endif
    
                    @if (sc_config('customer_postcode'))
                    <tr>
                      <td class="td-title"><b>{{ sc_language_render('order.postcode') }}:</b></td><td>{!! $order->postcode !!}</td>
                    </tr>
                    @endif
    
                    <tr>
                      <td class="td-title"><i class="fas fa-building p-1"></i><b>{{ sc_language_render('order.address1') }}:</b></td><td>{!! $order->address1 !!}</td>
                    </tr>
    
                    @if (sc_config('customer_address2'))
                    <tr>
                      <td class="td-title"><i class="fas fa-building p-1"></i><b>{{ sc_language_render('order.address2') }}:</b></td><td>{!! $order->address2 !!}</td>
                    </tr>
                    @endif
    
                    @if (sc_config('customer_address3'))
                    <tr>
                      <td class="td-title"><b>{{ sc_language_render('order.address3') }}:</b></td><td>{!! $order->address3 !!}</td>
                    </tr>
                    @endif
    
                    @if (sc_config('customer_country'))
                    <tr>
                      <td class="td-title"><b>{{ sc_language_render('order.country') }}:</b></td><td>{!! $countries[$order->country] ?? $order->country !!}</td>
                    </tr>
                    @endif
                  </table>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              {{--  --}}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="">
                    <tr>
                      <th>Articulo</th>
                      @if (empty($order->details[0]->modalidad_de_compra >= 1))
                        <th class="product_qty">{{ sc_language_render('product.quantity') }}</th>
                        <th class="product_price">Cuota</th>
                        <th class="product_price"> $Cuota</th>
                        <th>Cuota especial</th>
                        <th class="product_total">Frecuencia</th>
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

                        $precio_couta = 0;
                        if ($item->abono_inicial > 0 && $item->nro_coutas > 0){

                          $totalInicial = ($item->abono_inicial * $item->total_price)/100;
                          $totalPrecio = $item->total_price - $totalInicial;
                          $precio_couta = number_format( $totalPrecio / $item->nro_coutas,2);
                        }else{

                          $precio_couta =  number_format($item->total_price / $item->nro_coutas, 2);
                                      

                        }


                          if($cuotas_inmediatas > 0 && $monto_inicial > 0 && $item->nro_coutas == 1){

                              $precio_couta = number_format(($item->total_price - $monto_inicial)/$cuotas_inmediatas,2);
                              
                       }
                        @endphp
                          <tr>
                            <td>
                              {{ $item->name }}
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
                              @if (empty($order->details[0]->modalidad_de_compra >= 1))
                                <td class="product_qty"> {{ $item->qty }}</td>
                                <td>{!!$item->nro_coutas > 1 || $item->nro_coutas == 0?$item->nro_coutas:$cuotas_inmediatas!!}</th>
                                <td class="product_price">{{ $precio_couta ?? '0' }}$</td>
                                <th> {{  $item->monto_cuota_entrega}}</th>
                                <td class="product_total item_id_{{ $item->id }}">
                                  @if ($item->id_modalidad_pago == 2)
                                    Quincenal
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

          @php
              $dataTotal = \SCart\Core\Front\Models\ShopOrderTotal::getTotal($order->id)
          @endphp

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered">
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

                  @if(!$order->modalidad_de_compra>=1)
                    <tr class="data-balance"><td>{{ sc_language_render('order.totals.balance') }}:</td><td style="text-align:right">{{ sc_currency_format($order->balance) }}</td></tr>
                  @endif
                </table>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-end">
                @if($order->modalidad_de_compra==0)
                  <div class="align-self-end ">
                    <a  class="btn btn-info" href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
                  </div>
                @endif
              </div>
              <h3 class="text-center">Pagos pendientes</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="">
                    <tr>
                      <th>No.</th>
                      <th>Monto</th>
                           <th>Divisa</th>
                      <th class="text-center">Vence</th>
                      <th class="text-center">estatus del pago</th>
                      @if($order->modalidad_de_compra==0)
                      <th>
                        {{ sc_language_render('common.created_at') }}
                      </th>
                       @endif
                      @if($order->modalidad_de_compra>=1)
                      <th class="text-center">Tasa de cambio</th>
                      @endif
                      <th>Acciones</th>
                      
                    </tr>
                  </thead>
            
                  @php
                    $monedaBs ='';
foreach (sc_currency_all()  as $moneda) {
    if ($moneda->code === "Bs") {
        $monedaBs = $moneda;
        break;
    }
}
                  @endphp
                  <tbody>
                    @foreach($historial_pagos as $historial)
                      <tr>
                          @php
                          $n = (isset($n)?$n:0);
                          $n++;
                            if($order->modalidad_de_compra==0)
                              $n=$historial->nro_coutas;
                          @endphp
                        <td>
                          <span class="item_21_id">
                            {{ $n }}
                          </span>
                        </td>
                        <td>
                          <span class="badge text-bg-{{ $mapStyleStatus[$historial->payment_status]??'' }} item_21_sku z">${{ $historial->importe_couta}}</span>
                        </td>
                     
                        <td>{{'USD' }}</td>
                        <td>
                          <span class="item_21_sku">{!! $historial->fecha_vencimiento !!}
                          </span>
                        </td> 
                        <td>
                          <span class="item_21_sku badge text-bg-{{ $mapStyleStatus[$historial->payment_status]??'' }}">
                              {{ $historial->estatus->name }}
                          </span>
                        </td>
                        @if($order->modalidad_de_compra>=1)
                          <td colspan="1">
                           {!!   $monedaBs->exchange_rate !!} Bs
                          </td>
                        @endif
                        
                        @if($order->modalidad_de_compra>=1 &&  $historial->payment_status != 2  && $historial->payment_status !=5)
                          <td>   
                            <button onclick="pagar('{{$historial->order_id,$historial->id}}')" value="{{$historial->id}}" id="pagar" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" >
                              PAGAR
                            </button>
                          </td>
                        @endif
                      </tr>
                      <!-- Button trigger modal -->
                      <div class="modal" id="myModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5>Seleccione la forma de pago</h5>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                  
                            @if($order->modalidad_de_compra>=1)
                              <div class="modal-body m-auto ">


                                  <div class="row mb-5">
                                    <div class="col-md-12">
                                
                                        <button type="button"  href="{{ route('biopago',['id' => $order->id ,'id_pago'=>$historial->id])}}"  id="bioPago" class="btn btn-danger btn-block">
                                          <span class="d-flex">
                                            <img width="15px" class="img-fluid" src="/images/BiopagoBDV-logo.png" alt="Biopago">
                                            Biopago BDV
                                          </span>
                                        </button>
                              
                           
                                    </div>
                                  </div>
                                  <div class="row  mb-5">
                                    <div class="col-12">
                                      <div class="puntoDeventa">
                                        <button class="btn btn-danger btn-block" id="py-client" onclick="puntoYabioPago('{{$historial->importe_couta}}')">
                                          <span class="d-flex">
                                            <img width="15px" class="img-fluid" src="/images/BiopagoBDV-logo.png" alt="Biopago">
                                            PuntoYaBDV
                                          </span>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-5">
                                    <div class="col-12">
                                      <div class="btn__transferencia">
                                        <button type="button" onclick="transferencia({{$historial->id}})" id="tranferencia" class="btn btn-info btn-block">
                                          <span class="d-flex">
                                            <img width="20px" class="img-fluid" src="/images/tranfenrencia.png" alt="Biopago">
                                            Transferencia
                                          </span>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                              
                                  <div class="row mb-5 ">
                                    <div class="col-12">
                                      <div class="btn__pagomovil">
                                        <button type="button" id="pagoMovil" onclick="pagoMovil({{$historial->id}})"  class="btn btn-warning btn-block">
                                          <span class="d-flex">
                                            <img width="20px" class="img-fluid" src="/images/pagomovil.png" alt="Biopago">
                                            Pago movil
                                          </span>
                      
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                               

                                
                              
                                                       
                                
                                  
                           
                                 
                              </div>
                            @endif  
                              <div class="modal-footer mb-4">
                                <button  type="button" class="btn btn-ligh " data-dismiss="modal" id="cerrarmodal">
                                  Cancelar
                                </button>
                              </div>
                          </div>
                        </div><!-- /.modal-content -->
                      </div>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
      </div> <!-- .col -->
    </div> <!-- .row -->
  </div> <!-- .container -->

</section>
    
@endsection


@push('scripts')
<script src="https://puntoyapos.com.ve/pos/assets/scripts/py-script.js"></script>
<script type="text/javascript">
    const callback = (responseData) => {
      console.log(responseData)
      Swal.fire({
          title: responseData.responseMessage,
          html:
            '<b>Monto:</b> ' + responseData.amount + '<br>' +
            '<b>ID de transacción:</b> ' + responseData.transactionId + '<br>' +
            '<b>Referencia:</b> ' + responseData.reference + '<br>' +
            '<b>Fecha de pago:</b> ' + responseData.paymentDate,
          icon: 'success'
        });
      // Los valores de la respuesta son: 
      // ok: boolean, (true en caso de ser exitosa, false en caso de ser fallida)
      // description: string, (descripción de la transacción)
      // transactionId: string, (referencia bancaria de la transacción)
      // Ejemplo: { ok: true, description: 'Pago exitoso', transactionId: '1858749961512' }
    };
  function puntoYabioPago(monto){
    $("#cerrarmodal").click()
    console.log(monto)
    var tasa_cambio = '{{$monedaBs->exchange_rate }}';
    console.log()
    monto= parseFloat(tasa_cambio)*parseFloat(monto);
    console.log(monto)
    payWithPuntoYa(monto, callback);
 
  }
        function transferencia (id){
           number = id
            location.href=`{{ sc_route('customer.reportar_pago',['id' => $order->id ,'id_pago'])}}=${id}&Transferencia=Transferencia`
        }

        function pagoMovil (id){
          location.href=`{{ sc_route('customer.reportar_pago',['id' => $order->id ,'id_pago'])}}=${id}&Pago Movil=Pago Movil`
        }

        function bioPago (id){
          location.href="{{ route('biopago',['id' => $order->id ,'id'=>"+id+"])}}" 
        }
</script>

@endpush