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
                            <a href="{{ sc_route_admin('rifa.detail',['id'=>$id_rifa]) }}" class="btn  btn-flat btn-default"
                                title="List"><i class="fa fa-list"></i><span class="hidden-xs">
                                    {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">


                    <form action="{{ route('rifa.postCreateCliente') }}" method="post" accept-charset="UTF-8"
                        class="form-horizontal" id="form-main">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('nombre_cliente') ? ' text-red' : '' }}">
                                    <label for="nombre_cliente" class="col-sm-4 col-form-label">Nombre de Cliente </label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="nombre_cliente" name="nombre_cliente"
                                            value="{{ old('nombre_cliente') }}" class="form-control nombre_cliente "
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('nombre_cliente'))
                                        <span class="text-sm">
                                            {{ $errors->first('nombre_cliente') }}
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group  {{ $errors->has('cedula') ? ' text-red' : '' }}">
                                    <label for="last_name" class="col-sm-2 col-form-label">cedula</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}"
                                            class="form-control cedula" placeholder="" />
                                    </div>
                                    @if ($errors->has('cedula'))
                                        <span class="text-sm">
                                            {{ $errors->first('cedula') }}
                                        </span>
                                    @endif

                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="id_rifa" id="id_rifa" value="{{ $id_rifa }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('telefono') ? ' text-red' : '' }}" id="telefono">
                                    <label for="telefono" class="col-form-label">Telefono</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        </div>
                                        <input type="number" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                            class="form-control email" placeholder="" />
                                    </div>
                                    @if ($errors->has('telefono'))
                                        <span class="text-sm">
                                            {{ $errors->first('telefono') }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group   {{ $errors->has('numero_rifa') ? ' text-red' : '' }}">
                                    <label for="numero_rifa" class=" col-form-label">Numero de la rifa</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-number"></i></span>
                                        </div>
                                        <input style="width: 150px" readonly type="number" id="numero_rifa" name="numero_rifa"
                                            value="{{ old('numero_rifa') }}" class="form-control numero_rifa"
                                            placeholder="" />
                                    </div>
                                    @if ($errors->has('numero_rifa'))
                                        <span class="text-sm">
                                            {{ $errors->first('numero_rifa') }}
                                        </span>
                                    @endif

                                </div>


                            </div>

                            <div class="col-md-6">

                                <div class="form-group   {{ $errors->has('email') ? ' text-red' : '' }}">
                                    <label for="fecha_solteo" class=" col-form-label">Email</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                        </div>
                                        <input style="width: 150px" type="email" id="email" name="email"
                                            value="{{ old('email') }}" class="form-control email" placeholder="" />
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="text-sm">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif

                                </div>


                            </div>
                            <div class="col-md-6">

                                <div class="form-group   {{ $errors->has('forma_pago_id') ? ' text-red' : '' }}">
                                    <label for="forma_pago_id" class=" col-form-label">Modalidad de Pago</label>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                                        </div>


                                        <select name="forma_pago_id" class="form-control" id="forma_pago_id">
                                            @foreach ($modalidad as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach



                                        </select>


                                    </div>
                                    @if ($errors->has('forma_pago_id'))
                                        <span class="text-sm">
                                            {{ $errors->first('forma_pago_id') }}
                                        </span>
                                    @endif

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
    <style>
        .number-table {
            margin-top: 20px;
        }

        .number-cell {
            width: 60px;
            height: 60px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
            line-height: 60px;
            font-size: 20px;
            transition: background-color 0.3s;
        }

        .number-cell:hover {
            background-color: #28a745; /* Color verde para el efecto hover */
            color: white; /* Color blanco para el texto durante el hover */
            cursor: pointer; /* Cambia el cursor a un puntero para indicar que es interactivo */
        }
        .highlight {
            background-color: #a72828;
            /* Un tono de verde de Bootstrap 4 */
            color: white;
            /* Texto blanco para mejor contraste */
        }

        .selected {
            background-color: #28a745; /* Un tono de verde de Bootstrap 4 */
            color: white; /* Texto blanco para mejor contraste */
        }
    </style>
    <div class="container">
        <table class="table number-table"> 
            <?php
            $num_rows = $rifa->total_numeros /10; 
         
            for ($row = 1; $row <= $num_rows; $row++) {
                echo '<tr>';
                for ($col = 1; $col <= 10; $col++) {
                    $number = ($row - 1) * 10 + $col;
                    $relleno = "0";
                    $numero =str_pad($number, 3, $relleno, STR_PAD_LEFT);
                    $class =  in_array($number,$rifas) ? 'highlight' : ''; 

                    echo "<td class='number-cell $class'>". $numero."</td>";
                    if($number==$num_rows){
               
                        break;
                    }
                }
                echo '</tr>';

                if($row==$num_rows){
                        
                        break;
                    }
            }
        
            ?>
        </table>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script type="text/javascript">

$(document).ready(function() {
    
            $('.number-cell').click(function() {
                // Remover la clase 'selected' de cualquier celda que la tenga
                if (!$(this).hasClass('highlight')) {
                $('.number-cell.selected').removeClass('selected');
                // Agregar la clase 'selected' a la celda clickeada
                $(this).addClass('selected');
                // Actualizar el valor del input con el número de la celda seleccionada
                $('#numero_rifa').val($(this).text());

                }
            });
        });
      


    </script>

    <script src="{{ asset('/js/crear_tarjeta.js') }}"></script>
@endpush
