@extends($templatePathAdmin.'layout')

@section('main')
 <div class="row">
    <div class="col-md-12"> 
       <div class="card">

          <div class="card-header with-border">
              <h3 class="card-title">{{ sc_language_render('order.order_detail') }} #{{ $order->id }}</h3>
              <div class="card-tools not-print">
                  <div class="btn-group float-right" style="margin-right: 0px">
                      <a href="{{ sc_route_admin('admin_order.index') }}" class="btn btn-flat btn-default"><i class="fa fa-list"></i>&nbsp;{{ sc_language_render('admin.back_list') }}</a>
                  </div>
                  
                  <div class="btn-group float-right" style="margin-right: 10px;border:1px solid #c5b5b5;">
                      <a class="btn btn-flat" target=_new title="Invoice" href="{{ sc_route_admin('admin_order.invoice', ['order_id' => $order->id]) }}"><i class="far fa-file-pdf"></i><span class="hidden-xs"> {{ sc_language_render('order.invoice') }}</span></a>
                  </div>
                  
                 
               
           @if(count($order->details)>0 && $order->status==3 && empty($convenio))
                  <div class="btn-group float-right" style="margin-right: 10px;border:1px solid #c5b5b5;">
                    <a class="btn btn-flat" onclick="abrir_modal()" href="#" title=""><i class="far fa-file"></i> Generar Convenio<span class="hidden-xs"> 
                     
                    
                    </span></a>
                </div>
                @else
                <div class="btn-group float-right" style="margin-right: 10px;border:1px solid #c5b5b5;">
                  <a class="btn btn-flat" target=_new title="Invoice" href="{{ route('downloadPdf', ['id' => $order->id]) }}"><i class="far fa-file-pdf"></i><span class="hidden-xs">descargar convenio</span></a>
              </div>
                  @endif

              </div>
          </div>
    

          <div class="row" id="order-body">
            <div class="col-sm-6">
                 <table class="table table-hover box-body text-wrap table-bordered">
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.first_name') }}:</td><td><a href="#" class="updateInfoRequired" data-name="first_name" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.first_name') }}" >{!! $order->first_name !!}</a></td>
                    </tr>

                    @if (sc_config_admin('customer_lastname'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.last_name') }}:</td><td><a href="#" class="updateInfoRequired" data-name="last_name" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.last_name') }}" >{!! $order->last_name !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_phone'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.phone') }}:</td><td><a href="#" class="updateInfoRequired" data-name="phone" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.phone') }}" >{!! $order->phone !!}</a></td>
                    </tr>
                    @endif

                    <tr>
                      <td class="td-title">{{ sc_language_render('order.email') }}:</td><td>{!! empty($order->email)?'N/A':$order->email!!}</td>
                    </tr>

                    @if (sc_config_admin('customer_company'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.company') }}:</td><td><a href="#" class="updateInfoRequired" data-name="company" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.company') }}" >{!! $order->company !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_postcode'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.postcode') }}:</td><td><a href="#" class="updateInfoRequired" data-name="postcode" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.postcode') }}" >{!! $order->postcode !!}</a></td>
                    </tr>
                    @endif

                    <tr>
                      <td class="td-title">{{ sc_language_render('order.address1') }}:</td><td><a href="#" class="updateInfoRequired" data-name="address1" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.address1') }}" >{!! $order->address1 !!}</a></td>
                    </tr>

                    @if (sc_config_admin('customer_address2'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.address2') }}:</td><td><a href="#" class="updateInfoRequired" data-name="address2" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.address2') }}" >{!! $order->address2 !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_address3'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.address3') }}:</td><td><a href="#" class="updateInfoRequired" data-name="address3" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.address3') }}" >{!! $order->address3 !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_country'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.country') }}:</td><td><a href="#" class="updateInfoRequired" data-name="country" data-type="select" data-source ="{{ json_encode($country) }}" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.country') }}" data-value="{!! $order->country !!}"></a></td>
                    </tr>
                    @endif

                    <tr>
                      <td class="td-title">Ver documentos:</td>
                      <td>
                        @if (empty($documento))
                        El cliente no ha adjuntado Documentos <br>
                        @endif
                        <a href="{{ sc_route_admin('admin_customer.document', ['id' => $order->customer_id ? $order->customer_id : 'not-found-id']) }}" class="" data-name="address2" >Ir a Documentos</a>
                      </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table  class="table table-bordered">
                    <tr><td  class="td-title">{{ sc_language_render('order.order_status') }}:</td><td>
                      <a href="#" class="updateStatus" data-name="status" data-type="select" data-source ="{{ json_encode($statusOrder) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.order_status') }}">{{ $statusOrder[$order->status] ?? $order->status }}</a>
                    </td></tr>
                    

                    <tr>
                      <td> Modalidad de compra</td>
                      <td>
                        {{ ($order->modalidad_de_compra) ? 'Financiamiento' :'Al contado'; }}
                      </td>
                    </tr>
                    <tr>
                      <td> Convenio</td>
                      <td>
                        {{ ($convenio) ? str_pad($convenio->nro_convenio,6,"0",STR_PAD_LEFT)  :'No se ha parametrizado el convenio'}}
                      </td>
                    </tr>

                    
                    @if ($order->modalidad_de_compra==0)
                    <tr><td>{{ sc_language_render('order.shipping_status') }}:</td><td>
                      
                      <a href="#" class="updateStatus" data-name="shipping_status" data-type="select" data-source ="{{ json_encode($statusShipping) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->shipping_status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.shipping_status') }}">{{ $statusShipping[$order->shipping_status]??$order->shipping_status }}</a>
                    
                    </td></tr>
                    <tr><td>{{ sc_language_render('order.payment_status') }}:</td><td><a href="#" class="updateStatus" data-name="payment_status" data-type="select" data-source ="{{ json_encode($statusPayment) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->payment_status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.payment_status') }}">{{ $statusPayment[$order->payment_status]??$order->payment_status }}</a></td></tr>
                    <tr><td>{{ sc_language_render('order.shipping_method') }}:</td><td><a href="#" class="updateStatus" data-name="shipping_method" data-type="select" data-source ="{{ json_encode($shippingMethod) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->shipping_method !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.shipping_method') }}">{{ $order->shipping_method }}</a></td></tr>
                    <tr><td>{{ sc_language_render('order.payment_method') }}:</td><td><a href="#" class="updateStatus" data-name="payment_method" data-type="select" data-source ="{{ json_encode($paymentMethod) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->payment_method !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.payment_method') }}">{{ $order->payment_method }}</a></td></tr>
                    @endif
                    <tr><td></i> {{ sc_language_render('admin.created_at') }}:</td><td>{{ $order->created_at }}</td></tr>
                  </table>
                 <table class="table table-hover box-body text-wrap table-bordered">
                    <tr>
                      <td class="td-title"><i class="far fa-money-bill-alt nav-icon"></i> {{ sc_language_render('order.currency') }}:</td><td>{{ $order->currency }}</td>
                    </tr>
                    <tr>
                      <td class="td-title"><i class="fas fa-chart-line"></i> {{ sc_language_render('order.exchange_rate') }}:</td>
                      <td>
                        <a href="#" class="updateStatus" data-value="{{($order->exchange_rate)??1  }}" data-name="exchange_rate" data-type="text" min=0 data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="tipo de cambio">{{ $order->exchange_rate }}</a>

          
                      
                      </td>
                    </tr>
                </table>
            </div>

          </div>

