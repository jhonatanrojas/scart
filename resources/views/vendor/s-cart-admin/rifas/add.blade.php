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
            <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description ?? '' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right" style="margin-right: 5px">
                            <a href="{{ sc_route_admin('listar_tarjetas') }}" class="btn  btn-flat btn-default"
                                title="List"><i class="fa fa-list"></i><span class="hidden-xs">
                                    {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    <form action="{{ sc_route_admin('rifa.postCreate') }}" method="post" accept-charset="UTF-8"
                        class="form-horizontal" id="form-main" enctype="multipart/form-data">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('nombre_solteo') ? ' text-red' : '' }}">
                                    <label for="nombre_solteo" class="col-sm-4 col-form-label">Nombre de Sorteo</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="nombre_solteo" name="nombre_solteo"
                                            value="{{ old('`nombre_solteo` ') }}" class="form-control nombre_solteo "
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('nombre_solteo'))
                                        <span class="text-sm">
                                            {{ $errors->first('nombre_solteo') }}
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group  {{ $errors->has('premio') ? ' text-red' : '' }}">
                                    <label for="last_name" class="col-sm-2 col-form-label">Premio</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="premio" name="premio" value="{{ old('premio') }}"
                                            class="form-control premio" placeholder="" />
                                    </div>
                                    @if ($errors->has('premio'))
                                        <span class="text-sm">
                                            {{ $errors->first('premio') }}
                                        </span>
                                    @endif

                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('lugar_solteo') ? ' text-red' : '' }}"
                                    id="lugar_solteo">
                                    <label for="lugar_solteo" class="col-form-label">Lugar Sorteo</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        </div>
                                        <input type="lugar_solteo" id="lugar_solteo" name="lugar_solteo"
                                            value="{{ old('lugar_solteo') }}" class="form-control email" placeholder="" />
                                    </div>
                                    @if ($errors->has('lugar_solteo'))
                                        <span class="text-sm">
                                            {{ $errors->first('lugar_solteo') }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group   {{ $errors->has('fecha_solteo') ? ' text-red' : '' }}">
                                    <label for="fecha_solteo" class=" col-form-label">Fecha de Sorteo</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input style="width: 150px" type="date" id="fecha_solteo" name="fecha_solteo"
                                            value="{{ old('fecha_solteo') }}" class="form-control fecha_solteo"
                                            placeholder="Input Phone" />
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="text-sm">
                                            {{ $errors->first('phone') }}
                                        </span>
                                    @endif

                                </div>


                            </div>

                            <div class="col-md-6">

                                <div class="form-group   {{ $errors->has('precio') ? ' text-red' : '' }}">
                                    <label for="fecha_solteo" class=" col-form-label">Costo de la Rifa</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                        </div>
                                        <input style="width: 150px" type="number" id="precio" name="precio"
                                            value="{{ old('precio') }}" class="form-control precio"
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('precio'))
                                        <span class="text-sm">
                                            {{ $errors->first('precio') }}
                                        </span>
                                    @endif

                                </div>


                            </div>
                            <div class="col-md-6">

                                <div class="form-group   {{ $errors->has('`total_numeros` ') ? ' text-red' : '' }}">
                                    <label for="fecha_solteo" class=" col-form-label">Total Numeros</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                                        </div>
                                        <input style="width: 150px" type="text" id="fecha_solteo" name="total_numeros"
                                            value="{{ old('total_numeros') }}" class="form-control fecha_solteo"
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('`total_numeros` '))
                                        <span class="text-sm">
                                            {{ $errors->first('`total_numeros` ') }}
                                        </span>
                                    @endif
 
                                </div>


                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Imagen de fondo del Recibo </label>
                                    <input type="file" class="form-control-file" id="ricibo" name="imagen_recibo">
                                  </div>
                            </div>

                        </div>


















                </div>
                <input type="hidden" name="currency" value="USD">

                <!-- /.card-body -->

                <div class="card-footer row">
                    @csrf
                    <div class="col-md-2">
                    </div>

                    <div class="col-md-8">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                        <div class="btn-group float-left">
                            <button type="reset"
                                class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
                        </div>
                    </div>
                </div>

                <!-- /.card-footer -->
                </form>

            </div>
        </div>
    </div>
    </div>

@endsection

@push('styles')
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        });
        $('[name="customer_id"]').change(function() {
            addInfo();
        });
        $('[name="currency"]').change(function() {
            addExchangeRate();
        });


        function addInfo() {
            id = $('[name="customer_id"]').val();
            if (id) {
                $.ajax({
                    url: '{{ sc_route_admin('admin_order.user_info') }}',
                    type: "get",
                    dateType: "application/json; charset=utf-8",
                    data: {
                        id: id
                    },
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(result) {
                        console.log(result.cliente);
                        var returnedData = result.cliente;
                        $('[name="email"]').val(returnedData.email);
                        $('[name="first_name"]').val(returnedData.first_name);
                        $('[name="last_name"]').val(returnedData.last_name);
                        $('[name="first_name_kana"]').val(returnedData.first_name_kana);
                        $('[name="last_name_kana"]').val(returnedData.last_name_kana);
                        $('[name="address1"]').val(returnedData.address1);
                        $('[name="address2"]').val(returnedData.address2);
                        $('[name="address3"]').val(returnedData.address3);
                        $('[name="phone"]').val(returnedData.phone);
                        $('[name="company"]').val(returnedData.company);
                        $('[name="postcode"]').val(returnedData.postcode);
                        $('[name="fecha"]').val(returnedData.fecha);
                        $('[name="country"]').val(returnedData.country).change();
                        $('#loading').hide();
                        let nombreCompleto = returnedData.first_name + " " + returnedData.last_name;
                        let resultNombre = nombreCompleto.substring(0, 20);

                        $('#svgname').text(resultNombre);


                        if (result.orden.length > 0) {
                            var html = `
             <table class="table table-sm">

                <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Estatus</th>
                <th scope="col">Producto</th>
                <th scope="col">nro Coutas</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Fecha</th>
                </tr>
                </thead>
            `

                            result.orden.forEach(orden => {

                                var product = ''
                                var nro_coutas = ''
                                var qty = ''
                                console.log(orden.details[0])

                                if (orden.details[0]) {
                                    product = orden.details[0].name;
                                    nro_coutas = orden.details[0].nro_coutas;
                                    qty = orden.details[0].qty;

                                }

                                html += ` <tr> 
                <td>  
                    <a href="/sc_admin/order/detail/${orden.id}" ><span title="Ir al pedido" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                    ${orden.id}</td>
                    <td>  ${orden.estatus} </td>
                <td>  ${product} </td>
                <td>  ${nro_coutas} </td>
                <td>  ${qty} </td>
                <td>  ${orden.created_at} </td>

                
                 </tr> `;



                            });


                            html += `  </table> `;

                            $('.tabla-solicitudes').html(html)

                        }


                    }
                });
            } else {
                $('#form-main').reset();
            }

        }
    </script>

    <script src="{{ asset('/js/crear_tarjeta.js') }}"></script>
@endpush
