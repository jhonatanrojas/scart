@extends($templatePathAdmin . 'layout')




@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header with-border">

                    <div class="card-tools">

                    </div>
                    <div class="float-left">
                        <a class=" btn btn-info"
                            href="{{ sc_route_admin('admin_order.detail', ['id' => $order->id ? $order->id : 'not-found-id']) }}">Regresar
                            a la Solicitud </a>

                        <!-- /.box-tools -->
                    </div>

                    <div class="card-header with-border">


                        <div class="float-left">
                            @if (!empty($removeList))
                                <div class="menu-left">
                                    <button type="button" class="btn btn-default grid-select-all"><i
                                            class="far fa-square"></i></button>
                                </div>
                                <div class="menu-left">
                                    <span class="btn btn-flat btn-danger grid-trash"
                                        title="{{ sc_language_render('action.delete') }}"><i
                                            class="fas fa-trash-alt"></i></span>
                                </div>
                            @endif

                            @if (!empty($buttonRefresh))
                                <div class="menu-left">
                                    <span class="btn btn-flat btn-primary grid-refresh"
                                        title="{{ sc_language_render('action.refresh') }}"><i
                                            class="fas fa-sync-alt"></i></span>
                                </div>
                            @endif


                            @if (!empty($menuLeft) && count($menuLeft))
                                @foreach ($menuLeft as $item)
                                    <div class="menu-left">
                                        @php
                                            $arrCheck = explode('view::', $item);
                                        @endphp
                                        @if (count($arrCheck) == 2)
                                            @if (view()->exists($arrCheck[1]))
                                                @include($arrCheck[1])
                                            @endif
                                        @else
                                            {!! trim($item) !!}
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>

                    </div>

                    <!-- Modal -->


                    <!-- /.card-header -->
                    <div class="card-body p-0" id="pjax-container">
                        @php
                            $urlSort = $urlSort ?? '';
                        @endphp
                        <div id="url-sort" data-urlsort="{!! strpos($urlSort, '?') ? $urlSort . '&' : $urlSort . '?' !!}" style="display: none;"></div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box collapsed-box">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th> Numero de orden: {{ $order->id }}</th>
                                            </thead>
                                            <thead>

                                                <tr>
                                                    <th> Producto</th>
                                                    <th class="product_price">{{ sc_language_render('product.price') }}</th>
                                                    <th class="product_qty">{{ sc_language_render('product.quantity') }}
                                                    </th>
                                                    <th class="product_total">
                                                        {{ sc_language_render('order.totals.sub_total') }}</th>
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
                                                                        $html .= '<br><b>0</b> : <i>' . $element . '</i>';
                                                                    }
                                                                }
                                                            @endphp
                                                            {!! $html !!}
                                                        </td>

                                                        <td class="product_price">{{ $item->price }}</td>
                                                        <td class="product_qty"> {{ $item->qty }}</td>
                                                        <td class="product_total item_id_{{ $item->id }}">
                                                            {{ sc_currency_render_symbol($item->total_price, $order->currency) }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <input type="hidden" id="id_importe_couta" name="" value="{!! $historial_pago->importe_couta ?? 0 !!}">
                        <div class="card">
                            <form action="{{ route('historial_pagos.postreportar') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <h5 class="card-header">{{ $title }}</h5>
                                <div class="card-body">
                                    <div class="form-group col-md-12">
                                        @if ($historial_pago)
                                            <h5 class="text-center"> Monto cuota: {{ $historial_pago->importe_couta }}$
                                                <br> <small> Vence:
                                                    {{ date('d-m-Y', strtotime($historial_pago->fecha_venciento)) }}</small>
                                            </h5>
                                        @endif
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="forma_pago">Forma de pago</label>
                                            <select id="forma_pago" name="forma_pago" required class="form-control">
                                                @foreach ($metodos_pagos as $metodo)
                                                    <option value="{{ $metodo->id }}" {!! $metodo->id == '4' ? 'selected' : '' !!}>
                                                        {{ $metodo->name }}</option>
                                                @endforeach;
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Nro de referencia</label>
                                            <input type="text" class="form-control" required name="referencia"
                                                id="referencia" placeholder="referencia">
                                        </div>
                                        @error('referencia')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Fecha de pago</label>
                                            <input type="date" class="form-control" required
                                                value="{!! date('Y-m-d') !!}" name="fecha" id="fecha"
                                                placeholder="referencia">
                                        </div>



                                    </div>


                                    <div class="row ">

                                        <div class="col-md-4 bloque-pagomovil">
                                            <label for="telefono_origen">Telefono del Pagador</label>
                                            <input type="text" class="form-control"  name="telefono_origen"
                                                id="telefono_origen" placeholder="telefono">
                                            @error('telefono_origen')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 bloque-pagomovil">
                                            <label for="inputEmail4">Cedula del Pagador </label>
                                            <div class="input-group mb-3">

                                                <select name="nacionalidad" id="nacionalidad" class=""
                                                    style="   
                                                          width:100px;
                                                          font-size: 1rem;
                                                          font-weight: 400;
                                                          line-height: 1.5; 
                                                          color: #212529;
                                                          background-color: #fff;
                                                          background-clip: padding-box;
                                                          border: 1px solid #ced4da;">
                                                    <option class="V">V</option>
                                                    <option class="J">J</option>
                                                </select>
                                                <input type="text" class="form-control"  name="cedula_origen"
                                                    id="cedula_origen" placeholder="Cedula">
                                            </div>


                                            @error('referencia')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 bloque-pagomovil">
                                            <label for="codigo_banco">Banco de Origen</label>
                                            <select id="codigo_banco" class="form-control"  name="codigo_banco">
                                                @foreach ($bancos as $banco)
                                                    <option value="{{ $banco->codigo }}">{{ $banco->nombre }}</option>
                                                @endforeach

                                            </select>
                                            @error('codigo_banco')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="forma_pago">Divisa</label>
                                            <select id="divisa" class="form-control" required name="moneda">
                                                @foreach (sc_currency_all() as $moneda)
                                                    <option value="{{ $moneda->code }}" {!! $moneda->code == 'USD' ? 'selected' : '' !!}
                                                        data-exchange_rate="{{ $moneda->exchange_rate }}">
                                                        {{ $moneda->code }}</option>
                                                @endforeach


                                            </select>
                                            @error('moneda')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="forma_pago">Monto</label>
                                            <input step="any" type="number" required class="form-control"
                                                name="monto" id="monto" placeholder="Monto"
                                                value="{!! $historial_pago->importe_couta ?? 0 !!}">
                                            <small id="error_monto" style="color: red; display: none;">Por favor ingrese
                                                solo números y un punto decimal.</small>
                                            @error('monto')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>






                                        <div class="form-group col-md-3">
                                            <label for="forma_pago">Tasa de cambio</label>
                                            <input step="any" type="number" id="tipo_cambio" class="form-control"
                                                required name="tipo_cambio" value="{!! sc_currency_all()[0]->exchange_rate !!}">

                                            @error('tipo_cambio')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="statusPayment">Estatus de pago</label>
                                            <select id="statusPayment" name="statusPayment" required
                                                class="form-control">
                                                @foreach ($statusPayment as $pago)
                                                    <option value="{{ $pago->id }}">{{ $pago->name }}</option>
                                                @endforeach;
                                            </select>
                                        </div>



                                        <div class="form-group col-md-6">

                                            <label for="forma_pago">Adjunta referencia</label>
                                            <input type="file" class="form-control-file" id="capture"
                                                name="capture">
                                            @error('capture')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="forma_pago">Observación</label>
                                            <input type="text" class="form-control" id="observacion"
                                                name="observacion" required="">

                                        </div>
                                    </div>



                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="id_pago" value="{{ $id_pago }}">
                                    <input type="hidden" name="id_detalle_orden"
                                        value="{{ isset($order->details[0]) ? $order->details[0]->id : 0 }}">
                                    <input type="hidden" name="product_id"
                                        value="{{ isset($order->details[0]) ? $order->details[0]->product_id : 0 }}">




                                    <div class="buttons d-flex justify-content-around">
                                        <button type="submit" class="btn btn-primary mr-10">Reportar</button>
                                    </div>


                                </div>
                            </form>
                        </div>



                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            @if (!empty($blockBottom) && count($blockBottom))
                                @foreach ($blockBottom as $item)
                                    <div class="clearfix">
                                        @php
                                            $arrCheck = explode('view::', $item);
                                        @endphp
                                        @if (count($arrCheck) == 2)
                                            @if (view()->exists($arrCheck[1]))
                                                @include($arrCheck[1])
                                            @endif
                                        @else
                                            {!! trim($item) !!}
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>


                    </div>
                    <!-- /.card -->
                </div>
            </div>

        @endsection


        @push('styles')
            {!! $css ?? '' !!}
        @endpush

        @push('scripts')
            {{-- //Pjax --}}
            <script src="{{ sc_file('admin/plugin/jquery.pjax.js') }}"></script>

            <script type="text/javascript">
                $("#forma_pago").change(function() {

                    if ($(this).val() == 4) {
                        $(".bloque-pagomovil").css('display', 'block')
                    } else {
                        $(".bloque-pagomovil").css('display', 'none')
                    }


                });

                function soloNumeros(event) {
                    var charCode = event.keyCode;
                    if (charCode == 46) { // permitir el punto decimal
                        return true;
                    } else if (charCode > 31 && (charCode < 48 || charCode > 57)) { // permitir solo números
                        document.getElementById("error_monto").style.display = "inline";
                        return false;
                    } else {
                        document.getElementById("error_monto").style.display = "none";
                        return true;
                    }
                }


                $("#divisa").change(function() {
                    const tipo_cambio = $(this).find(':selected').attr('data-exchange_rate');
                    $("#tipo_cambio").val(tipo_cambio)
                    let importe_couta = parseFloat($("#id_importe_couta").val())
                    const moneda = $(this).val();
                    if (moneda == 'Bs') {
                        importe_couta = parseFloat(importe_couta * tipo_cambio).toFixed(2)

                    }
                    $("#monto").val(importe_couta)

                });

                $('.mostrar_estatus_pago').click(function() {
                    $("#modal_estatus_pago").modal('show');

                    $("#id_pago").val($(this).data('id'))


                });

                $('.grid-refresh').click(function() {
                    $.pjax.reload({
                        container: '#pjax-container'
                    });
                });

                $(document).on('submit', '#button_search', function(event) {
                    $.pjax.submit(event, '#pjax-container')
                })

                $(document).on('pjax:send', function() {
                    $('#loading').show()
                })
                $(document).on('pjax:complete', function() {
                    $('#loading').hide()
                })

                // tag a
                $(function() {
                    $(document).pjax('a.page-link', '#pjax-container')
                })


                $(document).ready(function() {
                    // does current browser support PJAX
                    if ($.support.pjax) {
                        $.pjax.defaults.timeout = 2000; // time in milliseconds
                    }
                });

                @if ($buttonSort)
                    $('#button_sort').click(function(event) {
                        var url = $('#url-sort').data('urlsort') + 'sort_order=' + $('#order_sort option:selected').val();
                        $.pjax({
                            url: url,
                            container: '#pjax-container'
                        })
                    });
                @endif
            </script>
            {{-- //End pjax --}}


            <script type="text/javascript">
                {{-- sweetalert2 --}}
                var selectedRows = function() {
                    var selected = [];
                    $('.grid-row-checkbox:checked').each(function() {
                        selected.push($(this).data('id'));
                    });

                    return selected;
                }

                $('.grid-trash').on('click', function() {
                    var ids = selectedRows().join();
                    deleteItem(ids);
                });

                function deleteItem(ids) {
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
                                    method: 'post',
                                    url: '{{ $urlDeleteItem ?? '' }}',
                                    data: {
                                        ids: ids,
                                        _token: '{{ csrf_token() }}',
                                    },
                                    success: function(data) {
                                        if (data.error == 1) {
                                            alertMsg('error', data.msg,
                                                '{{ sc_language_render('action.warning') }}');
                                            $.pjax.reload('#pjax-container');
                                            return;
                                        } else {
                                            alertMsg('success', data.msg);
                                            $.pjax.reload('#pjax-container');
                                            resolve(data);
                                        }

                                    }
                                });
                            });
                        }

                    }).then((result) => {
                        if (result.value) {
                            alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}',
                                '{{ sc_language_render('action.delete_confirm_deleted') }}');
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


                function cloneProduct(id) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true,
                    }).fire({
                        title: '{{ sc_language_render('product.admin.clone_confirm') }}',
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
                                    method: 'post',
                                    url: '{{ sc_route_admin('admin_product.clone') }}',
                                    data: {
                                        pId: id,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(data) {
                                        if (data.error == 1) {
                                            alertMsg('error', data.msg,
                                                '{{ sc_language_render('action.warning') }}');
                                            $.pjax.reload('#pjax-container');
                                            return;
                                        } else {
                                            alertMsg('success', data.msg);
                                            $.pjax.reload('#pjax-container');
                                            resolve(data);
                                        }

                                    }
                                });
                            });
                        }

                    }).then((result) => {
                        if (result.value) {
                            alertMsg('success', '{{ sc_language_render('product.admin.clone_success') }}', '');
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

                {{-- / sweetalert2 --}}
            </script>

            {!! $js ?? '' !!}
        @endpush