@php
    if($order->balance == 0){
        $style = 'style="color:#0e9e33;font-weight:bold;"';
    }else
        if($order->balance < 0){
        $style = 'style="color:#ff2f00;font-weight:bold;"';
    }else{
        $style = 'style="font-weight:bold;"';
    }
@endphp

    <form id="form-add-item" action="" method="">
      @csrf
      <input type="hidden" name="order_id"  value="{{ $order->id }}">
      <div class="row">
        <div class="col-sm-12">
     
          <div class="card collapsed-card">
          <div class="table-responsive">
            <table class="table table-hover box-body text-wrap table-bordered">
                <thead>
                  <tr>
                    <th>{{ sc_language_render('product.name') }}</th>
                    <th>Cuotas</th>
                    <th>Modalidad</th>
                    <th class="product_qty">Inicial</th>
                    <th class="product_qty">Cant</th>
                    <th class="product_price">{{ sc_language_render('product.price') }}</th>

                    <th class="product_tax">{{ sc_language_render('product.tax') }}</th>
                    <th class="product_total">Total</th>

                    <th>{{ sc_language_render('action.title') }}</th>
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
                                        $html .= '<br><b>'.$attributesGroup[$key].'</b> : <i>'.sc_render_option_price($element, $order->currency, $order->exchange_rate).'</i>';
                                      }
                                }
                              @endphp
                            {!! $html !!}
                            </td>
                            <td>
                              <a href="#" class="edit-item-detail" data-value="{{  $item->nro_coutas }}" data-name="nro_coutas" data-type="text" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" 
                                data-title="Cuotas">{{  $item->nro_coutas }}</a>
                              
                             </td>
                        

                             <td>
                              <a href="#" class="updateStatus" data-name="id_modalidad_pago" data-type="select"
                               data-source ="{{ json_encode($modalidad_pago) }}"  
                               data-pk="{{ $item->id }}" data-value="{!! $modalidad_pago[$item->id_modalidad_pago] ?? 'No aplica'  !!}"
                                 data-url="{{ route("admin_order.edit_item") }}" 
                                 data-title="Modalidad de pago">{{ $modalidad_pago[$item->id_modalidad_pago] ?? 'No aplica' }}</a>

                             </td>
                             <td>
                              <a href="#" class="updateStatus" data-name="abono_inicial" data-type="select"
                               data-source ='{"0":"Sin inicial","30":"Con inicial 30%"}'  
                               data-pk="{{ $item->id }}"
                                data-value=" @if  ($item->abono_inicial>0 )
                                
                                Con Inicial 30%
                                @else
                                Sin inicial   
                                
                                @endif"
                                 data-url="{{ route("admin_order.edit_item") }}" 
                                 data-title="Inicial"> @if  ($item->abono_inicial>0 )
                                
                                 Con Inicial 30%
                                 @else
                                 Sin inicial    
                                 
                                 @endif"</a>

                             </td>
                             <td class="product_qty">x <a href="#" class="edit-item-detail" data-value="{{ $item->qty }}" data-name="qty" data-type="number" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ sc_language_render('order.qty') }}"> {{ $item->qty }}</a></td>

                            <td class="product_price">
                              <a href="#" class="edit-item-detail" data-value="{{ $item->price }}" data-name="price" data-type="text" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ sc_language_render('product.price') }}">{{ $item->price }}</a>
                            
                            </td>
                            <td class="product_tax"><a href="#" class="edit-item-detail" data-value="{{ $item->tax }}" data-name="tax" data-type="text" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ sc_language_render('order.tax') }}"> {{ $item->tax }}</a></td>

                            <td class="product_total item_id_{{ $item->id }}">{{ sc_currency_render_symbol($item->total_price,$order->currency)}}</td>
                            <td>
                                <span  onclick="deleteItem('{{ $item->id }}');" class="btn btn-danger btn-xs" data-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></span>
                            </td>
                          </tr>
                    @endforeach

                    <tr  id="add-item" class="not-print">
                      <td colspan="7">
                        <button  type="button" class="btn btn-flat btn-success" id="add-item-button"  title="{{sc_language_render('action.add') }}"><i class="fa fa-plus"></i> {{ sc_language_render('action.add') }}</button>
                        &nbsp;&nbsp;&nbsp;<button style="display: none; margin-right: 50px" type="button" class="btn btn-flat btn-warning" id="add-item-button-save"  title="Save"><i class="fa fa-save"></i> {{ sc_language_render('action.save') }}</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
        </div>

      </div>
