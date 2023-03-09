@extends($templatePathAdmin.'layout')

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
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right" style="margin-right: 5px">
                            <a href="{{ sc_route_admin('admin_order.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ sc_route_admin('admin_order.create') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main">

                    <div class="card-body">

                            <div class="form-group row {{ $errors->has('customer_id') ? ' text-red' : '' }}">
                                <label for="customer_id" class="col-sm-2 asterisk col-form-label">{{ sc_language_render('order.admin.select_customer') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control customer_id select2" style="width: 100%;" name="customer_id">
                                        <option value="">Buscar por nombre o cedula </option>
                                        @foreach ($users as $k => $v)
                                            <option value="{{ $k }}" {{ (old('customer_id') ==$k) ? 'selected':'' }}>{{ $v->name . $v->cedula}}</option>
                                        @endforeach
                                    </select>

                                    
                                        @if ($errors->has('customer_id'))
                                            <span class="text-sm">
                                                {{ $errors->first('customer_id') }}
                                            </span>
                                        @endif
                                </div>
                                <div class="input-group-append">
                                    <a href="{{ sc_route_admin('admin_customer.index') }}"><button type="button" id="button-filter" class="btn btn-success  btn-flat"><i class="fa fa-plus" title="Add new"></i></button></a>
                                </div>
                            </div>

                      
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group  {{ $errors->has('first_name') ? ' text-red' : '' }}">
                                        <label for="first_name" class="col-sm-2 col-form-label">{{ sc_language_render('order.first_name') }}</label>
                        
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                                </div>
                                                <input readonly type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control first_name" placeholder="" />
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
                                        <label for="last_name" class="col-sm-2 col-form-label">{{ sc_language_render('order.last_name') }}</label>
                                    
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                                </div>
                                                <input readonly type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control last_name" placeholder="" />
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
                                        <label for="email" class="col-form-label">{{ sc_language_render('order.email') }}</label>
                                     
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email" id="email" name="email" required value="{{ old('email') }}" class="form-control email" placeholder="" />
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
                                        <label for="phone" class="col-sm-2 col-form-label">{{ sc_language_render('order.phone') }}</label>
                                        
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-phone fa-fw"></i></span>
                                                </div>
                                                <input readonly style="width: 150px" type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control phone" placeholder="Input Phone" />
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
                                <label for="first_name_kana" class="col-sm-2 col-form-label">{{ sc_language_render('order.first_name_kana') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="first_name_kana" name="first_name_kana" value="{{ old('first_name_kana') }}" class="form-control first_name_kana" placeholder="" />
                                    </div>
                                        @if ($errors->has('first_name_kana'))
                                            <span class="text-sm">
                                                {{ $errors->first('first_name_kana') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('last_name_kana') ? ' text-red' : '' }}">
                                <label for="last_name_kana" class="col-sm-2 col-form-label">{{ sc_language_render('order.last_name_kana') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="last_name_kana" name="last_name_kana" value="{{ old('last_name_kana') }}" class="form-control last_name_kana" placeholder="" />
                                    </div>
                                        @if ($errors->has('last_name_kana'))
                                            <span class="text-sm">
                                                {{ $errors->first('last_name_kana') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                        @endif

                 

                          
                    


               

                        
                      
                           
                            <hr>

                            <div class="form-group row  {{ $errors->has('status') ? ' text-red' : '' }}">
                                <label for="status" class="col-sm-2 col-form-label">Fecha de pedido</label>
                                <div class="col-sm-8">
                                   <input value="@php echo date("Y-m-d")  @endphp" class="form-control fecha" name="fecha_de_pedido" type="date">
                                </div>
                            </div>



                            <div class="form-group row  {{ $errors->has('status') ? ' text-red' : '' }}">
                                <label for="status" class="col-sm-2 col-form-label">{{ sc_language_render('order.status') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control status " style="width: 100%;" name="status">
                                        <option value="1">SOLICTUD REALIZADA</option>
                                    </select>
                                        @if ($errors->has('status'))
                                            <span class="text-sm">
                                                {{ $errors->first('status') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                          

                            <div class="form-group row  {{ $errors->has('status') ? ' text-red' : '' }}">
                                <label for="Modalidad" class="col-sm-2 col-form-label">Modalidad de compra</label>
                                <div class="col-sm-8">
                                    <select class="form-control status " style="width: 100%;" name="modalidad_compra">
                                        <option value="1" {{ (old('modalidad_compra') ==1) ? 'selected':'' }} selected>Financiamento</option>
                                            <option value="0" >Al contado</option>
                                         
                                    </select>
                                        @if ($errors->has('modalidad_compra'))
                                            <span class="text-sm">
                                                {{ $errors->first('modalidad_compra') }}
                                            </span>
                                        @endif
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
                                <button type="submit" class="btn btn-primary">{{ sc_language_render('action.submit') }}</button>
                            </div>
    
                            <div class="btn-group float-left">
                                <button type="reset" class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
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
$('[name="customer_id"]').change(function(){
    addInfo();
});
$('[name="currency"]').change(function(){
    addExchangeRate();
});

function addExchangeRate(){
    var currency = $('[name="currency"]').val();
    var jsonCurrency = {!!$currenciesRate !!};
    $('[name="exchange_rate"]').val(jsonCurrency[currency]);
}

function addInfo(){
    id = $('[name="customer_id"]').val();
    if(id){
       $.ajax({
            url : '{{ sc_route_admin('admin_order.user_info') }}',
            type : "get",
            dateType:"application/json; charset=utf-8",
            data : {
                 id : id
            },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(result){
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

        
            if(result.orden.length>0){
             var html =`
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

                var product=''
                var nro_coutas=''
                var qty=''
                console.log(orden.details[0])
                
                if(orden.details[0]){
               product=orden.details[0].name;
               nro_coutas=orden.details[0].nro_coutas;
               qty=orden.details[0].qty;
       
                }

            html +=` <tr> 
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


            html +=`  </table> `;

            $('.tabla-solicitudes').html(html)
       
            }

       
            }
        });
       }else{
            $('#form-main').reset();
       }

}




</script>
@endpush
