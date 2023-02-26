@extends($templatePathAdmin.'layout')

@section('main')

   <div class="row">
      <div class="col-sm-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title title"> Datos del Reprentante legal</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr_5">
                            <a href="{{ sc_route_admin('admin_customer.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal  was-validated" id="form-main"  enctype="multipart/form-data" novalidate>


                    <div class="card-body">
                        @if (sc_config('customer_natural_jurídica'))
                        <div class="form-group row{{ $errors->has('natural_jurídica') ? ' has-error' : '' }}">
                            <label for="natural_jurídica"
                                    class="col-sm-2 col-form-label title2">Persona Natural </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                            <select required  type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('natural_jurídica'))?"input-error":"" }}"
                            name="natural_jurídica" id="natural_jurídica">

                            <option value="N" {{ (old('natural_jurídica')) ? 'selected':'' }}>Natural</option>
                            <option value="J" {{ (old('natural_jurídica')) ? 'selected':'' }}>Juridica</option>
                            
                        
                            </select>
                        </div>
                            @if ($errors->has('natural_jurídica'))
                            <span class="help-block">
                                {{ $errors->first('natural_jurídica') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if (sc_config_admin('customer_razon_social'))
                    <div class="form-group row {{ $errors->has('razon_social') ? ' text-red' : '' }} oculta_razon_social">
                        <label for="razon_social"
                            class="col-sm-2 col-form-label">Razon social</label>
    
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                            <input required disabled="true" id="razon_social" placeholder="Razon social" type="text" class="form-control" name="razon_social"
                                value="{{ (old('razon_social', $customer['razon_social'] ?? ''))}}">
                            </div>
                            @if($errors->has('razon_social'))
                            <span class="form-text">{{ $errors->first('razon_social') }}</span>
                            @endif
    
                        </div>
                    </div>
                    @endif

                    <div class="oculta_rif">
                        @if (sc_config_admin('customer_rif'))
                        <div  class="form-group row {{ $errors->has('rif') ? ' text-red' : '' }}">
                            <label for="rif"
                                class="col-sm-2 col-form-label">Rif</label>
    
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                <input required disabled="true" placeholder="Nro Rif" id="rif" type="text" class="form-control" name="rif"
                                    value="{{ (old('rif', $customer['rif'] ?? ''))}}">
                                </div>
                                @if($errors->has('rif'))
                                <span class="form-text">{{ $errors->first('rif') }}</span>
                                @endif
    
                            </div>

                            <br>
                            <h4 class="text-center m-auto">Datos del representante legal </h4>
                        </div>
                        @endif
                       

                    </div>
                   
                    @if (sc_config('customer_nacionalidad'))
                    <div class="form-group row{{ $errors->has('nacionalidad') ? ' has-error' : '' }}">
                        <label for="nacionalidad"
                                class="col-sm-2 col-form-label"> Nacionalidad</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                        <select required  type="text"
                        class="is_required validate account_input form-control {{ ($errors->has('nacionalidad'))?"input-error":"" }}"
                        name="nacionalidad" id="nacionalidad">

                        <option value="">Seleccióna un nacionalidad</option>
                        <option value="V" {{ (old('nacionalidad')) ? 'selected':'' }}>Venezolano(a)</option>
                        <option value="E" {{ (old('nacionalidad')) ? 'selected':'' }}>Extranjero(a)</option>
                        
                    
                        </select>
                    </div>
                        @if ($errors->has('nacionalidad'))
                        <span class="help-block">
                            {{ $errors->first('nacionalidad') }}
                        </span>
                        @endif
                    </div>
                </div>

                
                @if (sc_config_admin('customer_cedula'))
                <div class="form-group row {{ $errors->has('cedula') ? ' text-red' : '' }}">
                    <label for="cedula"
                        class="col-sm-2 col-form-label">Cedula</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            </div>
                        <input required min="4" maxlength="20" id="cedula" placeholder="Nro Documento" type="text" class="form-control is-invalid" name="cedula"
                            value="{{ (old('cedula', $customer['cedula'] ?? ''))}}">
                        </div>
                        @if($errors->has('cedula'))
                        <span class="form-text">{{ $errors->first('cedula') }}</span>
                        @endif

                    </div>
                </div>
                @endif
              
                
               
                @endif
                <div class="form-group row{{ $errors->has('estado_civil') ? ' has-error' : '' }}">
                    <label for="estado_civil"
                            class="col-sm-2 col-form-label"> Estado civil</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                    <select required  type="text"
                    class="is_required validate account_input form-control {{ ($errors->has('estado_civil'))?"input-error":"" }}"
                    name="estado_civil" id="estado_civil">

                    <option value="SOLTERO(a)" >Soltero(a)</option>
                    <option value="CASADO(a)" >Casado(a)</option>

                    <option value="CONCUBINATO(a)" >Concubinato(a)</option>
                    
                
                    </select>
                </div>
                    @if ($errors->has('estado_civil'))
                    <span class="help-block">
                        {{ $errors->first('estado_civil') }}
                    </span>
                    @endif
                </div>
            </div>
                    
                   

                       
                            @if (sc_config_admin('customer_lastname'))
                            <div class="form-group row {{ $errors->has('first_name') ? ' text-red' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.first_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input required placeholder="Nombre" id="first_name" type="text" class="form-control" name="first_name"
                                        value="{{ (old('first_name', $customer['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="form-text">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                          

                           
                            <div class="form-group row {{ $errors->has('last_name') ? ' text-red' : '' }}">
                                <label for="last_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.last_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input required placeholder="Apellido" id="last_name" type="text" class="form-control" name="last_name"
                                        value="{{ (old('last_name', $customer['last_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('last_name'))
                                    <span class="form-text">{{ $errors->first('last_name') }}</span>
                                    @endif
    
                                </div>
                            </div>

                            
                            @else
                            <div class="form-group row {{ $errors->has('first_name') ? ' text-red' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="first_name" type="text" class="form-control" name="first_name"
                                        value="{{ (old('first_name', $customer['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="form-text">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>

                            
                            @endif

                            
                            @if (sc_config_admin('customer_name_kana'))
                            <div class="form-group row {{ $errors->has('first_name_kana') ? ' text-red' : '' }}">
                                <label for="first_name_kana"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.first_name_kana') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="first_name_kana" type="text" class="form-control" name="first_name_kana"
                                        value="{{ (old('first_name_kana', $customer['first_name_kana'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name_kana'))
                                    <span class="form-text">{{ $errors->first('first_name_kana') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('last_name_kana') ? ' text-red' : '' }}">
                                <label for="last_name_kana"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.last_name_kana') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="last_name_kana" type="text" class="form-control" name="last_name_kana"
                                        value="{{ (old('last_name_kana', $customer['last_name_kana'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('last_name_kana'))
                                    <span class="form-text">{{ $errors->first('last_name_kana') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif


                            @if (sc_config_admin('customer_phone'))
                            <div class="form-group row {{ $errors->has('phone') ? ' text-red' : '' }}">
                                <label for="phone"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.phone') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input required placeholder="Telefono 1" id="phone" type="text" class="form-control" name="phone"
                                        value="{{ (old('phone', $customer['phone'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('phone'))
                                    <span class="form-text">{{ $errors->first('phone') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif

                            @if (sc_config_admin('customer_phone'))
                            <div class="form-group row ">
                                <label for="phone2"
                                    class="col-sm-2 col-form-label">Telefono /opcional</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input placeholder="Telefono 2 /opcional" id="phone2" type="text" class="form-control" name="phone2" 
                                        >
                                    </div>
                                    
    
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config_admin('customer_postcode'))
                            <div class="form-group row {{ $errors->has('postcode') ? ' text-red' : '' }}">
                                <label for="postcode"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.postcode') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input placeholder="Codigo postal" id="postcode" type="text" class="form-control" name="postcode"
                                        value="{{ (old('postcode', $customer['postcode'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('postcode'))
                                    <span class="form-text">{{ $errors->first('postcode') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            <div class="form-group row {{ $errors->has('email') ? ' text-red' : '' }}">
                                <label for="email"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.email') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input required placeholder="email" id="email" type="text" class="form-control" name="email"
                                        value="{{ (old('email',$customer['email'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('email'))
                                    <span class="form-text">{{ $errors->first('email') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            <div class="form-group  row {{ $errors->has('estado') ? ' text-red' : '' }}">
                                <label for="cod_estado" class="col-sm-2  col-form-label">{{ sc_language_render('customer.estado') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <select required  type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('estado'))?"input-error":"" }}"
                            name="cod_estado" id="cod_estado"   >
                            <option  value="">Seleccióna un Estado</option>
                            <?php
                            if(isset($estado)){
                                foreach ($estado as $key => $estado) {
                                    if(isset($customer['cod_estado']) and $customer['cod_estado'] == $estado->codigoestado){
                                        echo "<option selected value='".$estado->codigoestado."'  data-latitud=".$estado->latitud."  data-longitud=".$estado->longitud." >".$estado->nombre."</option>";     
                                    }else{
                                        echo "<option value='".$estado->codigoestado."' data-latitud=".$estado->latitud."  data-longitud=".$estado->longitud." >".$estado->nombre."</option>";
                                    }
                                }
                            }
                        ?>            
                        </select>
                                    </div>
                                        @if ($errors->has('estado'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('estado') }}
                                            </span>
                                        @else
                                            @if ($customer)
                                                <span class="form-text text-info">
                                                     seleciona un estado para cambiar muncipio y parroquia
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>
                            <div class="form-group  row {{ $errors->has('estado') ? ' text-red' : '' }}">
                                <label for="municipio" class="col-sm-2  col-form-label">{{ sc_language_render('customer.municipio') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <select required class="form-control show-tick" id="cod_municipio" name="cod_municipio">
                                            <option value="">Seleccione un Municipio</option>
                                    <?php
                                        if(isset($municipio)){
                                        foreach ($municipio as $key => $municipios) {
                                        if(isset($customer['cod_municipio']) and $customer['cod_municipio'] == $municipios->codigomunicipio){
                                        echo "<option selected value='". $municipios->codigomunicipio."' >".$municipios->nombre."</option>";     
                                        }
                                        }
                                    }
                                    ?>        
                                            </select>
                                    </div>
                                        @if ($errors->has('municipio'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('municipio') }}
                                            </span>
                                        @else
                                            @if ($customer)
                                            <span class="form-text text-info">
                                                seleciona un municipio para cambiar  parroquia
                                            </span>
                                            @endif
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('cod_parroquia') ? ' text-red' : '' }}">
                                <label for="cod_parroquia" class="col-sm-2  col-form-label">{{ sc_language_render('customer.parroquia') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <select required class="form-control show-tick" id="cod_parroquia" name="cod_parroquia">
                                            <option value="">Seleccione un Parroquia</option>
                                    <?php
                                        if(isset($parroquia)){
                                        foreach ($parroquia as $key => $parroquias) {
                                           
                                        if(isset($customer['cod_parroquia']) and $customer['cod_parroquia'] == $parroquias->codigoparroquia){
                                           
                                        echo "<option selected value='". $parroquias->codigoparroquia."' >".$parroquias->nombre."</option>";     
                                        }
                                        }
                                    }
                                    ?>        
                                            </select>
                                    </div>
                                        @if ($errors->has('cod_parroquia'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('cod_parroquia') }}
                                            </span>
                                        @else
                                            @if ($customer)
                                                <span class="form-text">
                                                     {!! sc_language_render('customer.parroquia') !!}
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>
    
                            
                            <div class="form-group row {{ $errors->has('address1') ? ' text-red' : '' }}">
                                <label for="address1"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.address1') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input  placeholder="Direccion 1" required id="address1" type="text" class="form-control" name="address1"
                                        value="{{ (old('address1', $customer['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address1'))
                                    <span class="form-text">{{ $errors->first('address1') }}</span>
                                    @endif
    
                                </div>
                            </div>

                            @if (sc_config_admin('customer_address2'))
                            <div class="form-group row {{ $errors->has('address2') ? ' text-red' : '' }}">
                                <label for="address2"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.address2') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input placeholder="Direccion 2" id="address2" type="text" class="form-control" name="address2"
                                        value="{{ (old('address2', $customer['address2'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address2'))
                                    <span class="form-text">{{ $errors->first('address2') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif

    
                            @if (sc_config_admin('customer_address3'))
                            <div class="form-group row {{ $errors->has('address3') ? ' text-red' : '' }}">
                                <label for="address3"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.address3') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="address3" type="text" class="form-control" name="address3"
                                        value="{{ (old('address3', $customer['address3'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address3'))
                                    <span class="form-text">{{ $errors->first('address3') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif

    
                            @if (sc_config_admin('customer_country'))
                            @php
                            $country = old('country', $customer['country'] ?? '');
                            @endphp
    
                            <div class="form-group row {{ $errors->has('country') ? ' text-red' : '' }}">
                                <label for="country"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.country') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control country" style="width: 100%;" name="country">
                                        <option>__{{ sc_language_render('customer.country') }}__</option>
                                        @foreach ($countries as $k => $v)
                                        <option value="{{ $k }}" {{ ($country == $k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                    <span class="form-text">
                                        {{ $errors->first('country') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config_admin('customer_sex'))
                            @php
                            $sex = old('sex', $customer['sex'] ?? 0);
                            @endphp
                            <div class="form-group{{ $errors->has('sex') ? ' text-red' : '' }}">
                                <label
                                    class="col-sm-2 validate account_input {{ ($errors->has('sex'))?"input-error":"" }}">{{ sc_language_render('customer.sex') }}:
                                </label>
                                <div class="col-sm-8">
                                <label class="radio-inline"><input value="0" type="radio" name="sex"
                                        {{ ($sex == 0)?'checked':'' }}> {{ sc_language_render('customer.sex_women') }}</label>
                                <label class="radio-inline"><input value="1" type="radio" name="sex"
                                        {{ ($sex == 1)?'checked':'' }}> {{ sc_language_render('customer.sex_men') }}</label>
                                </div>
                                @if ($errors->has('sex'))
                                <span class="form-text">
                                    {{ $errors->first('sex') }}
                                </span>
                                @endif
                            </div>
                            @endif
    
                            @if (sc_config_admin('customer_birthday'))
                            <div class="form-group row {{ $errors->has('birthday') ? ' text-red' : '' }}">
                                <label for="birthday"
                                    class="col-sm-2 col-form-label">
                                    {{ sc_language_render('customer.birthday') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input type="text" id="birthday" class="form-control date_time" data-date-format="yyyy-mm-dd"
                                        name="birthday" placeholder="yyyy-mm-dd"
                                        value="{{ (old('birthday', $customer['birthday'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('birthday'))
                                    <span class="form-text">{{ $errors->first('birthday') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif

                            @if (sc_config_admin('customer_group'))
                            <div class="form-group row {{ $errors->has('group') ? ' text-red' : '' }}">
                                <label for="group"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.group') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="group" type="number" class="form-control" name="group"
                                        value="{{ (old('group', $customer['group'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('group'))
                                    <span class="form-text">{{ $errors->first('group') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif


                            <div class="form-group  row {{ $errors->has('password') ? ' text-red' : '' }}">
                                <label for="password" class="col-sm-2  col-form-label">{{ sc_language_render('customer.password') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input required type="text"   id="password" name="password" value="{{ old('password')??'' }}" class="form-control password" placeholder="Contraseña" />
                                    </div>
                                        @if ($errors->has('password'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('password') }}
                                            </span>
                                        @else
                                            @if ($customer)
                                                <span class="form-text">
                                                     {{ sc_language_render('customer.admin.keep_password') }}
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('password_confirmation') ? ' text-red' : '' }}">
                                <label for="password_confirmation" class="col-sm-2  col-form-label">{{ sc_language_render('customer.password_confirm') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input required type="text"   id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation')??'' }}" class="form-control password_confirmation" placeholder="Confirma contraseña" />
                                    </div>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('password_confirmation') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                            <div class="form-group  row">
                                <label for="nos_conocio" class="col-sm-2  col-form-label">¿COMO NOS CONOCISTE?</label>
                                <div class="col-sm-8 {{ $errors->has('nos_conocio') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                    <select required  type="text"
                                    class="is_required validate account_input form-control {{ ($errors->has('nos_conocio'))?"input-error":"" }}"
                                    name="nos_conocio" id="nos_conocio">
        
                                    <option value="">¿COMO NOS CONOCISTE?</option>
                                    <option value="facebook" >Facebook</option>
                                    <option value="instagram" >instagram</option>
                                    <option value="twitter" >Twitter</option>
                                    <option value="Amigo" >Amigo</option>
                                    
                                
                                    </select>
                                    @if ($errors->has('nos_conocio'))
                                    <span class="help-block">
                                        {{ $errors->first('nos_conocio') }}
                                    </span>
                                    @endif
                                </div>
                                </div>
                            
                            </div>

                            <div class="form-group  row">
                                {{-- <label for="status" class="col-sm-2  col-form-label">{{ sc_language_render('customer.status') }}</label> --}}
                                <div class="col-sm-8">
                                    <input checked class="checkbox" type="hidden" name="status"  value="1">

                                </div>
                            </div>



{{-- Custom fields --}}
@if (isset($customFields) && count($customFields))
                <hr class="kind ">
                <label>{{ sc_language_render('admin.custom_field.title') }} (<a target=_new href="{{ sc_route_admin('admin_custom_field.index') }}"><i class="fa fa-link" aria-hidden="true"></i></a>)</label>
                    @foreach ($customFields as $keyField => $field)
                    @php
                        $default  = json_decode($field->default, true)
                    @endphp
                    <div class="form-group row kind   {{ $errors->has('fields.'.$field->code) ? ' text-red' : '' }}">
                        <label for="{{ $field->code }}" class="col-sm-2 col-form-label">{{ sc_language_render($field->name) }}</label>
                        
                        <div class="col-sm-8">
                            @if ($field->option == 'radio')
                                @if ($default)
                                @foreach ($default as $key => $name)
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="{{ $keyField.'__'.$key }}" name="fields[{{ $field->code }}]" value="{{ $key }}" {{ (old('fields.'.$field->code) == $key)?'checked':'' }}>
                                    <label for="{{ $keyField.'__'.$key }}">
                                        {{ $name }}
                                    </label>
                                </div>
                                @endforeach
                                @endif
                            @elseif($field->option == 'select')
                                @if ($default)
                                <select class="form-control input-sm {{ $field->code }}" style="width: 100%;"
                                name="fields[{{ $field->code }}]">
                                <option value=""></option>
                                @foreach ($default as $key => $name)
                                <option value="{{ $key }}" {{ (old('fields.'.$field->code) == $key) ? 'selected':'' }}>{{ $name }}
                                </option>
                                @endforeach
                                </select>
                                @endif
                            @else
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" id="field_{{ $field->code }}" name="fields[{{ $field->code }}]"
                                        value="{{ old('fields.'.$field->code) }}"
                                        class="form-control input-sm {{ $field->code }}" placeholder="" />
                                </div>
                            @endif

                            @if ($errors->has('fields.'.$field->code))
                            <span class="form-text">
                                <i class="fa fa-info-circle"></i> {{ $errors->first('fields.'.$field->code) }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
@endif
{{-- //Custom fields --}}



                    </div>



                    <!-- /.card-body -->

                    <div class="card-footer row">
                            @csrf
                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-8">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary">{{ sc_language_render('action.submit') }}</button>
                            </div>

                            <div class="btn-group pull-left">
                                <button type="reset" class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-footer -->
                </form>

            </div>

            <div class="card">
                @if (!empty($addresses))
                    <div class="card-header with-border">
                        <h2 class="card-title">{{ sc_language_render('customer.address_list') }}</h2>
                    </div>
                    @foreach($addresses as $address)
                        <div class="list">
                        @if (sc_config_admin('customer_lastname'))
                        <b>{{ sc_language_render('customer.first_name') }}:</b> {{ $address['first_name'] }}<br>
                        <b>{{ sc_language_render('customer.last_name') }}:</b> {{ $address['last_name'] }}<br>
                        @else
                        <b>{{ sc_language_render('customer.name') }}:</b> {{ $address['first_name'] }}<br>
                        @endif
                        
                        @if (sc_config_admin('customer_phone'))
                        <b>{{ sc_language_render('customer.phone') }}:</b> {{ $address['phone'] }}<br>
                        @endif
            
                        @if (sc_config_admin('customer_postcode'))
                        <b>{{ sc_language_render('customer.postcode') }}:</b> {{ $address['postcode'] }}<br>
                        @endif
            
                        <b>{{ sc_language_render('customer.address1') }}:</b> {{ $address['address1'] }}<br>

                        @if (sc_config_admin('customer_address2'))
                        <b>{{ sc_language_render('customer.address2') }}:</b> {{ $address['address2'] }}<br>
                        @endif

                        @if (sc_config_admin('customer_address3'))
                        <b>{{ sc_language_render('customer.address3') }}:</b> {{ $address['address3'] }}<br>
                        @endif
            
                        @if (sc_config_admin('customer_country'))
                        <b>{{ sc_language_render('customer.country') }}:</b> {{ $countries[$address['country']] ?? $address['country'] }}<br>
                        @endif
            
                        <span class="btn">
                            <a title="{{ sc_language_render('customer.addresses.edit') }}" href="{{ sc_route_admin('admin_customer.update_address', ['id' => $address->id]) }}"><i class="fa fa-edit"></i></a>
                        </span>
                        <span class="btn">
                            <a href="#" title="{{ sc_language_render('customer.addresses.delete') }}" class="delete-address" data-id="{{ $address->id }}"><i class="fa fa-trash"></i></a>
                        </span>
                        @if ($address->id == $customer['address_id'])
                        <span class="btn" title="{{ sc_language_render('customer.addresses.default') }}"><i class="fa fa-university" aria-hidden="true"></i></span>
                        @endif
                        </div>
                    @endforeach
                @endif
            </div>


        </div>
    </div>
    @vite('resources/js/estado.js')
    <script src="/js/cliente.js"></script>
@endsection

@push('styles')
<style>
    .list{
        padding: 5px;
        margin: 5px;
        border-bottom: 1px solid #dcc1c1;
    }
</style>
@endpush

@push('scripts')
<script>
    $('.delete-address').click(function(){
      var r = confirm("{{ sc_language_render('customer.confirm_delete') }}");
      if(!r) {
        return;
      }
      var id = $(this).data('id');
      $.ajax({
              url:'{{ route("admin_customer.delete_address") }}',
              type:'POST',
              dataType:'json',
              data:{id:id,"_token": "{{ csrf_token() }}"},
                  beforeSend: function(){
                  $('#loading').show();
              },
              success: function(data){
                if(data.error == 0) {
                  location.reload();
                }
              }
          });
    });


    (function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
  </script>

@endpush
