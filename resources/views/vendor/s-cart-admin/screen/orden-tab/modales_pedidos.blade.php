
<!-- Modal -->
<div class="modal fade" id="modalNuevoRecibo" tabindex="-1" aria-labelledby="modalNuevoReciboLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNuevoReciboLabel">Nuevo Recibo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="" class="form-label">Nro de Couta</label>
          <input type="text" name="nro_couta" id="nro_couta_modal" class="form-control" placeholder="" aria-describedby="helpId">
          <small id="helpId" class="text-muted">Ingrese el numero de cuota</small>
        </div>

      
        <div class="mb-3">
          <label for="" class="form-label">Monto</label>
          <input type="text" name="monto_couta" id="monto_couta_modal" class="form-control" placeholder="" aria-describedby="helpId">
          <small id="helpId" class="text-muted">Monto de la cuota</small>
        </div>
    
        <div class="mb-3">
          <label for="" class="form-label">Fecha de vencimiento</label>
          <input type="date" name="fecha_vencimiento" id="fecha_vencimiento_modal" class="form-control" placeholder="" aria-describedby="helpId">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">salir</button>
        <button type="button" class="btn btn-primary" onclick="crear_recibo()" >Guardar</button>
      </div>
    </div>
  </div>
</div>



<!--Modal convenio-->
<div class="modal fade mt-3" id="modal_convenio" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{!! sc_route('crear_convenio') !!}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>

            </div>
            <div class="modal-body">

                
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
                                <input readonly value="{!! count($order->details) ? $order->details[0]->price : 0 !!}" class="form-control   " type="text"
                                    name="_monto" id="c_monto" placeholder="monto">
                            </div>

                            <div class="row">



                                <div class="form-group col-md-6">
                                    <label for="monto">Cuotas: </label>
                                    <input readonly value="{!! count($order->details) ? $order->details[0]->nro_coutas : 0 !!}" class="form-control   "
                                        type="text" name="c_nro_coutas" id="c_nro_coutas" placeholder="_nro_cuotas">
                                </div>



                                <div class="form-group col-md-6">
                                    <label for="monto">Modalidad: </label>
                                    <input readonly value="0" class="form-control   " type="text"
                                        name="c_modalidad" id="c_modalidad" placeholder="_nro_cuotas">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="monto">Fecha de primer pago: </label>
                                    <input value="{!! count($order->details) ? $order->details[0]->nro_coutas : 0 !!}" class="form-control   " type="date"
                                        name="c_fecha_inicial" id="c_fecha_inicial" placeholder="_nro_cuotas">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="monto">Fecha de entrega: </label> 
                                    <input class="form-control   " type="date" name="fecha_maxima_entrega" required
                                        id="fecha_maxima_entrega">
                                </div>

                                 <div class="form-group col-md-6">
                                    <label for="monto">Fecha de emisión del convenio: </label> 
                                    <input class="form-control" type="date" name="fecha_primer_pago" required
                                        id="fecha_primer_pago">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="monto">Inicial $: </label>
                                    <input readonly value="0" class="form-control   " type="text"
                                        name="c_inicial" id="c_inicial" placeholder="_nro_cuotas">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nro_convenio">Numero de convenio: </label>
                                    <input class="form-control   " type="text" value="{{ $nro_convenio }}"
                                        name="nro_convenio" id="nro_convenio" placeholder="numero de convenio " required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lote">Lote: </label>
                                    <input class="form-control   " type="text" name="lote" id="lote" 
                                        placeholder="Lote ">
                                </div>
                            </div>


                            <button type="button" class=" btn btn-info" id="simular" onclick="gen_table(true)">
                                CALCULAR</button>
                        </div>
                    </div>


                    <table class="table table-striped ">

                        <tbody id="tbodyconvenio">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="butto_modal" disabled="true" type="submit" class="btn btn-primary">Crear
                    Convenio</button>
            </div>

        </div>
    </form>
    </div><!-- /.modal-content -->
</div>


<!-- Modal detaalle pago -->
<div class="modal fade" id="modal_detalle_pago" tabindex="-1" role="dialog" aria-labelledby="modal_detalle_pago"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{!! sc_route_admin('edit_pagos') !!}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle de pago <span></span> </h5>
                    <input type="hidden" name="id" id="idpago">
                    <input type="hidden" name="order_id" id="order_id">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">


                        <div class="form-group col-md-6">
                            <label for="forma_pago">Forma de pago</label>
                            <select id="mforma_pago" name="metodo_pago_id" required class="form-control">
                                @foreach ($metodos_pagos as $key => $metodo)
                                    <option {{ $metodo->id == 5 ? 'selected' : '' }} value="{{ $metodo->id }}">
                                        {{ $metodo->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Nro de referencia</label>
                            <input type="text" class="form-control" required name="mreferencia" id="mreferencia"
                                placeholder="referencia">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="monto">Fecha de pago: </label>
                            <input value="{!! date('d-m-y') !!}" class="form-control   " type="date"
                                name="fecha_pago" id="mfecha" placeholder="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Fecha de Vencimiento</label>
                            <input type="text" class="form-control" required value="" name="fecha"
                                readonly id="mvencimiento" placeholder="referencia">
                        </div>




                        <div class="form-group col-md-6">
                            <label for="forma_pago">Monto</label>
                            <input type="text" required class="form-control" id="mmonto" name="importe_pagado"
                                placeholder="Monto">

                        </div>


                        <div class="form-group col-md-6">
                            <label for="forma_pago">Divisa</label>
                            <select id="mdivisa" class="form-control" required name="moneda">
                                @foreach (sc_currency_all() as $moneda)
                                    <option value="{{ $moneda->code }}" {!! $moneda->code == 'USD' ? 'selected' : '' !!}
                                        data-exchange_rate="{{ $moneda->exchange_rate }}"> {{ $moneda->code }}</option>
                                @endforeach


                            </select>
                            @error('moneda')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>





                        <div class="form-group col-md-6">
                            <label for="forma_pago">Estatus</label>
                            <select id="mstatus" class="form-control" name="payment_status">
                                @foreach ($statusPayment as $key => $item)
                                    <option {{ $item == 5 ? 'selected' : '' }} value="{{ $key }}">
                                        {{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">



                        @if ($order->modalidad_de_compra == 1 || $order->modalidad_de_compra == 0 || $order->modalidad_de_compra == 2)
                            <div class="form-group col-md-12">

                                <label for="forma_pago"> descargar referencia </label>
                                <a target="blank" href="#" data-id="" id="dcomprobante"><span
                                        data-id=" " title="Descargar referencia" type="button"
                                        class="btn btn-flat  btn-sm btn-primary"><i class="fa fa-file"></i></span></a>
                            </div>
                        @endif



                        <div class="form-group col-md-6">

                            <label for="forma_pago">Tasa de cambio</label>
                            <input type="text" id="mtasa" class="form-control" name="tasa_cambio"
                                required="">

                        </div>
                        <div class="form-group col-md-6">

                            <label for="forma_pago">Observación</label>
                            <input type="text" id="mobservacion" class="form-control" name=""
                                required="">

                        </div>
                    </div>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>


                    <button type="submit" class="btn btn-primary">Editar</button>

                </div>
            </div>

        </form>

    </div>
</div>




<!-- Modal modal_estatus_pago -->
<div class="modal fade" id="modal_estatus_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('post_status_pago') }}" method="post">
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
                                <option value="@php echo $key @endphp  "> @php  echo $item @endphp</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <input type="text" class="form-control" id="observacion" name="observacion" required>
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
