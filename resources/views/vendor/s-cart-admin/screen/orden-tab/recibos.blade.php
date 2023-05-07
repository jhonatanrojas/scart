<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <div class="menu-right">
                <a href="{{ sc_route_admin('historial.cliente')}}?historial_pago=true&keyword={{$order->id }}" target="_blank"  class="btn  btn-info  btn-flat" title="Reporte Historial de pago" id="">
<i class="fa fa-file-pdf" title="Reporte Historial de pago"></i>
</a>

</div>
            <div class="menu-right">
                <a href="#" onclick="$('#modalNuevoRecibo').modal('show')" class="btn  btn-success  btn-flat" title="Crear Pago" id="button_create_new">
<i class="fa fa-plus" title="Añadir nuevo revibo"></i>
</a>

</div>
         

</div>
    </div>
    <div class="card-body">
        <table class="table box table-bordered" width="100%" id="tablerecibos">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Acciones</th>
                    <th>Importe </th>
                    <th>Reportado</th>
                    <th>Moneda</th>
                    <th>Conversion</th>
                    <th>estatus </th>
                    <th>Fecha de vencimiento</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
           @php 
           $total_pagado=0;
           $total_pendiente=0;
           $Nr = 0 ; 
           
           @endphp
                @foreach ($historial_pagos as $historial)
                @php 
                
                // pagado es === 3,4,5,6
                if( $historial->payment_status == 5 || $historial->payment_status == 6 || $historial->payment_status == 3 || $historial->payment_status == 4 ){
                    $Nr++;
                    $total_pagado += $historial->importe_couta;
                }else {

                   


                    $total_pendiente++;
                }
           
                
                @endphp
                    <tr>
                        <td>
                            {{ $historial->nro_coutas  }}
                        </td>

                        <td>
                            @if ($historial->payment_status == 2)
                                <a href="#" data-id="{{ $historial->id }}"><span data-id=" {{ $historial->id }}"
                                        title="Cambiar estatus" type="button"
                                        class="btn btn-flat mostrar_estatus_pago btn-sm btn-primary"><i
                                            class="fa fa-edit"></i></span></a>
                            @endif
                            @if ($historial->payment_status == 2 || $historial->payment_status == 5   || $historial->payment_status == 6 || $historial->payment_status == 3 || $historial->payment_status == 4)
                                <a href="#" onclick="obtener_detalle_pago({{ $historial->id }})"><span
                                        title="Detalle del pago" type="button"
                                        class="btn btn-flat btn-sm btn-success"><i class="fas fa-search"></i></span></a>
                            @endif
                            @if ($historial->payment_status != 2 &&  $historial->payment_status != 5 && $historial->payment_status != 6 && $historial->payment_status != 3 && $historial->payment_status != 4)
                                <a class="btn btn-flat btn-sm btn-info" href='{!! sc_route_admin(
                                    'historial_pagos.reportar',
                                    ['id' => $order->id, 'id_pago' => $historial->id],
                                    ['id_pago' => $historial->id],
                                ) !!}'><span title="Reportar pago" 
                                        ><i
                                            class=" fa fa-credit-card "></i></span></a>   @endif
                                            @if ( $historial->payment_status != 5 && $historial->payment_status != 6 && $historial->payment_status != 3 && $historial->payment_status != 4)
                        <span onclick="deleteItemPago('{{ $historial->id }}');"  title="' .{{ sc_language_render('action.delete')  }}. '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
                            @endif
                        </td>


                        <td><span class="item_21_sku">{{ $historial->importe_couta }} $</span></td>
                        <td><span class="item_21_sku">{{ $historial->importe_pagado }}</span></td>
                        @php
                            $tasa_cambio = $historial->tasa_cambio ? $historial->tasa_cambio : 1;
                            
                        @endphp
                        <td><span class="item_21_sku">{{ $historial->moneda }}</span></td>

                        <td>
                            @if ($historial->moneda == 'USD')
                                <span class="item_21_sku">{!! floor($historial->importe_pagado * $tasa_cambio) !!} bs</span>
                            @else
                                <span class="item_21_sku">{!! floor($historial->importe_pagado / $tasa_cambio) !!} $</span>
                            @endif
                        </td>

                        <td><span class="item_21_sku">{!!  $styleStatusPayment[$historial->payment_status] ?? $historial->estatus->name !!}

                                <br>
                                <small>
                                    @if ($historial->referencia != '')
                                        {{ $historial->referencia }}
                                    @endif - {!! isset($historial->metodo_pago->name) ? $historial->metodo_pago->name : '' !!}
                                </small>
                            </span></td>

                        <td><span class="item_21_sku">{!! fecha_europea($historial->fecha_venciento) !!}</span></td>
                        
                        <td><span class="item_21_sku">{!! fecha_europea($historial->comment) !!} / {!! fecha_europea($historial->observacion) !!}</span></td>

                    </tr>
                @endforeach
                <tr>
<td></td>
                    <th  colspan="1">
                    Total   Pagado
                    </th>
                    <th>
                        <span class="item_21_sku">{{ $total_pagado }}$</span>
                    </th>
                    <th>
                        Cuotas Pendiente: {!!floor( $total_pendiente )!!}
                        
                    </th>
                   
                    <th>
                        <span class="item_21_sku">Por Pagar: {!! floor($order->total - $total_pagado )!!}$</span>
                        <br>
                    </th>
                </tr>
            </tbody>
        </table>

    </div>
</div>