</form>

<div class="modal fade mt-3" id="modal_convenio" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
       
      </div>
      <div class="modal-body">
        <form action="{{ sc_route('crear_convenio') }}" method="POST">
          <div id="w-100">
             {{ csrf_field() }}
            <div class="header">
              <h5 class="text-center">{!! count($order->details) ? $order->details[0]->name : 0 !!} </h5>
            </div>
            <div name="frmPrestamo" id="frmPrestamo">
          <input type="hidden" name="c_producto" value="{!! count($order->details) ? $order->details[0]->name : 0 !!} ">
          <input type="hidden" name="c_order_id" value="{!! $order->id !!} ">

          <div class="form-group">
                <label for="monto">Monto: </label>
                <input  readonly value="{!! count($order->details) ? $order->details[0]->price : 0 !!}" class="form-control   " type="text" name="_monto" id="c_monto" placeholder="monto">
              </div>

              <div class="row">

                <div class="form-group col-md-6">
                  <label for="monto">Cuotas: </label>
                  <input  readonly value="{!! count($order->details) ? $order->details[0]->nro_coutas : 0 !!}" class="form-control   " type="text" name="c_nro_coutas" id="c_nro_coutas" placeholder="_nro_cuotas">
                </div>
                <div class="form-group col-md-6">
                  <label for="monto">Modalidad: </label>
                  <input  readonly value="0" class="form-control   " type="text" name="c_modalidad" id="c_modalidad" placeholder="_nro_cuotas">
                </div>
              </div>

              <div class="row">
              <div class="form-group col-md-6">
                <label for="monto">Fecha de primer pago: </label>
                <input   value="{!! count($order->details) ? $order->details[0]->nro_coutas : 0 !!}" class="form-control   " type="date" name="c_fecha_inicial" id="c_fecha_inicial" placeholder="_nro_cuotas">
              </div>
              <div class="form-group col-md-6">
                <label for="monto">Inicial: </label>
                <input  readonly value="0" class="form-control   " type="text" name="c_inicial" id="c_inicial" placeholder="_nro_cuotas">
              </div>
              <div class="form-group col-md-6">
                <label for="nro_convenio">numero de convenio: </label>
                <input class="form-control   " type="text" name="nro_convenio" id="nro_convenio" placeholder="numero de convenio ">
              </div>
            </div>
         
           
         


             
           
          
              <button type="button"  class=" btn btn-info" id="simular" onclick="gen_table(true)"> CALCULAR</button>
            </div>
          </div>
       
        
        <table class="table table-striped ">
          
          <tbody id="tab">
            <thead class="thead-dark">
              <tr>
                <td>NRO</td>
            
                <td id="cuotass">CUOTAS $</td>
                <td>DEUDA $</td>
                <td>FECHA DE PAGO</td>
            </tr>
              
          </thead>
          </tbody>
     
      </table>
              </div>
              <div class="modal-footer">
                <button  type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="butto_modal" disabled="true" type="submit" class="btn btn-primary">Crear Convenio</button>
              </div>
         
      </div>
      
    </div><!-- /.modal-content -->
  </div>
 
        <input  name="qty" type="hidden"  value="1" min="1" max="100">
        <input  name="financiamiento" type="hidden"  value="1"  max="100">
