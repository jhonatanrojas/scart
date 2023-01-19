@extends($templatePathAdmin.'layout')
@section('main')
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ sc_route_admin('admin_customer.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                        <div class="fields-group">

                            @if (sc_config('customer_natural_jurídica'))
                            <div class="form-group row{{ $errors->has('natural_jurídica') ? ' has-error' : '' }}">
                                <label for="first_name"
                                        class="col-sm-2 col-form-label title2">Persona Natural </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                <select required  type="text"
                                class="is_required validate account_input form-control {{ ($errors->has('natural_jurídica'))?"input-error":"" }}"
                                name="natural_jurídica" id="natural_jurídica">
    
                                <option value="N" {{ $customer['natural_jurídica'] == "N" ? 'selected':'' }}>Natural</option>
                                <option value="J" {{ $customer['natural_jurídica'] == "J" ? 'selected':'' }}>Juridica</option>
                                
                            
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
                                <input disabled="true" id="razon_social" placeholder="Razon social" type="text" class="form-control" name="razon_social"
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
                                    <input  disabled="true" placeholder="Nro Rif" id="rif" type="text" class="form-control" name="rif"
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

                            @php
                            $pizza  = $customer['cedula'];
                            $pieces = explode(" ", $pizza);
                           
                               
                            @endphp
               
                           

                           
    
                        </div>

                        @if (sc_config('customer_nacionalidad'))
                        <div class="form-group row{{ $errors->has('nacionalidad') ? ' has-error' : '' }}">
                            <label for="first_name"
                                    class="col-sm-2 col-form-label"> Nacionalidad</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                            <select  type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('nacionalidad'))?"input-error":"" }}"
                            name="nacionalidad" id="nacionalidad">
    
                            <option value="">Seleccióna un nacionalidad</option>
                            <option value="V" {{ $pieces[0] == "V" ? 'selected':'' }}>Venezolano(a)</option>
                            <option value="E" {{ $pieces[0] == "E" ? 'selected':'' }}>Extranjero(a)</option>
                            
                        
                            </select>
                        </div>
                            @if ($errors->has('nacionalidad'))
                            <span class="help-block">
                                {{ $errors->first('nacionalidad') }}
                            </span>
                            @endif
                        </div>
                    </div>
                       
                   
                    @endif


                    @if (sc_config('customer_estado_civil'))
                        <div class="form-group row{{ $errors->has('estado_civil') ? ' has-error' : '' }}">
                            <label for="first_name"
                                    class="col-sm-2 col-form-label"> Estado civil</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                            <select  type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('estado_civil'))?"input-error":"" }}"
                            name="estado_civil" id="estado_civil">
    
                            <option value="SOLTERO(a)" {{ $customer['estado_civil'] == "SOLTERO(a)" ? 'selected':'' }}>Soltero(a)</option>
                            <option value="CASADO(a)" {{ $customer['estado_civil'] == "CASADO(a)" ? 'selected':'' }}>Casado(a)</option>

                            <option value="CONCUBINATO(a)" {{ $customer['estado_civil'] == "CONCUBINATO(a)" ? 'selected':'' }}>Concubinato(a)</option>
                            
                        
                            </select>
                        </div>
                            @if ($errors->has('estado_civil'))
                            <span class="help-block">
                                {{ $errors->first('estado_civil') }}
                            </span>
                            @endif
                        </div>
                    </div>
                       
                   
                    @endif

                            @if (sc_config_admin('customer_lastname'))
                            <div class="form-group row {{ $errors->has('first_name') ? ' text-red' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.first_name') }}</label>
    
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
                            
                            <div class="form-group row {{ $errors->has('last_name') ? ' text-red' : '' }}">
                                <label for="last_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.last_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="last_name" type="text" class="form-control" name="last_name" 
                                        value="{{ (old('last_name', $customer['last_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('last_name'))
                                    <span class="form-text">{{ $errors->first('last_name') }}</span>
                                    @endif
    
                                </div>
                            </div>

                          
                      

                               

                       
                            <div class="form-group row {{ $errors->has('cedula') ? ' text-red' : '' }}">
                                <label for="cedula"
                                    class="col-sm-2 col-form-label">Cedulas</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="cedula" type="text" class="form-control" name="cedula" 
                                        value="{{ (old('cedula', $pieces[1] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="form-text">{{ $errors->first('cedula') }}</span>
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
                                    <input id="phone" type="text" class="form-control" name="phone" 
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
                                <label for="phone"
                                    class="col-sm-2 col-form-label">Telefono /opcional</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="phone2" type="text" class="form-control" name="phone2" 
                                        value="{{ (old('phone2', $customer['phone2'] ?? ''))}}">
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
                                    <input id="postcode" type="text" class="form-control" name="postcode" 
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
                                    <input id="email" type="text" class="form-control" name="email" 
                                        value="{{ (old('email',$customer['email'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('email'))
                                    <span class="form-text">{{ $errors->first('email') }}</span>
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
                                    <input max="200" id="address1" type="text" class="form-control" name="address1" 
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
                                    <input id="address2" type="text" class="form-control" name="address2" 
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
                                    <input type="text" id="birthday" class="form-control date_time" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd"
                                        name="birthday" 
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
                                        <input type="text"   id="password" name="password" value="{{ old('password')??'' }}" class="form-control password" placeholder="" />
                                    </div>
                                        @if ($errors->has('password'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('password') }}
                                            </span>
                                        @else
                                            @if ($customer)
                                                <span class="form-text">
                                                     {!! sc_language_render('customer.admin.keep_password') !!}
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>
                            <div class="form-group  row {{ $errors->has('estado') ? ' text-red' : '' }}">
                                <label for="estado" class="col-sm-2  col-form-label">{{ sc_language_render('customer.estado') }}</label>
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
                                        <select class="form-control show-tick" id="cod_municipio" name="cod_municipio">
                                            <option value="0">Seleccione un Municipio</option>
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
                                        @if ($errors->has('estado'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('estado') }}
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
                                        <select class="form-control show-tick" id="cod_parroquia" name="cod_parroquia">
                                            <option value="0">Seleccione un Municipio</option>
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
                                        @if ($errors->has('parroquias'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('parroquias') }}
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

                            @if (sc_config('customer_nos_conocio'))
                            <div class="form-group  row">
                                <label for="cod_parroquia" class="col-sm-2  col-form-label">¿COMO NOS CONOCISTE?</label>
                                <div class="col-sm-8 {{ $errors->has('nos_conocio') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                    <select required  type="text"
                                    class="is_required validate account_input form-control {{ ($errors->has('nos_conocio'))?"input-error":"" }}"
                                    name="nos_conocio" id="nos_conocio">
        
                                    <option value="">¿COMO NOS CONOCISTE?</option>
                                    <option value="facebook" {{ $customer['nos_conocio'] == "facebook" ? 'selected':'' }}>Facebook</option>
                                    <option value="instagram" {{ $customer['nos_conocio'] == "instagram" ? 'selected':'' }}>instagram</option>
                                    <option value="twitter" {{ $customer['nos_conocio'] == "twitter" ? 'selected':'' }}>Twitter</option>
                                    <option value="Amigo" {{ $customer['nos_conocio'] == "amigo" ? 'selected':'' }}>Amigo</option>
                                    
                                
                                    </select>
                                    @if ($errors->has('nos_conocio'))
                                    <span class="help-block">
                                        {{ $errors->first('nos_conocio') }}
                                    </span>
                                    @endif
                                </div>
                                </div>
                            
                            </div>
                            @endif
                            
                            @if ($customer['provider'])
                            <div class="form-group  row">
                                <label for="status" class="col-sm-2  col-form-label">{{ sc_language_render('customer.admin.provider') }}</label>
                                <div class="col-sm-8">
                                    {{ $customer['provider'] }}
                                </div>
                            </div>
                            @endif


                            <div class="form-group  row">
                                {{-- <label for="status" class="col-sm-2  col-form-label">{{ sc_language_render('customer.status') }}</label> --}}
                                <div class="col-sm-8">
                                    <input checked class="checkbox" type="hidden" name="status"  value="1">

                                </div>
                            </div>



