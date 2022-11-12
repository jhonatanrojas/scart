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

                        @if (sc_config_admin('customer_company'))
                            <div class="form-group row {{ $errors->has('company') ? ' text-red' : '' }}">
                                <label for="company" class="col-sm-2 col-form-label">{{ sc_language_render('order.company') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="company" name="company" value="{{ old('company') }}" class="form-control company" placeholder="" />
                                    </div>
                                        @if ($errors->has('company'))
                                            <span class="text-sm">
                                                {{ $errors->first('company') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                        @endif

                        @if (sc_config_admin('customer_postcode'))
                            <div class="form-group row {{ $errors->has('postcode') ? ' text-red' : '' }}">
                                <label for="postcode" class="col-sm-2 col-form-label">{{ sc_language_render('order.postcode') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" class="form-control postcode" placeholder="" />
                                    </div>
                                        @if ($errors->has('postcode'))
                                            <span class="text-sm">
                                                {{ $errors->first('postcode') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                        @endif

                          
                        @if (sc_config_admin('customer_address2'))    
                            <div class="form-group row {{ $errors->has('address2') ? ' text-red' : '' }}">
                                <label for="address2" class="col-sm-2 col-form-label">{{ sc_language_render('order.address2') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="address2" name="address2" value="{{ old('address2') }}" class="form-control address2" placeholder="" />
                                    </div>
                                        @if ($errors->has('address2'))
                                            <span class="text-sm">
                                                {{ $errors->first('address2') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                        @endif


                        @if (sc_config_admin('customer_address3'))    
                        <div class="form-group row {{ $errors->has('address3') ? ' text-red' : '' }}">
                            <label for="address3" class="col-sm-2 col-form-label">{{ sc_language_render('order.address3') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" id="address3" name="address3" value="{{ old('address3') }}" class="form-control address3" placeholder="" />
                                </div>
                                    @if ($errors->has('address3'))
                                        <span class="text-sm">
                                            {{ $errors->first('address3') }}
                                        </span>
                                    @endif
                            </div>
                        </div>
                    @endif


                        @if (sc_config_admin('customer_country'))
                            <div class="form-group row {{ $errors->has('country') ? ' text-red' : '' }}">
                                <label for="country" class="col-sm-2 asterisk col-form-label">{{ sc_language_render('order.country') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control country " style="width: 100%;" name="country" >
                                        <option value=""></option>
                                        @foreach ($countries as $k => $v)
                                            <option value="{{ $k }}" {{ (old('country') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('country'))
                                            <span class="text-sm">
                                                {{ $errors->first('country') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                        @endif

                     
                        
                      
                            <div class="form-group row">
                                <label for="comment" class="col-sm-2 col-form-label">{{ sc_language_render('order.note') }}</label>
                                <div class="col-sm-8">
                                    <textarea name="comment" class="form-control comment" rows="5" placeholder="">{!! old('comment') !!}</textarea>
                                </div>
                            </div>
                            <hr>



                            <div class="form-group row  {{ $errors->has('status') ? ' text-red' : '' }}">
                                <label for="status" class="col-sm-2 col-form-label">{{ sc_language_render('order.status') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control status " style="width: 100%;" name="status">
                                      @foreach ($orderStatus as $k => $v)
                                            <option value="{{ $k }}" {{ (old('status') ==$k) ? 'selected':'' }}>{{ $v}}</option>
                                        @endforeach
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
                           
                                            <option value="0" {{ (old('modalidad_compra') ==0) ? 'selected':'' }}>Al contado</option>
                                            <option value="1" {{ (old('modalidad_compra') ==1) ? 'selected':'' }}>Financiamento</option>
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
                var returnedData = JSON.parse(result);
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
                $('[name="country"]').val(returnedData.country).change();
                $('#loading').hide();
            }
        });
       }else{
            $('#form-main').reset();
       }

}


function selectProduct(element){
    console.log(element)
        node = element.closest('tr');
        var id = node.find('option:selected').eq(0).val();
        if(!id){
            node.find('.add_sku').val('');
            node.find('.add_qty').eq(0).val('');
            node.find('.add_price').eq(0).val('');
            node.find('.add_attr').html('');
            node.find('.add_tax').html('');
        }else{
            $.ajax({
                url : '{{ sc_route_admin('admin_order.product_info') }}',
                type : "get",
                dateType:"application/json; charset=utf-8",
                data : {
                     id : id,
                     order_id : '',
                },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(returnedData){
                console.log(returnedData)
               
                $('#loading').hide();
                }
            });
        }

    }

</script>
@endpush
