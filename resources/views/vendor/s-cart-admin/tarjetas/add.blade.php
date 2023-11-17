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
                <form action="{{ sc_route_admin('tarjetas.postCreate') }}" method="post" accept-charset="UTF-8"
                    class="form-horizontal" id="form-main">

                    <div class="card-body">

                        <div class="form-group row {{ $errors->has('customer_id') ? ' text-red' : '' }}">
                            <label for="customer_id"
                                class="col-sm-2 asterisk col-form-label">{{ sc_language_render('order.admin.select_customer') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control customer_id select2" style="width: 100%;" name="customer_id">
                                    <option value="">Buscar por nombre o cedula </option>
                                    @foreach ($users as $k => $v)
                                        <option value="{{ $k }}" {{ old('customer_id') == $k ? 'selected' : '' }}>
                                            {{ $v->name . $v->cedula }}</option>
                                    @endforeach
                                </select>


                                @if ($errors->has('customer_id'))
                                    <span class="text-sm">
                                        {{ $errors->first('customer_id') }}
                                    </span>
                                @endif
                            </div>
                            <div class="input-group-append">
                                <a href="{{ sc_route_admin('admin_customer.index') }}"><button type="button"
                                        id="button-filter" class="btn btn-success  btn-flat"><i class="fa fa-plus"
                                            title="Add new"></i></button></a>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('first_name') ? ' text-red' : '' }}">
                                    <label for="first_name"
                                        class="col-sm-2 col-form-label">{{ sc_language_render('order.first_name') }}</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input readonly type="text" id="first_name" name="first_name"
                                            value="{{ old('first_name') }}" class="form-control first_name"
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('first_name'))
                                        <span class="text-sm">
                                            {{ $errors->first('first_name') }}
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-6">

                                @if (sc_config_admin('customer_lastname'))
                                    <div class="form-group  {{ $errors->has('last_name') ? ' text-red' : '' }}">
                                        <label for="last_name"
                                            class="col-sm-2 col-form-label">{{ sc_language_render('order.last_name') }}</label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input readonly type="text" id="last_name" name="last_name"
                                                value="{{ old('last_name') }}" class="form-control last_name"
                                                placeholder="" />
                                        </div>
                                        @if ($errors->has('last_name'))
                                            <span class="text-sm">
                                                {{ $errors->first('last_name') }}
                                            </span>
                                        @endif

                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('email') ? ' text-red' : '' }}" id="email">
                                    <label for="email"
                                        class="col-form-label">{{ sc_language_render('order.email') }}</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="form-control email" placeholder="" />
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="text-sm">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                            <div class="col-md-6">

                                @if (sc_config_admin('customer_phone'))
                                    <div class="form-group   {{ $errors->has('phone') ? ' text-red' : '' }}">
                                        <label for="phone"
                                            class="col-sm-2 col-form-label">{{ sc_language_render('order.phone') }}</label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone fa-fw"></i></span>
                                            </div>
                                            <input readonly style="width: 150px" type="text" id="phone"
                                                name="phone" value="{{ old('phone') }}" class="form-control phone"
                                                placeholder="Input Phone" />
                                        </div>
                                        @if ($errors->has('phone'))
                                            <span class="text-sm">
                                                {{ $errors->first('phone') }}
                                            </span>
                                        @endif

                                    </div>
                                @endif

                            </div>

                        </div>



                        @if (sc_config_admin('customer_name_kana'))
                            <div class="form-group  {{ $errors->has('first_name_kana') ? ' text-red' : '' }}">
                                <label for="first_name_kana"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('order.first_name_kana') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="first_name_kana" name="first_name_kana"
                                            value="{{ old('first_name_kana') }}" class="form-control first_name_kana"
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('first_name_kana'))
                                        <span class="text-sm">
                                            {{ $errors->first('first_name_kana') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('last_name_kana') ? ' text-red' : '' }}">
                                <label for="last_name_kana"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('order.last_name_kana') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="last_name_kana" name="last_name_kana"
                                            value="{{ old('last_name_kana') }}" class="form-control last_name_kana"
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('last_name_kana'))
                                        <span class="text-sm">
                                            {{ $errors->first('last_name_kana') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif








                        <link href="{{ asset('css/crear_tarjeta.css') }}" rel="stylesheet">





                        <hr>

                        <h5 class="text-center"> Datos de la tarjeta</h5>

                        <div class="row">
                            <div class="col-md-6">


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="tipoTajeta">Tipo Tarjeta</label>
                                            <select id="tipoTajeta" class="form-control" name="tipoTajeta">
                                                @foreach ($tipoTarjeta as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('nro_tarjeta') ? ' text-red' : '' }}">
                                            <label for="cardnumber">Numero de la tarjeta</label>

                                            <input type="text" name="nro_tarjeta"  id="cardnumber" class="form-control" pattern="[0-9]*"
                                                inputmode="numeric" placeholder="Numero de tarjeta" value="{{ old('nro_tarjeta') }}">
                                            <span id="generatecard"></span>
                                            @if ($errors->has('nro_tarjeta'))
                                            <span class="text-sm">
                                                {{ $errors->first('nro_tarjeta') }}
                                            </span>
                                        @endif
                                        </div>
                                    </div>
                                    @php
                                        $fechaActual = date('Y-m-d');

                                        // Aumentar 2 año
                                        $unAnoMas = date('Y-m-d', strtotime($fechaActual . ' +2 year'));
                                        $mesAnoMas = date('m-Y', strtotime($fechaActual . ' +2 year'));

                                        $codigoSeguridad = substr(rand(),0,3 );
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('fecha_de_vencimiento') ? ' text-red' : '' }}">
                                            <label for="cardnumber">Fecha de expiracion (yy/mm)</label>
                                            <input id="expirationdate" value="{{ old('fecha_de_vencimiento',  $unAnoMas) }}" type="date"
                                         
                                                pattern="[0-9]*" class="form-control" name="fecha_de_vencimiento">
                                                @if ($errors->has('fecha_de_vencimiento'))
                                                <span class="text-sm">
                                                    {{ $errors->first('fecha_de_vencimiento') }}
                                                </span>
                                            @endif

                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('codigo_seguridad') ? ' text-red' : '' }}">
                                            <label for="cardnumber">codigo de seguridad</label>
                                            <input id="securitycode" class="form-control" type="text" name="codigo_seguridad"
                                                pattern="[0-9]*" inputmode="numeric" value="{{ old('codigo_seguridad',  $codigoSeguridad) }}">

                                        </div>
                                    </div>

                                    @foreach ($modalidadVentas as $modalidad)
                           

                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="cardnumber">Limite en {{ $modalidad->descripcion }}</label>
                                          <input type="hidden" name="id_modalidad[]" value="{{$modalidad->id}}">
                                          <input id="code{{ $modalidad->id }}" name="valor_tarjeta[]" class="form-control" type="number" value="0"

                                      >

                                      </div>
                                  </div>
                                  @endforeach

                                    



                                </div>



                            </div>
                            <div class="col-md-6">

                                <div class=" container preload">
                                    <div class="creditcard">
                                        <div class="front">
                                            <div id="ccsingle"></div>
                                            <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;"
                                                xml:space="preserve">
                                                <g id="Front">
                                                    <g id="CardBackground">
                                                        <g id="Page-1_1_">
                                                            <g id="amex_1_">
                                                                <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                        C0,17.9,17.9,0,40,0z" />
                                                            </g>
                                                        </g>
                                                        <path class="darkcolor greydark"
                                                            d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                                                    </g>
                                                    <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber"
                                                        class="st2 st3 st4">0123 4567 8910 1112</text>
                                                    <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname"
                                                        class="st2 st5 st6">JOHN DOE</text>
                                                    <text transform="matrix(1 0 0 1 54.1074 389.8793)"
                                                        class="st7 st5 st8">Nombre</text>
                                                    <text transform="matrix(1 0 0 1 479.7754 388.8793)"
                                                        class="st7 st5 st8">vence</text>
                                                    <text transform="matrix(1 0 0 1 65.1054 241.5)"
                                                        class="st7 st5 st8">Numero de tarjeta</text>
                                                    <g>
                                                        <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire"
                                                            class="st2 st5 st9"><?php  echo $mesAnoMas ?></text>
                                                        <text transform="matrix(1 0 0 1 479.3848 417.0097)"
                                                            class="st2 st10 st11">VALID</text>
                                                        <text transform="matrix(1 0 0 1 479.3848 435.6762)"
                                                            class="st2 st10 st11">THRU</text>
                                                        <polygon class="st2"
                                                            points="554.5,421 540.4,414.2 540.4,427.9 		" />
                                                    </g>
                                                    <g id="cchip">
                                                        <g>
                                                            <path class="st2"
                                                                d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                                                    c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <rect x="82" y="70" class="st12" width="1.5"
                                                                    height="60" />
                                                            </g>
                                                            <g>
                                                                <rect x="167.4" y="70" class="st12" width="1.5"
                                                                    height="60" />
                                                            </g>
                                                            <g>
                                                                <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                                                        c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                                                        C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                                                        c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                                                        c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                                            </g>
                                                            <g>
                                                                <rect x="82.8" y="82.1" class="st12" width="25.8"
                                                                    height="1.5" />
                                                            </g>
                                                            <g>
                                                                <rect x="82.8" y="117.9" class="st12" width="26.1"
                                                                    height="1.5" />
                                                            </g>
                                                            <g>
                                                                <rect x="142.4" y="82.1" class="st12" width="25.8"
                                                                    height="1.5" />
                                                            </g>
                                                            <g>
                                                                <rect x="142" y="117.9" class="st12" width="26.2"
                                                                    height="1.5" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                                <g id="Back">
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="back">
                                            <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;"
                                                xml:space="preserve">
                                                <g id="Front">
                                                    <line class="st0" x1="35.3" y1="10.4" x2="36.7"
                                                        y2="11" />
                                                </g>
                                                <g id="Back">
                                                    <g id="Page-1_2_">
                                                        <g id="amex_2_">
                                                            <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                    C0,17.9,17.9,0,40,0z" />
                                                        </g>
                                                    </g>
                                                    <rect y="61.6" class="st2" width="750" height="78" />
                                                    <g>
                                                        <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                                                C707.1,246.4,704.4,249.1,701.1,249.1z" />
                                                        <rect x="42.9" y="198.6" class="st4" width="664.1"
                                                            height="10.5" />
                                                        <rect x="42.9" y="224.5" class="st4" width="664.1"
                                                            height="10.5" />
                                                        <path class="st5"
                                                            d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
                                                    </g>
                                                    <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity"
                                                        class="st6 st7"><?php echo $codigoSeguridad?></text>
                                                    <g class="st8">
                                                        <text transform="matrix(1 0 0 1 518.083 280.0879)"
                                                            class="st9 st6 st10">Codigo de Seguridad</text>
                                                    </g>
                                                    <rect x="58.1" y="378.6" class="st11" width="375.5"
                                                        height="13.5" />
                                                    <rect x="58.1" y="405.6" class="st11" width="421.7"
                                                        height="13.5" />
                                                
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
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
                                <button type="submit"
                                    class="btn btn-primary">Guardar</button>
                            </div>

                            <div class="btn-group float-left">
                                <button type="reset"
                                    class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-footer -->
                </form>

                <div class="table-responsive tabla-solicitudes">


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
                        let nombreCompleto =returnedData.first_name + " "+returnedData.last_name;
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
