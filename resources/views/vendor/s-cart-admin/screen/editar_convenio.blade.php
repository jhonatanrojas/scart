@extends($templatePathAdmin.'layout')


@section('main')
<div class="row">

 
    <div class="col-md-12">
        <div class="card">
            
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('create_convenio', ['id' => $id_convenio]) }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">


                <div class="card-body">

                    
                     
                        @foreach ($languages as $code => $language)

                        <div class="card">
                            <div class="card-header with-border">
                                <h3 class="card-title">Editar convenio {!! sc_image_render($language->icon,'20px','20px', ) !!}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                      <i class="fas fa-minus"></i>
                                    </button>
                                  </div>
                            </div>
                    
                            <div class="card-body">
                       

                       

                        <div
                            class="form-group row {{ $errors->has('descriptions.'.$code.'.content') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__content"
                                class="col-sm-2 col-form-label">{{ sc_language_render('admin.news.content') }}</label>
                            <div class="col-sm-8">
                                <textarea id="{{ $code }}__content" class="editor"
                                    name="descriptions[{{ $code }}][content]">

                                        {{ old('descriptions.'.$code.'.content',($borrado_html[0]['contenido']??$borrado_html->convenio)) }}

                                        

                                    </textarea>
                                @if ($errors->has('descriptions.'.$code.'.content'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('descriptions.'.$code.'.content') }}
                                </span>
                                @endif
                            </div>
                        </div>

                            </div>
                        </div>
                        @endforeach

                        




                        @if ($convenio_cliente)
                        <div class="form-group row m-auto">
                            <div class="col-sm-12">Soporte de variables:</div>
                            <div class="col-sm-8">
                                <label></label>
                                <div id="">
                                    <li ><span class="text-info">Nombre</span>:$nombre</li>
                                    <li>
                                        <span class="text-info">Apellido</span>:$apellido
                                    </li>
                                    <li>
                                        <span class="text-info">Razon Social</span>:$razon_social
                                    </li>
                                    <li>
                                        <span class="text-info">Rif</span>:$rif
                                    </li>
                                    <li>
                                    <span class="text-info">Direccion1</span>:Direccioncod_direccion
                                    </li>
                                    <li>
                                        
                                        <span class="text-info">Estado</span>:$estado
                                    </li>
                                    <li>
                                        <span class="text-info">Municipio</span>:$municipio
                                    </li>
                                    <li>
                                        <span class="text-info">Parroquia</span>:$parroquia
                                    </li>
                                    <li>
                                        <span class="text-info">Cedula</span>:$cedula
                                    </li>
                                    <li>
                                        <span class="text-info">Estado civil</span>:$estado_civil
                                    </li>
                                    <li>
                                        <span class="text-info">Nacionalida</span>:$nacionalidad
                                    </li>
                                    <li>
                                        <span class="text-info">Modalida de pago (quinsenal /mensual)</span>:$modalidad_pago
                                    </li>
                                    <li>
                                        <span class="text-info">Dia de la modalida de pago </span>: $dia_modalida_pago
                                    </li>
                                    <li>
                                        <span class="text-info">Numero de cuotas</span>: $cuotas
                                    </li>
                                    <li>
                                        <span class="text-info">Total de la cuotas en numero</span>:$cuotas_total
                                    </li>
                                    <li>
                                        <span class="text-info">Total de la cuotas en texto</span> :
                                        $cuotas_entre_precio_text
                                    </li>
                                    <li>
                                        $cod_mespago
                                    </li>
                                    <li>
                                        <span class="text-info">Fecha de entrega</span>:$fecha_entrega
                                    </li>
                                    <li>
                                        <span class="text-info">Precio total del producto</span>:$subtotal
                                    </li>
                                    <li>
                                        <span class="text-info">Monto en bolivares en texto</span>:$bolivar_text
                                    </li>
                                    <li>
                                        <span class="text-info">Monto en bolivares en numeros<span>:$bolibares_number
                                    </li>
                                    <li>
                                        <span class="text-info">Nombre del producto</span>:$nombre_de_producto</li>
                                    <li>
                                        <span class="text-info">Telefono</span>:$telefono
                                    </li>
                                    <li><span class="text-info">Email</span>:$email</li>
                                    <li>
                                        <span class="text-info">Fecha actual</span>:fecha_de_hoy</li>

                                        <li>
                                            <span class="text-info">
                                                Numero del comvenio
                                            </span>:$numero_de_convenio</li>
                                </div>                                    
                            </div>
                        </div>
                            
                        @endif


                </div>



                <!-- /.card-body -->

                <div class="card-footer row">
                    @csrf
                    <div class="col-md-2">
                    </div>

                    <div class="col-md-8">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary">{{ sc_language_render('action.submit') }}</button>
                        </div>
                        
                        @if (!empty($order))
                        <div class="btn-group float-left">
                            <a class="btn btn-primary float-left" href="{{ sc_route_admin('admin_order.detail', ['id' => $order ? $order : 'not-found-id']) }}"   >Ir al Detalle de la orden </a>
                        </div>
                            
                        @endif
                    </div>
                </div>

                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')

@endpush

@push('scripts')
@include($templatePathAdmin.'component.ckeditor_js')

<script type="text/javascript">
    $('textarea.editor').ckeditor(
    {
        filebrowserImageBrowseUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}?type=content',
        filebrowserImageUploadUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=content&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}?type=Files',
        filebrowserUploadUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=file&_token={{csrf_token()}}',
        filebrowserWindowWidth: '900',
        filebrowserWindowHeight: '600'
    }
);
</script>

@endpush