</form><!-- /.modal-dialog -->
      <div class="row">
        {{-- Total --}}
          <div class="col-sm-6">
            <div class="card collapsed-card">
                <table   class="table table-bordered">
                  @foreach ($dataTotal as $element)
                    @if ($element['code'] =='subtotal')
                      <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                    @endif
                    @if ($element['code'] =='tax')
                    <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                    @endif

                    @if ($element['code'] =='shipping')
                      <tr><td>{!! $element['title'] !!}:</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}"  data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.shipping') }}">{{$element['value'] }}</a></td></tr>
                    @endif
                    @if ($element['code'] =='discount')
                      <tr><td>{!! $element['title'] !!}(-):</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.discount') }}">{{$element['value'] }}</a></td></tr>
                    @endif
                    @if ($element['code'] =='other_fee')
                      <tr><td>{!! $element['title'] !!}:</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ config('cart.process.other_fee.title') }}">{{$element['value'] }}</a></td></tr>
                    @endif
                     @if ($element['code'] =='total')
                      <tr style="background:#f5f3f3;font-weight: bold;"><td>{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                    @endif

                    @if ($element['code'] =='received')
                      <tr><td>{!! $element['title'] !!}(-):</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.received') }}">{{$element['value'] }}</a></td></tr>
                    @endif

                  @endforeach

                    <tr  {!! $style !!}  class="data-balance"><td>{{ sc_language_render('order.totals.balance') }}:</td><td style="text-align:right">{{($order->balance === NULL)?sc_currency_format($order->total):sc_currency_format($order->balance) }}</td></tr>
              </table>
            </div>

            <table class="table box table-bordered" width="100%">
              <thead>
                <tr>
                  <th style="width: 50px;">No.</th>
     
                  <th>Cuota</th>

                  <th>estatus </th>
                  <th>Fecha de pagos</th>
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
 
              <td><span class="item_21_sku">{{ $historial->importe_couta}}</span></td>

              <td><span class="item_21_sku">{{ $historial->estatus->name }}</span></td>
              <td><span class="item_21_sku">{!! fecha_europea($historial->fecha_venciento) !!}</span></td>
            <td>                    <a href="#" data-id="{{ $historial->id }}"><span  data-id=" {{ $historial->id }}" title="Cambiar estatus" type="button" class="btn btn-flat mostrar_estatus_pago btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
            </td>
            </tr>
      @endforeach
              </tbody>
            </table>
      
          </div>
          {{-- //End total --}}

          {{-- History --}}
          <div class="col-sm-6">
            <div class="card">
              <table class="table table-hover box-body text-wrap table-bordered">
                <tr>
                  <td  class="td-title">{{ sc_language_render('order.order_note') }}:</td>
                  <td>
                    <a href="#" class="updateInfo" data-name="comment" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="" >
                      {{ $order->comment }}
                    </a>
                </td>
                </tr>
              </table>
            </div>


            <div class="card collapsed-card"">
              <div class="card-header border-transparent">
                <h3 class="card-title">{{ sc_language_render('order.admin.order_history') }}</h3>
                <div class="order-info">
                  <span><b>Agent:</b> {{ $order->user_agent }}</span>
                  <span><b>IP:</b> {{ $order->ip }}</span>
                </div>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 out">
                <div class="table-responsive">
                  @if (count($order->history))
                  <table  class="table m-0" id="history">
                    <tr>
                      <th>{{ sc_language_render('order.admin.history_staff') }}</th>
                      <th>{{ sc_language_render('order.admin.history_content') }}</th>
                      <th>{{ sc_language_render('order.admin.history_time') }}</th>
                    </tr>
                  @foreach ($order->history->sortKeysDesc()->all() as $history)
                    <tr>
                      <td>{{ \SCart\Core\Admin\Models\AdminUser::find($history['admin_id'])->name??'' }}</td>
                      <td><div class="history">{!! $history['content'] !!}</div></td>
                      <td>{{ $history['add_date'] }}</td>
                    </tr>
                  @endforeach
                  </table>
                @endif
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>

          </div>
          {{-- //End history --}}
      </div>
@php
  $htmlSelectProduct = '<tr>
    
              <td>
                <select onChange="selectProduct($(this));"  class="add_id form-control select2" name="add_id[]" style="width:100% !important;">
                <option value="0">'.sc_language_render('order.admin.select_product').'</option>';
                if(count($products)){
                  foreach ($products as $pId => $product){
                    $htmlSelectProduct .='<option  value="'.$pId.'" >'.$product['name'].'('.$product['sku'].')</option>';
                   }
                }
                $htmlSelectProduct .='
              </select>
              <span class="add_attr"></span>
            </td>
            <td><input type="number" name="add_nro_cuota[]"  min="0" class="add_nro_cuota form-control"  value="0"></td>

            <td>
                <select class="add_id form-control select2" name="add_modalidad[]" style="width:100% !important;">
                <option value="0"> Seleccionar Modalidad</option>';
                if(count($modalidad_pago)){
                  foreach ($modalidad_pago as $pId => $modalidad){
                  
                    $htmlSelectProduct .='<option  value="'.$pId.'" >'.$modalidad.'</option>';
                   }
                }
  $htmlSelectProduct .='
              </select>
              <span class="add_attr"></span>
            </td>

            <td>
                <select class="add_id form-control select2" name="add_inicial[]" style="width:100% !important;">
                <option value="0"> Sin Inicial</option>
                <option value="30">  Inicial 30%</option>
                ';
          
         
  $htmlSelectProduct .='
              </select>
              <span class="add_attr"></span>
            </td>

              <td><input onChange="update_total($(this));" type="number" min="0" class="add_qty form-control" name="add_qty[]" value="0"></td>

              <td><input onChange="update_total($(this));" type="number" step="0.01" min="0" class="add_price form-control" name="add_price[]" value="0"></td>
              <td><input  type="number" step="0.01" min="0" class="add_tax form-control" name="add_tax[]" value="0"></td>

              <td><input type="number" disabled class="add_total form-control" value="0"></td>
              <td><button onClick="$(this).parent().parent().remove();" class="btn btn-danger btn-md btn-flat" data-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button></td>
            </tr>
          <tr>
          </tr>';
        $htmlSelectProduct = str_replace("\n", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("\t", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("\r", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("'", '"', $htmlSelectProduct);
@endphp
    </div>
  </div>
</div>


      <!-- Modal -->
      <div class="modal fade" id="modal_estatus_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="{{route('post_status_pago')}}"  method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modificar el estatus</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             @csrf
              <div class="form-group">
                <label for="estatus_pagos"></label>
                <select class="form-control" id="estatus_pagos" name="estatus_pagos">
                  @foreach ($statusPayment as $key => $item)
                  <option  value="@php echo $key @endphp  "  >   @php  echo $item @endphp</option>
                  @endforeach
                </select>
              </div>
      
              <div class="form-group">
                <label for="observacion">Observación</label>
             <input type="text" class="form-control" id="observacion" name="observacion">
              </div>
              <input type="hidden" name="id_pago" id="id_pago">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
            </div>
          </div>
        </div>
@endsection


@push('styles')
<style type="text/css">
.history{
  max-height: 50px;
  max-width: 300px;
  overflow-y: auto;
}
.td-title{
  width: 35%;
  font-weight: bold;
}
.td-title-normal{
  width: 35%;
}
.product_qty{
  width: 80px;
  text-align: right;
}
.product_price,.product_total{
  width: 120px;
  text-align: right;
}

</style>
<!-- Ediable -->
<link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
{{-- //Pjax --}}
<script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

<!-- Ediable -->
<script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js')}}"></script>



<script type="text/javascript">

$('.mostrar_estatus_pago').click(function(){
  $("#modal_estatus_pago").modal('show');

  $("#id_pago").val($(this).data('id'))
  

    });

function abrir_modal(){

  gen_table(false)
}
function gen_table(fecha_p=false){
    

    $.ajax({
                url : '{{ sc_route_admin('obtener_orden') }}',
                type : "get",
                dateType:"application/json; charset=utf-8",
                data : {
                     id : '{{ $order->id }}',
                    
                },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(returnedData){
              $("#modal_convenio").modal('show')
              $('#loading').hide();
              $("#c_monto").val(returnedData.subtotal)
              $("#c_nro_coutas").val(returnedData.details[0].nro_coutas )
              $("#c_modalidad").val(returnedData.details[0].id_modalidad_pago  ==3 ?'Mensual' : 'Quincenal' )
              $("#c_inicial").val(returnedData.details[0].abono_inicial)
            
              if(fecha_p==false){
                $("#c_fecha_inicial").val(returnedData.details[0].fecha_primer_pago)
                fechaInicio = new Date(returnedData.details[0].fecha_primer_pago)
                  }else{
                    fechaInicio = new Date($("#c_fecha_inicial").val())
                  }
   
              
              document.getElementById("tab").innerHTML="";
          document.getElementById("butto_modal").disabled = false;
          let monto=Number(returnedData.subtotal);
          let n2=Number(returnedData.details[0].nro_coutas);
          let n3=Number(returnedData.details[0].abono_inicial);
          let inicial = parseInt(n3);

          var selected =returnedData.details[0].id_modalidad_pago;
          var selectd2 =returnedData.details[0].id_modalidad_pago  ==3 ?'Mensual' : 'Quincenal';
       
      
          
          fechaInicio.setDate(fechaInicio.getDate() + 1) // fecha actual

          if(fechaInicio == "Invalid Date"){
            var fechaInicio  = new Date();
            var fechaInicio = fechaInicio.toLocaleDateString('en-US');
            // obtener la fecha de hoy en formato `MM/DD/YYYY`
          }
         

          let periodo = selected;
      
          let totalPagos ,  plazo ,fechaPago;
          var primerFechaPago = true

          if(monto>0){ 
            document.getElementById("cuotass").innerHTML= `CUOTAS $/${selectd2}`;
            
            if ( true ) {
              plazo = n2
            } else {
              alert('No seleccionaste ningún tipo de plazo')
            }

     
            switch ( periodo ) {
              case 1:
                let fechaFin = new Date(fechaInicio)
                fechaFin.setMonth(fechaFin.getMonth() + parseInt(plazo))
                let tiempo = fechaFin.getTime() - fechaInicio.getTime()
                let dias = Math.floor(tiempo / (1000 * 60 * 60 * 24))
                totalPagos = Math.ceil(dias / 7)
                break
              case 2:
                totalPagos = plazo * 2
                break
              case 3:
                totalPagos = plazo
                
                break
              default:
                alert('No seleccionaste ningún periodo de pagos')
                break
            }

            let  montoTotal = monto
            var cuotaTotal = monto / n2
            let Inicial = montoTotal/inicial
            Inicial == Infinity ? Inicial = 0 : Inicial

             
            let texto
            for(i=1;i<=n2;i++){  
              texto = (i + 1)

              if ( primerFechaPago == true ) {
                  fechaPago = new Date(fechaInicio)
                  primerFechaPago = false
                } else {
                  if ( periodo == '1' ) {
                    fechaPago.setDate(fechaPago.getDate() + 7)
                  } else if ( periodo == '2' ) {
                    fechaPago.setDate(fechaPago.getDate() + 15)
                  } else if ( periodo == '3' ) {
                    fechaPago.setMonth(fechaPago.getMonth() + 1)
                  }
                }
                texto = fechaPago.toLocaleDateString()

                  monto -= cuotaTotal
                  ca=monto;
                  d1=ca.toFixed(2) ;
                  i2= Inicial.toFixed(2);
                  d2=cuotaTotal.toFixed(2);
                  r=ca;
                  deudas = ((n2 + i2 - ca ) ) ;
                  d3=r.toFixed(2);
                  deuda=deudas.toFixed(1);
                  document.getElementById("tab").innerHTML=document.getElementById("tab").innerHTML+
                          `
                          
                          
                          
                          <tr>
                              <td>${i}</td>
                            
                              <td> <input readonly class="form-control" name="coutas_calculo[]" type="text" value="${d2}"> </td>
                              <td> ${d3} </td>
                              <td> <input  readonly class="form-control"  name="fechas_pago_cuotas[]" type="text" value="${texto}"> </td>
                          </tr>`;
              }
              n1= monto/n2;
              t_i=i2*n2;
              d4=t_i.toFixed(2);
              t_p=r*n2;
              d5=t_p.toFixed(2);
              document.getElementById("t1").innerHTML=d4;
   ;
              document.getElementById("t3").innerHTML= "$"+montoTotal ;        
              document.getElementById("t4").innerHTML= texto ;       
                
              
              

          }else{
              alert("Falta ingresar un Número");
          }
    console.log(returnedData)

                $('#loading').hide();
                }
            });
        

        

      }
function update_total(e){
    node = e.closest('tr');
    var qty = node.find('.add_qty').eq(0).val();
    var price = node.find('.add_price').eq(0).val();
    node.find('.add_total').eq(0).val(qty*price);
}


//Add item
    function selectProduct(element){
        node = element.closest('tr');
        var id = node.find('option:selected').eq(0).val();
        if(!id){
            node.find('.add_sku').val('');
            node.find('.add_qty').eq(0).val('');
            node.find('.add_price').eq(0).val('');
            node.find('.add_attr').html('');
            node.find('.add_tax').html('');
        }else{
            $.ajax({
                url : '{{ sc_route_admin('admin_order.product_info') }}',
                type : "get",
                dateType:"application/json; charset=utf-8",
                data : {
                     id : id,
                     order_id : '{{ $order->id }}',
                },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(returnedData){
                node.find('.add_sku').val(returnedData.sku);
                node.find('.add_qty').eq(0).val(1);
                node.find('.add_price').eq(0).val(returnedData.price_final * {!! ($order->exchange_rate)??1 !!});
                node.find('.add_total').eq(0).val(returnedData.price_final * {!! ($order->exchange_rate)??1 !!});
                node.find('.add_attr').eq(0).html(returnedData.renderAttDetails);
                node.find('.add_tax').eq(0).html(returnedData.tax);
                $('#loading').hide();
                }
            });
        }

    }
$('#add-item-button').click(function() {
  var html = '{!! $htmlSelectProduct !!}';
  $('#add-item').before(html);
  $('.select2').select2();
  $('#add-item-button-save').show();
});

$('#add-item-button-save').click(function(event) {
    $('#add-item-button').prop('disabled', true);
    $('#add-item-button-save').button('loading');
    $.ajax({
        url:'{{ route("admin_order.add_item") }}',
        type:'post',
        dataType:'json',
        data:$('form#form-add-item').serialize(),
        beforeSend: function(){
            $('#loading').show();
        },
        success: function(result){
          $('#loading').hide();
            if(parseInt(result.error) ==0){
                location.reload();
            }else{
              alertJs('error', result.msg);
            }
        }
    });
});

//End add item
//

$(document).ready(function() {
  all_editable();
});

function all_editable(){
    $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
    };

    $('.updateInfo').editable({
      success: function(response) {
        if(response.error ==0){
          alertJs('success', response.msg);
        } else {
          alertJs('error', response.msg);
        }
    }
    });

    $(".updatePrice").on("shown", function(e, editable) {
      var value = $(this).text().replace(/,/g, "");
      editable.input.$input.val(parseInt(value));
    });

    $('.updateStatus').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  sc_language_render('admin.not_empty') }}';
            }
        },
        success: function(response) {
          if(response.error ==0){
            alertJs('success', response.msg);
          } else {
            alertJs('error', response.msg);
          }
      }
    });

    $('.updateInfoRequired').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  sc_language_render('admin.not_empty') }}';
            }
        },
        success: function(response,newValue) {
          console.log(response.msg);
          if(response.error == 0){
            alertJs('success', response.msg);
          } else {
            alertJs('error', response.msg);
          }
      }
    });


    $('.edit-item-detail').editable({
        ajaxOptions: {
        type: 'post',
        dataType: 'json'
        },
        validate: function(value) {
          if (value == '') {
              return '{{  sc_language_render('admin.not_empty') }}';
          }
          if (!$.isNumeric(value)) {
              return '{{  sc_language_render('admin.only_numeric') }}';
          }
        },
        success: function(response,newValue) {
            if(response.error ==0){
                $('.data-shipping').html(response.detail.shipping);
                $('.data-received').html(response.detail.received);
                $('.data-subtotal').html(response.detail.subtotal);
                $('.data-tax').html(response.detail.tax);
                $('.data-total').html(response.detail.total);
                $('.data-shipping').html(response.detail.shipping);
                $('.data-discount').html(response.detail.discount);
                $('.item_id_'+response.detail.item_id).html(response.detail.item_total_price);
                var objblance = $('.data-balance').eq(0);
                objblance.before(response.detail.balance);
                objblance.remove();
                alertJs('success', response.msg);
            } else {
              alertJs('error', response.msg);
            }
        }

    });

    $('.updatePrice').editable({
        ajaxOptions: {
        type: 'post',
        dataType: 'json'
        },
        validate: function(value) {
          if (value == '') {
              return '{{  sc_language_render('admin.not_empty') }}';
          }
          if (!$.isNumeric(value)) {
              return '{{  sc_language_render('admin.only_numeric') }}';
          }
       },

        success: function(response, newValue) {
              if(response.error ==0){
                  $('.data-shipping').html(response.detail.shipping);
                  $('.data-received').html(response.detail.received);
                  $('.data-subtotal').html(response.detail.subtotal);
                  $('.data-tax').html(response.detail.tax);
                  $('.data-total').html(response.detail.total);
                  $('.data-shipping').html(response.detail.shipping);
                  $('.data-discount').html(response.detail.discount);
                  var objblance = $('.data-balance').eq(0);
                  objblance.before(response.detail.balance);
                  objblance.remove();
                  alertJs('success', response.msg);
              } else {
                alertJs('error', response.msg);
              }
      }
    });
}


{{-- sweetalert2 --}}
function deleteItem(id){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ sc_language_render('action.delete_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'POST',
                url: '{{ route("admin_order.delete_item") }}',
                data: {
                  'pId':id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                  if(response.error ==0){
                    location.reload();
                    alertJs('success', response.msg);
                } else {
                  alertJs('error', response.msg);
                }
                  
                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}' );
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}
{{--/ sweetalert2 --}}


  $(document).ready(function(){
  // does current browser support PJAX
    if ($.support.pjax) {
      $.pjax.defaults.timeout = 2000; // time in milliseconds
    }

  });

  function order_print(){
    $('.not-print').hide();
    window.print();
    $('.not-print').show();
  }
</script>

@endpush
