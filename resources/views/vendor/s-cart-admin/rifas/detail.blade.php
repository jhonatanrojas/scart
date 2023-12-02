@extends($templatePathAdmin . 'layout')

@section('main')
    <div class="row" id="order-body">
        <div class="col-sm-6">
            <table class="table table-bordered">



                <tr>
                    <th> Nombre Sorteo</th>
                    <td>
                        {{ $rifa->nombre_solteo }}

                    </td>
                </tr>

                <tr>
                    <th> Premio</th>
                    <td>
                        {{ $rifa->premio }}

                    </td>
                </tr>
                <tr>
                    <th> Lugar sorteo</th>
                    <td>
                        {{ $rifa->lugar_solteo }}

                    </td>
                </tr>
                <tr>
                    <th> Fecha sorteo</th>
                    <td>
                        {{ $rifa->fecha_solteo }}

                    </td>
                </tr>
                <tr>
                    <th> Total numeros </th>
                    <td>
                        {{ $rifa->total_numeros }}

                    </td>


                </tr>



                <tr>
                    <td>Fecha de Creación :</td>
                    <td>{{ $rifa->created_at }}</td>
                </tr>

                <tr>
                    <th>Total vendidos:</th>
                    <td>{{ count($rifas) }}</td>
                </tr>

            </table>
        </div>



    </div>


    <div class="card-header with-border">
        <div class="card-tools">
            <div class="menu-right">
                <a href="{{ route('rifa.nueva_rifa', ['id' => $id]) }}" class="btn  btn-success  btn-flat"
                    title="Crear rifa Cliente" id="button_create_new">
                    <i class="fa fa-plus" title="Añadir nueva"></i>
                </a>

            </div>

        </div>


        <div class="float-left">

            <div class="menu-left">
                <span class="btn btn-flat btn-primary grid-refresh" title="Actualizar"><i
                        class="fas fa-sync-alt"></i></span>
            </div>



            <div class="menu-left">
                <div class="input-group float-right ml-1" style="width: 350px;">
                    <div class="btn-group">
                        <select class="form-control rounded-0 float-right" id="order_sort">

                        </select>
                    </div>
                    <div class="input-group-append">

                        <button id="button_sort" type="submit" class="btn btn-primary"><i
                                class="fas fa-sort-amount-down-alt"></i></button>
                    </div>


                </div>




            </div>


        </div>



    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Acciones</th>
                <th scope="col">Numero de la rifa</th>
                <th scope="col">Nombre cliente</th>
                <th scope="col">Telefono</th>
                <th scope="col">Cedula</th>
                <th scope="col">Email</th>
                <th scope="col">Nro de Referencia</th>
                <th scope="col">Codigo Banco</th>
                <th scope="col">Vendedor</th>

            </tr>
        </thead>
        <tbody>


            @foreach ($rifas as $rif)
                @php

                    $relleno = '0';
                    $numero = str_pad($rif->numero_rifa, 3, $relleno, STR_PAD_LEFT);
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('rifa.editRifaCliente', ['id_cliente' => $rif->id, 'id' => $id]) }}"><span
                                title="Editar" type="button" class="btn btn-flat btn-sm btn-primary"><i
                                    class="fa fa-edit"></i></span></a>
                        <a class="btn btn-info" target="_blank"
                            href="{{ route('rifa.pdf', ['id' => $rifa->id, 'numero_rifa' => $rif->numero_rifa]) }}">Descargar
                            Recibo</a>

                    </td>
                    <th scope="row">{{ str_pad($numero, 3) }}</th>
                    <td>{{ $rif->nombre_cliente }}</td>
                    <td>{{ $rif->telefono }}</td>
                    <td>{{ $rif->cedula }}</td>
                    <td>{{ $rif->email }}</td>
                    <td>{{ $rif->nro_referencia }}</td>
                    <td>{{ $rif->codigo_banco }}</td>
                    <td>{{ $rif->vendedor }}</td>

                </tr>
            @endforeach



        </tbody>
    </table>
@endsection
