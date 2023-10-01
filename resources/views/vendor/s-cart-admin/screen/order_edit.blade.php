@extends($templatePathAdmin . 'layout')

@section('main')



    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="tab_ordenes" role="tablist">

                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Solicitud</a>
                </li>
                @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 2)
                    
               
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tabevaluaciones-tab" data-toggle="tab" href="#tabevaluaciones" role="tab"
                        aria-controls="tabevaluaciones" aria-selected="false">Evaluaciones</a>
                </li>
                @endif
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="recibos-tab" data-toggle="tab" href="#recibos" role="tab"
                        aria-controls="recibos" aria-selected="false">Recibos</a>
                </li>
      

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tabacciones-tab" data-toggle="tab" href="#tabacciones" role="tab"
                        aria-controls="tabacciones" aria-selected="false">Historial Acciones</a>
                </li>
                @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 2)
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tabtotales-tab" data-toggle="tab" href="#tabtotales" role="tab"
                        aria-controls="tabtotales" aria-selected="false">Totales</a>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">Generar Documentos</a>
                    <div class="dropdown-menu">



                        {{-- administracion --}}
                        @if (
                            $estatus_user == 'Riesgo' ||
                                $estatus_user == 'administrator' ||
                                $estatus_user == 'Administrator' ||
                                $estatus_user == 'administracion')
                            @if ($order->total > 0 && !empty($convenio))
                                <a class="dropdown-item" href="{{ route('downloadJuradada', ['id' => $order->id]) }}"
                                    target="_blank">Declaración Jurada</a>
                            @endif


                            @php  $dblockconvenio="display:none;";   @endphp
                            @if (count($order->details) > 0 && empty($convenio) && $order->modalidad_de_compra >= 1 && $order->status == 5)
                                @php  $dblockconvenio="display:block;";   @endphp

                                <a class="dropdown-item" href="#" onclick="abrir_modal_convenio(event)">Generar
                                    Convenio</a>
                            @endif
                            @if ($order->total > 0 && !empty($convenio))
                                <a class="dropdown-item" href="{{ route('downloadPdf', ['id' => $order->id]) }}"
                                    target="_blank">Descargar convenio</a>
                            @endif
                            @if ($order->total > 0 && !empty($convenio))
                                <a class="dropdown-item" href="{{ route('editar_convenio_cliente', ['id' => $order->id]) }}"
                                    target="_blank">Editar Plantilla convenio</a>
                            @endif
                            @if ($order->total > 0 && $order->modalidad_de_compra >= 1 && empty($convenio))
                                    @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 2)
                                    <a class="dropdown-item" href="{{ route('borrador_pdf', ['id' => $order->id]) }}"
                                        target="_blank">Ver Borrador Convenio</a>
                                        
                                    @endif
                               
                            @endif
                        @endif


                        @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 2)
                            <a class="dropdown-item" href="{{ route('ficha_pedido', ['order_id' => $order->id]) }}"
                                target="_blank">Descargar expediente</a>
                        @endif

                        <!--a href="{{ sc_route_admin('admin_order.invoice', ['order_id' => $order->id]) }}" target="_blank">{{ sc_language_render('order.invoice') }}</a -->


                                
                        @if (in_array(strtolower($estatus_user), ['administrator', 'administracion']) &&
                                $order->modalidad_de_compra == 3 || $estatus_user == 'Vendedor_Propuesta' || $estatus_user == 'Vendedor' )
                            <a class="dropdown-item" href="{{ sc_route_admin('propuesta', ['order_id' => $order->id]) }}"
                                target="_blank">Descargar propuesta</a>
                        @endif

                       




                </li>


            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card">

                        <div class="card-header with-border">


                            <div class="row">
                                <div class="col-4">
                                    @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 0 || $order->modalidad_de_compra == 2)
                                        <h3 class="card-title">{{ sc_language_render('order.order_detail') }}
                                            #{{ $order->id }}</h3>
                                    @elseif ($order->modalidad_de_compra == 3)
                                        <h3>PROPUESTA#{{ $order->id }}</h3>
                                    @endif


                                </div>




                                <div class="col-4">
                                    <div class="card-tools not-print">
                                        <div class="btn-group float-right" style="margin-right: 0px">
                                            <a href="{{ sc_route_admin('admin_order.index') }}"
                                                class="btn btn-flat btn-default"><i
                                                    class="fa fa-list"></i>&nbsp;{{ sc_language_render('admin.back_list') }}</a>
                                        </div>

                                    </div>
                                </div>







                            </div>
                        </div>



                        <div class="row" id="order-body">
                            <div class="col-sm-6">
                                <table class="table table-bordered">
                                    @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 0 || $order->modalidad_de_compra == 2)
                                        <tr>
                                            <td class="td-title">{{ sc_language_render('order.order_status') }}:</td>
                                            <td>
                                                {{ $statu_en[$order->status] ?? '' }}
                                                @php
                                                    $liststatus = array_keys($statusOrder);
                                                @endphp
                                                @if (in_array($order->status, $liststatus))
                                                    <a href="#" class="updateStatus" data-name="status"
                                                        data-type="select" data-source="{{ json_encode($statusOrder) }}"
                                                        data-pk="{{ $order->id }}"
                                                        data-value="{!! $order->status !!}"
                                                        data-url="{{ route('admin_order.update') }}"
                                                        data-title="{{ sc_language_render('order.order_status') }}"><span
                                                            title="editar estatus" type="button"
                                                            class="btn btn-flat btn-sm btn-primary ">*<i
                                                                class="fa fa-edit"></i></span></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endif

                                    @if ($order->modalidad_de_compra == 3)
                                        <tr>
                                            <td class="td-title">Modalidad de compra:</td>
                                            <td>
                                                {{ 'MODALIDAD' }}


                                                <a href="#" class="updateStatus" data-name="modalidad_de_compra"
                                                    data-type="select"
                                                    data-source="{{ json_encode([
                                                        0 => 'Al contado',
                                                        1 => 'Financiamento',
                                                        2 => 'Propuesta',
                                                        3 => 'Entraga inmediata',
                                                    ]) }}"
                                                    data-pk="{{ $order->id }}" data-value=""
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.order_status') }}"><span
                                                        title="editar Modalidad" type="button"
                                                        class="btn btn-flat btn-sm btn-primary ">*<i
                                                            class="fa fa-edit"></i></span></a>


                                            </td>
                                        </tr>
                                    @endif

                                    @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 2)
                                        <tr>
                                            <td> Modalidad de compra</td>
                                            <td>
                                                @if ($order->modalidad_de_compra == 1)
                                                    {{ 'Financiamiento' }}
                                                @elseif ($order->modalidad_de_compra == 2)
                                                    {{ 'Financiamiento/Entrega Inmediata' }}
                                                @elseif ($order->modalidad_de_compra == 3)
                                                    {{ 'propuesta' }}
                                                @else
                                                    {{ 'Al contado' }}
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>

                                            <td> Convenio</td>
                                            <td>


                                                {{ $convenio ? str_pad($convenio->nro_convenio, 6, '0', STR_PAD_LEFT) : 'No se ha parametrizado el convenio' }}

                                            </td>

                                        </tr>
                                        <tr>

                                            <td>Fecha del convenio</td>
                                            <td><a href="#" class="updateStatus" data-name="fecha_primer_pago"
                                                    data-type="date"
                                                    data-source="{{ json_encode($order->fecha_primer_pago) }}"
                                                    data-pk="{{ $order->id }}"
                                                    data-value="@if (!empty($order->fecha_primer_pago)) {{ $order->fecha_primer_pago }} @endif"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="fecha de pago">
                                                    @if (!empty($order->fecha_primer_pago))
                                                        {{ $order->fecha_primer_pago }}
                                                    @endif
                                                </a> </td>

                                        </tr>


                                        <tr>

                                            <td>Fecha de entrega</td>
                                            <td><a href="#" class="updateStatus" data-name="fecha_maxima_entrega"
                                                    data-type="date"
                                                    data-source="{{ json_encode($order->fecha_maxima_entrega) }}"
                                                    data-pk="{{ $order->id }}"
                                                    data-value="@if (!empty($order->fecha_maxima_entrega)) {{ $order->fecha_maxima_entrega }} @endif"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="Fecha de entrega">
                                                    @if (!empty($order->fecha_maxima_entrega))
                                                        {{ $order->fecha_maxima_entrega }}
                                                    @endif
                                                </a> </td>

                                        </tr>
                                    @endif


                                    @if ($order->modalidad_de_compra == 0)
                                        <tr>
                                            <td>{{ sc_language_render('order.shipping_status') }}:</td>
                                            <td>

                                                <a href="#" class="updateStatus" data-name="shipping_status"
                                                    data-type="select" data-source="{{ json_encode($statusShipping) }}"
                                                    data-pk="{{ $order->id }}" data-value="{!! $order->shipping_status !!}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.shipping_status') }}">{{ $statusShipping[$order->shipping_status] ?? $order->shipping_status }}</a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ sc_language_render('order.shipping_method') }}:</td>
                                            <td><a href="#" class="updateStatus" data-name="shipping_method"
                                                    data-type="select" data-source="{{ json_encode($shippingMethod) }}"
                                                    data-pk="{{ $order->id }}" data-value="{!! $order->shipping_method !!}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.shipping_method') }}">{{ $order->shipping_method }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ sc_language_render('order.payment_method') }}:</td>
                                            <td><a href="#" class="updateStatus" data-name="payment_method"
                                                    data-type="select" data-source="{{ json_encode($paymentMethod) }}"
                                                    data-pk="{{ $order->id }}" data-value="{!! $order->payment_method !!}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.payment_method') }}">{{ $order->payment_method }}</a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 2)
                                        <tr>
                                            <td> Estatus de pago Global:</td>
                                            <td><a href="#" class="updateStatus" data-name="payment_status"
                                                    data-type="select" data-source="{{ json_encode($statusPayment) }}"
                                                    data-pk="{{ $order->id }}" data-value="{!! $order->payment_status !!}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.payment_status') }}">{{ $statusPayment[$order->payment_status] ?? $order->payment_status }}</a>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td> Serial del articulo:</td>
                                        <td>
                                            <a id="serial"
                                                data-index-number="{{ $order->nro_coutas }}"
                                                href="#" class="updateStatus"
                                                data-value="{{ $order->serial }}" data-name="serial"
                                                data-type="text" min=0 data-pk="{{ $order->id }}"
                                                data-url="{{ route('admin_order.edit_item') }}"
                                                data-title="serial">{{ $order->serial ?? '' }}</a>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td></i> {{ sc_language_render('admin.created_at') }}:</td>
                                        <td>{{ $order->created_at }}</td>
                                    </tr>
                                    @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 0 || $order->modalidad_de_compra == 2 || $order->modalidad_de_compra == 3)
                                        <tr>
                                            <td class="td-title">
                                                Vendedor Asignado:</td>
                                            <td>
                                                <a href="#" class="updateStatus" data-name="vendedor_id"
                                                    data-type="select" data-source="{{ json_encode($list_usuarios) }}"
                                                    data-pk="{{ $order->id }}" data-value="{!! $order->vendedor_id !!}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.order_status') }}">{{ $list_usuarios[$order->vendedor_id] ?? $order->vendedor_id }}</a>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                                <table class="table table-hover box-body text-wrap table-bordered">
                                    @if (!$order['modalidad_de_compra'] >= 1)
                                        <tr>
                                            <td class="td-title"><i class="far fa-money-bill-alt nav-icon"></i>
                                                {{ sc_language_render('order.currency') }}:</td>
                                            <td>{{ $order->currency }}</td>
                                        </tr>
                                        <tr>


                                            <td class="td-title"><i class="fas fa-chart-line"></i>
                                                {{ sc_language_render('order.exchange_rate') }}:</td>
                                            <td>
                                                <a href="#" class="updateStatus"
                                                    data-value="{{ $order->exchange_rate ?? 1 }}"
                                                    data-name="exchange_rate" data-type="text" min=0
                                                    data-pk="{{ $order->id }}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="tipo de cambio">{{ $order->exchange_rate }}</a>


                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <table class="table table-hover box-body text-wrap table-bordered">
                                    <tr>
                                        <td class="td-title">{{ sc_language_render('order.first_name') }}:</td>
                                        <td><a href="#" class="" data-name="first_name" data-type="text"
                                                data-pk="{{ $order->id }}"
                                                data-url="{{ route('admin_order.update') }}"
                                                data-title="{{ sc_language_render('order.first_name') }}">{!! $order->first_name !!}</a>
                                        </td>
                                    </tr>

                                    @if (sc_config_admin('customer_lastname'))
                                        <tr>
                                            <td class="td-title">{{ sc_language_render('order.last_name') }}:</td>
                                            <td><a href="#" class="" data-name="last_name" data-type="text"
                                                    data-pk="{{ $order->id }}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.last_name') }}">{!! $order->last_name !!}</a>
                                            </td>
                                        </tr>
                                    @endif

                                    @if (sc_config_admin('customer_phone'))
                                        <tr>
                                            <td class="td-title">{{ sc_language_render('order.phone') }}:</td>
                                            <td><a href="#" class="" data-name="phone" data-type="text"
                                                    data-pk="{{ $order->id }}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.phone') }}">{!! $order->phone !!}</a>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="td-title">{{ sc_language_render('order.email') }}:</td>
                                        <td>{!! empty($order->email) ? 'N/A' : $order->email !!}</td>
                                    </tr>

                                    @if (sc_config_admin('customer_company'))
                                        <tr>
                                            <td class="td-title">{{ sc_language_render('order.company') }}:</td>
                                            <td><a href="#" class="updateInfoRequired" data-name="company"
                                                    data-type="text" data-pk="{{ $order->id }}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.company') }}">{!! $order->company !!}</a>
                                            </td>
                                        </tr>
                                    @endif








                                    @if (sc_config_admin('customer_country'))
                                        <tr>
                                            <td class="td-title">{{ sc_language_render('order.country') }}:</td>
                                            <td><a href="#" class="updateInfoRequired" data-name="country"
                                                    data-type="select" data-source="{{ json_encode($country) }}"
                                                    data-pk="{{ $order->id }}"
                                                    data-url="{{ route('admin_order.update') }}"
                                                    data-title="{{ sc_language_render('order.country') }}"
                                                    data-value="{!! $order->country !!}"></a></td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="td-title">Ver documentos:</td>
                                        <td>

                                            @if (empty($documento))
                                                El cliente no ha adjuntado Documentos <br>
                                            @endif
                                            <a target="_blank"
                                                href="{{ sc_route_admin('admin_customer.document', ['id' => $order->customer_id ? $order->customer_id : 'not-found-id']) }}"
                                                class="" data-name="address2">Ir a Documentos</a>
                                        </td>


                                    </tr>
                                    <tr>

                                        <td class="td-title">datos del cliente</td>
                                        <td>

                                            <a href="{{ sc_route_admin('admin_customer.edit', ['id' => $order->customer_id ? $order->customer_id : 'not-found-id']) }}"
                                                class="" data-name="address2">Ver perfil del cliente</a>
                                        </td>


                                    </tr>
                                    @if ($pagadoCount >= 1)
                                        <tr>
                                            <td class="td-title">Reporte de pago</td>
                                            <td>

                                                <a target="_blank"
                                                    href="{{ sc_route_admin('historial.cliente') }}?historial_pago=true&keyword={{ $order->id }}"
                                                    class="" data-name="address2">Ir al Reporte de pago </a>
                                            </td>


                                        </tr>


                                        <tr>
                                            <td class="td-title">Nota de entrega</td>
                                            <td>

                                                <a target="_blank"
                                                    href="{{ sc_route_admin('notas.entrega') }}?notas_entrega=true&keyword={{ $order->id }}"
                                                    class="" data-name="address2">Ir a la Nota de entrega </a>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="td-title">Creado Por:</td>
                                        <td>
                                            {!! empty($order->usuario) ? 'Catalogo-Cliente' : $order->usuario !!}
                                        </td>


                                    </tr>

                                    <tr>
                                        <td class="td-title">Clasificación del cliente:</td>
                                        <td>
                                            @if (!empty($clasificacion))
                                                {!! getBadgeHtml($clasificacion) !!}
                                            @else
                                                <span class="text-info">No ha
                                                    realizado el primer pago</span>
                                            @endif
                                        </td>


                                    </tr>
                                </table>
                            </div>



                        </div>

                        <input type="hidden" name="styleStatusPayment" id="styleStatusPayment"
                            value="{{ json_encode($styleStatusPayment) }}">

                        @php
                            if ($order->balance == 0) {
                                $style = 'style="color:#0e9e33;font-weight:bold;"';
                            } elseif ($order->balance < 0) {
                                $style = 'style="color:#ff2f00;font-weight:bold;"';
                            } else {
                                $style = 'style="font-weight:bold;"';
                            }
                        @endphp


                        <form id="form-add-item" action="" method="">

                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="card collapsed-card">
                                        <div class="table-responsive">
                                            <table class="table table-hover  table-bordered text-center ">
                                                <thead>
                                                    <tr style="text-align: center">
                                                        <th >{{ sc_language_render('product.name') }}</th>
                                                        <th>Cuotas</th>
                                                        <th>Modalidad</th>
                                                        <th>Inicial $</th>
                                                        <th>Cuotas $</th>
                                                        <th>Cuotas Especial $</th>
                                                        <th>Cant</th>
                                                        <th >{{ sc_language_render('product.price') }}</th>

                                                        {{-- <th class="product_tax">{{ sc_language_render('product.tax') }}</th> --}}
                                                        <th class="product_total">Total</th>
                                                        @if (!$order->modalidad_de_compra >= 1)
                                                            <th>{{ sc_language_render('action.title') }}</th>
                                                        @endif

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($order->details as $item)
                                                        <tr>
                                                            <td>{{ $item->name }}
                                                                @php
                                                                    
                                                                    $html = '';
                                                                    if ($item->attribute && is_array(json_decode($item->attribute, true))) {
                                                                        $array = json_decode($item->attribute, true);
                                                                        foreach ($array as $key => $element) {
                                                                            $html .= '<br><b>' . $attributesGroup[$key] . '</b> : <i>' . sc_render_option_price($element, $order->currency, $order->exchange_rate) . '</i>';
                                                                        }
                                                                    }
                                                                @endphp
                                                                {!! $html !!}
                                                            </td>


                                                            <td>
                                                                <a id="cuotas_nro"
                                                                    data-index-number="{{ $item->nro_coutas }}"
                                                                    href="#" class="{!!$item->nro_coutas > 1  ? 'edit-item-detail':''!!}"
                                                                    data-value="{{ $item->nro_coutas }}"
                                                                    data-name="nro_coutas" data-type="text" min=0
                                                                    data-pk="{{ $item->id }}"
                                                                    data-url="{{ route('admin_order.edit_item') }}"
                                                                    data-title="Cuotas">{{ $item->nro_coutas > 1 ?$item->nro_coutas:$cuotas_inmediatas }}</a>

                                                            </td>


                                                            


                                                            <td>
                                                                <a href="#" class="updateStatus"
                                                                    data-name="id_modalidad_pago" data-type="select"
                                                                    data-source="{{ json_encode($modalidad_pago) }}"
                                                                    data-pk="{{ $item->id }}"
                                                                    data-value="{!! $modalidad_pago[$item->id_modalidad_pago] ?? 'No aplica' !!}"
                                                                    data-url="{{ route('admin_order.edit_item') }}"
                                                                    data-title="Modalidad de pago">{{ $modalidad_pago[$item->id_modalidad_pago] ?? 'No aplica' }}</a>

                                                            </td>
                                                            <td>
                                                                @php 
                                                                    $data_json_inicial = '';
                                                                    $monto_inicial = 0.0;   

                                                                    
                                                       
                                                              
                                                                    if ($item->abono_inicial > 0 && $item->nro_coutas > 0) {
                                                                        $monto_inicial = ($item->abono_inicial * ($item->total_price )) / 100;
                                                                        $data_json_inicial = ',"' . $item->abono_inicial . '":"Inicial ' . $item->abono_inicial . '%"';
                                                                        $monto_inicial = number_format($monto_inicial,2);
                                                                    }

                                                                    if ($monto_Inicial > 0 && $cuotas_inmediatas > 0 && $item->nro_coutas == 1) {
                                                                       
                                                                        $monto_inicial = $monto_Inicial;
                                                                    }

                                                                  

                                                                    
                                                                    
                                                                @endphp;
                                                                <a href="#" class="updateStatus"
                                                                    data-name="abono_inicial" data-type="text"
                                                                    min=0
                                                                    data-source='{"0":"Sin inicial","30":"Con inicial  30%" {!! $data_json_inicial !!} }'
                                                                    data-pk="{{ $item->id }}"
                                                                    data-value="{{ $monto_inicial }}"
                                                                    data-url="{{ route('admin_order.edit_item') }}"
                                                                    data-title="Inicial $">
                                                                    @if ($item->abono_inicial > 0 && $item->nro_coutas > 0)
                                                                        Con Inicial ${{ $monto_inicial }}
                                                                    @elseif($monto_Inicial > 0 && $cuotas_inmediatas > 0 && $item->nro_coutas == 1)
                                                                    Con Inicial ${{ $monto_inicial }}

                                                                        @else
                                                                        Sin inicial
                                                                    @endif
                                                                </a>

                                                            </td>
                                                           
                                                          
                                                            <td>
                                                                @php
                                                                    
                                                                    $precio_couta = 0;


                                                                   
                                                                    $inicial = ($item->abono_inicial * $item->total_price) / 100;
                                                                    $total_inicial= $item->monto_cuota_entrega +$inicial;

                                                            
                                                                    if ($item->nro_coutas > 1):
                                                             
                                                               
                                                                  
                                                                        
                                                                        $total_price = ($item->total_price -  $total_inicial);
                                                                   $precio_couta = "$" . number_format($total_price / $item->nro_coutas,2);
                                                                    

                                                                   
                                                                       
                                                                    endif;

                                                                    echo   $precio_couta ;


                                                                    
                                                                   
                                                                 
                                                                    
                                                                @endphp
                                                            </td>
                                                            <td class="product_monto_cuota_entrega"> <a href="#"
                                                              class="edit-item-detail "
                                                              data-value="{!! $item->monto_cuota_entrega > 0 ? $item->monto_cuota_entrega: $monto_entrega !!}" data-name="monto_cuota_entrega"
                                                              data-type="number" min=0
                                                              data-pk="{{ $item->id }}"
                                                              data-url="{{ route('admin_order.edit_item') }}"
                                                              data-title="Couta de entrega">
                                                              {!! $item->monto_cuota_entrega > 0 ? $item->monto_cuota_entrega: $monto_entrega !!}</a>
                                                            
                                                        </td>

                                                            <td class="product_qty">x <a href="#"
                                                                    class="edit-item-detail"
                                                                    data-value="{{ $item->qty }}" data-name="qty"
                                                                    data-type="number" min=0
                                                                    data-pk="{{ $item->id }}"
                                                                    data-url="{{ route('admin_order.edit_item') }}"
                                                                    data-title="{{ sc_language_render('order.qty') }}">
                                                                    {{ $item->qty }}</a>
                                                                  
                                                              </td>

                                                            <td class="product_price">
                                                                <a href="#" class="edit-item-detail"
                                                                    data-value="{{ $item->price }}" data-name="price"
                                                                    data-type="text" min=0 data-pk="{{ $item->id }}"
                                                                    data-url="{{ route('admin_order.edit_item') }}"
                                                                    data-title="{{ sc_language_render('product.price') }}">{{ $item->price }}</a>

                                                            </td>
                                                            {{-- <td class="product_tax"><a href="#" class="edit-item-detail" data-value="{{ $item->tax }}" data-name="tax" data-type="text" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ sc_language_render('order.tax') }}"> {{ $item->tax }}</a></td> --}}

                                                            <td class="product_total item_id_{{ $item->id }}">
                                                                {{ sc_currency_render_symbol($item->total_price, $order->currency) }}
                                                            </td>

                                                            @if ($order->modalidad_de_compra >= 1 && empty($convenio))
                                                                <td>
                                                                    <span onclick="deleteItem('{{ $item->id }}');"
                                                                        class="btn btn-danger btn-xs"
                                                                        data-title="Delete"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i></span>
                                                                </td>
                                                            @endif

                                                            @if ($order->modalidad_de_compra == 0)
                                                                <td>
                                                                    <span onclick="deleteItem('{{ $item->id }}');"
                                                                        class="btn btn-danger btn-xs"
                                                                        data-title="Delete"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i></span>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach

                                                    <tr id="add-item" class="not-print">
                                                        <td colspan="9">
                                                            @if ($order->total <= 0 && empty($convenio) && $order->modalidad_de_compra >= 1)
                                                                <button type="button" class="btn btn-flat btn-success"
                                                                    id="add-item-button"
                                                                    title="{{ sc_language_render('action.add') }}"><i
                                                                        class="fa fa-plus"></i>
                                                                    {{ sc_language_render('action.add') }}</button>
                                                            @endif
                                                            @if ($order->modalidad_de_compra == 0)
                                                                <button type="button" class="btn btn-flat btn-success"
                                                                    id="add-item-button"
                                                                    title="{{ sc_language_render('action.add') }}"><i
                                                                        class="fa fa-plus"></i>
                                                                    {{ sc_language_render('action.add') }}</button>
                                                            @endif
                                                            &nbsp;&nbsp;&nbsp;<button
                                                                style="display: none; margin-right: 50px" type="button"
                                                                class="btn btn-flat btn-warning" id="add-item-button-save"
                                                                title="Save"><i class="fa fa-save"></i>
                                                                {{ sc_language_render('action.save') }}</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <table class="table table-hover box-body text-wrap table-bordered">
                            <tr >
                                <td  class="td-title">Notas de la solicitud:</td>
                                <td>
                                    <a href="#" class="updateInfo" data-name="comment" data-type="textarea"
                                        data-pk="{{ $order->id }}" data-url="{{ route('admin_order.update') }}"
                                        data-title="">
                                        {{ $order->comment }}
                                    </a>
                                </td>
                            </tr>
                        </table>



                        <input name="qty" type="hidden" value="1" min="1" max="100">
                        <input name="financiamiento" type="hidden" value="1" max="100">
                        <input name="id_usuario" type="hidden" value="{{ $order->customer_id }}">
                        </form><!-- /.modal-dialog -->

                        @php
                            
                            $opcion_inicial = '  <option value="0"> Sin Inicial</option>
                                <option value="30">  Inicial 30%</option>';
                            
                            $htmlSelectProduct =
                                '<tr>
    
              <td>
                <select onChange="selectProduct($(this));"  class="add_id form-control select2" name="add_id[]" style="width:100% !important;">
                <option value="0">' .
                                sc_language_render('order.admin.select_product') .
                                '</option>';
                            if (count($products)) {
                                foreach ($products as $pId => $product) {
                                    $htmlSelectProduct .= '<option  value="' . $pId . '" >' . $product['name'] . '(' . $product['sku'] . ')</option>';
                                }
                            }
                            
                            $htmlSelectProduct .= '
              </select>
              <span class="add_attr"></span>
            </td>

           

            <td><input type="number" name="add_nro_cuota[]"  min="0" class="add_nro_cuota form-control"  value="0"></td>


         

            

            <td>
                <select required class="add_id form-control select2" name="add_modalidad[]" style="width:100% !important;">
                ';
                            if (count($modalidad_pago)) {
                                foreach ($modalidad_pago as $pId => $modalidad) {
                                    $htmlSelectProduct .= '<option  value="' . $pId . '" >' . $modalidad . '</option>';
                                }
                            }
                            $htmlSelectProduct .= '
              </select>
              <span class="add_attr"></span>
            </td>

            <td>
            <input  type="number" min="0" class="add_inicial form-control add_id[]" name="add_inicial[]" value="0"></td>

              
                ';
                            
                            $htmlSelectProduct .= '
              
                <span class="add_attr"></span>
              </td>
            
            
              <td> <span class="monto_cuota_text"></span> </td>
              
              <td><input onChange="update_total($(this));" type="number" min="0" class="add_monto_cuota_entrega form-control" name="add_monto_cuota_entrega[]" value="0"></td>

              <td><input onChange="update_total($(this));" type="number" min="0" class="add_qty form-control" name="add_qty[]" value="0"></td>

             

              <td><input onChange="update_total($(this));" type="number" step="0.01" min="0" class="add_price form-control" name="add_price[]" id="preci" value="0"></td>

              <input  type="hidden" step="0.01" min="0" class="add_tax form-control" name="add_tax[]" value="0">

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
                    <!-- finf card -->
                </div> <!-- fin tab solicitud-->
                <div class="tab-pane fade" id="recibos" role="tabpanel" aria-labelledby="recibos-tab">
                    <!--  card  recibos-->
                    @include($templatePathAdmin . 'screen.orden-tab.recibos');


                </div>
                <div class="tab-pane fade" id="tabevaluaciones" role="tabpanel" aria-labelledby="tabevaluaciones-tab">

                    @include($templatePathAdmin . 'screen.orden-tab.evaluaciones');
                </div> <!-- fin tab evaluaciones-->

                <div class="tab-pane fade" id="tabacciones" role="tabpanel" aria-labelledby="tabacciones-tab">

                    @include($templatePathAdmin . 'screen.orden-tab.historial_acciones');
                </div> <!-- fin tab acciones-->
                <div class="tab-pane fade" id="tabtotales" role="tabpanel" aria-labelledby="tabtotales-tab">

                    @include($templatePathAdmin . 'screen.orden-tab.total_pedidos');
                </div> <!-- fin tab totale-->


                @include($templatePathAdmin . 'screen.orden-tab.modales_pedidos');
            </div>
            <!-- modales-->

        </div>
    </div>


@endsection


@push('styles')
    <style type="text/css">
        .history {
            max-height: 50px;
            max-width: 300px;
            overflow-y: auto;
        }

        .td-title {
            width: 35%;
            font-weight: bold;
        }

        .td-title-normal {
            width: 35%;
        }

        .product_qty {
            width: 80px;
            text-align: right;
        }

        .product_price,
        .product_total {
            width: 120px;
            text-align: right;
        }
    </style>
    <!-- Ediable -->
    <link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css') }}">
@endpush

@push('scripts')
    {{-- //Pjax --}}
    <script src="{{ sc_file('admin/plugin/jquery.pjax.js') }}"></script>

    <!-- Ediable -->
    <script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js') }}"></script>
    @include($templatePathAdmin . 'screen.orden-tab.script_js');
@endpush