{{-- Custom fields --}}
@if (isset($customFields) && count($customFields))
@php
    $fields = $customer->getCustomFields()
@endphp
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
                                    <input type="radio" id="{{ $keyField.'__'.$key }}" name="fields[{{ $field->code }}]" value="{{ $key }}" {{ (old('fields.'.$field->code, ($fields[$field->code]['text'] ?? '')) == $key)?'checked':'' }}>
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
                                <option value="{{ $key }}" {{ (old('fields.'.$field->code, ($fields[$field->code]['text'] ?? '')) == $key) ? 'selected':'' }}>{{ $name }}
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
                                        value="{{ old('fields.'.$field->code, ($fields[$field->code]['text'] ?? '')) }}"
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
                    </div>



                    <!-- /.card-body -->
                   

                    <div class="card-footer row ">
                        @csrf
                        <div class="col-md-2 mt-2">
                        </div>
    
                        <div class="col-12 col-md-3 ">
                            <div class="btn-group ">
                                <button type="submit" class="btn btn-primary">{{ sc_language_render('action.submit') }}</button>
                            </div>
                            
    

                          
                        </div>
                        <div class="col-12 col-md-3  mt-2 ">
                            <div class="btn-group ">
                                <a href="{{sc_route_admin('admin_customer.document', ['id' => $customer['id'] ? $customer['id'] : 'not-found-id'])}}"  class="btn btn-info">Ver Documentos adjuntos</a>
                               </div>
                        </div>
                        <div class=" col-12 col-md-3  mt-2">
                            
                            <div class="btn-group ">
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
           @if (!empty($referencia))
           <div class="card">
              
            <div class="card-header with-border">
                <h2 class="card-title">Referencia personales </h2>
            </div>

            <div class="col-md-12">
                <div class="row ">
                    <div class="form-group   col-12 col-md-6 mt-3">
                  
                        <div class=" col-12 col-md-12 mb-3">
                            <div class="input-group">
                                <input  type="text" id="nombre_ref" name="nombre_ref"
                                    value="" class="form-control" 
                                    placeholder="Nombre" />
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mb-3">
                            <div class="input-group">
                                <input  required type="text" id="apellido_ref" name="apellido_ref"
                                    value="" class="form-control "
                                    placeholder="apellido" />
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mb-3">
                            <div class="input-group">
                                <input  required type="text" id="cedula_ref" name="cedula_ref"
                                    value="" class="form-control "
                                    placeholder="Cedula" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="input-group">
                                <input required type="number" id="telefono_ref" name="telefono_ref"
                                    value="" class="form-control"
                                    placeholder="Telefono" />
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="input-group">
                                <input required type="text" id="parentesco" name="parentesco"
                                    value="" class="form-control"
                                    placeholder="parentesco" />
                            </div>
                        </div>

                        <input type="hidden" id="id_usuario" name="id_usuario" value="{{$customer['id']}}">

                        <div class="text-center mt-3">
                            <button type="button"
                    class="btn  btn-success add_attributes"
                    >
                    <i class="fa fa-plus " aria-hidden="true"></i>
                    Agregar 
                    </button>
        
                    </div>
                    </div>


                    <div class="col-12 col-md-6 ">
               
                        <table class="table">
                            <thead>
                                <tr>
                                  <th>Nombre</th>
                                  <th>Apellido</th>
                                  <th>Cedula</th>
                                  <th>Telefono</th>
                                  <th>Parentesco</th>
                                  <th>Acciones</th>
                                </tr>
                              </thead>
                       
                              @foreach ($referencia as $ref)
                          
                            <tbody>

                                   

                                <td>{{$ref->nombre_ref}}</td>
                                <td>{{$ref->apellido_ref}}</td>
                                <td>{{$ref->cedula_ref}}</td>
                                <td>{{$ref->telefono}}</td>      
                                <td>{{$ref->parentesco}}</td>      
                                <td><span onclick="deleteItem('{!!$ref->id!!}');" title="Borrar" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
                                </td>      
                                       
                                        
                                 
                                    

                            </tbody>
                            @endforeach
            
            
                       
                    </table>
                    
                    
                </div>

                
            </div>


            
                




           
          
           
           
    </div>


</div>
               
           @endif
    </div>
<script src="/js/cliente1.js"></script>
@vite('resources/js/estado.js')
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



$('.add_attributes').click(function(event) {
 let nombre_ref = $('#nombre_ref').val()
 let apellido_ref = $('#apellido_ref').val()
 let telefono_ref = $('#telefono_ref').val()
 let Cedula_ref = $('#cedula_ref').val()
 let parentesco = $('#parentesco').val()
 let id = $('#id_usuario').val()
if(nombre_ref !== "" && apellido_ref !== "" && telefono_ref !== "" && parentesco !== ""){
    $.ajax({
          dataType: "json",
          data: {
            id_usuario:id ,
            "_token": "{{ csrf_token() }}",
            nombre_ref:nombre_ref,
            apellido_ref:apellido_ref,
            cedula_ref:Cedula_ref,
            telefono_ref: telefono_ref,
            parentesco: parentesco
        },
          url: '{{ route("ref_personales") }}',
          type: "post",
  
            success: function (respuestas) {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                
            }
            
            })

Toast.fire({
  icon: 'success',
  title: 'Registro integrado con exito '
})
                location.reload();
          },
          error: function (xhr, err) {
            alert(
              "readyState =" +
                xhr.readyState +
                " estado =" +
                xhr.status +
                "respuesta =" +
                xhr.responseText
            );
            alert("ocurrio un error intente de nuevo");
          },
        });


}else{
    alert("los campo son obligatorio")
}
})


function deleteItem(id){

   
    $.ajax({
          dataType: "json",
          data: {
            id:id,
            "_token": "{{ csrf_token() }}",
            
           
        },
          url:'{{ route("ref_delete") }}',
          type: "post",
            success: function (respuestas) {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                
            }
            
            })

Toast.fire({
  icon: 'error',
  title: 'Registro eliminado '
})
                location.reload();
          },
          error: function (xhr, err) {
            alert(
              "readyState =" +
                xhr.readyState +
                " estado =" +
                xhr.status +
                "respuesta =" +
                xhr.responseText
            );
            alert("ocurrio un error intente de nuevo");
          },
        });
}
  </script>

@endpush
