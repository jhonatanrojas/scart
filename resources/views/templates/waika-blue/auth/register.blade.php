
@extends($sc_templatePath.'.layout')

@section('block_main')
<!--form-->
<section class="mb-4">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">{{ sc_language_render('customer.title_register') }}</h2>
                <form action="{{sc_route('postRegister')}}" method="post" class="box  " id="form-process">
                    <div class="row g-3">

                        {!! csrf_field() !!}


                        @if (sc_config('customer_natural_jurídica'))
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('natural_jurídica') ? ' has-error' : '' }}">
                            
                                <label for="natural_jurídica"> Tipo de persona</label>
                                <select required  
                                class="is_required validate account_input form-select {{ ($errors->has('natural_jurídica'))?"input-error":"" }}"
                                name="natural_jurídica" id="natural_jurídica">
                                    <option value="N"  selected>Natural</option>
                                    <option value="J" >Juridica</option>
                                </select>
                        
                                @if ($errors->has('natural_jurídica'))
                                    <span class="help-block">
                                        {{ $errors->first('natural_jurídica') }}
                                    </span>
                                @endif
                        
                                </div>
                            </div>
                        @endif

                
                        @if (sc_config('customer_nacionalidad'))
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('nacionalidad') ? ' has-error' : '' }}">
                                    <label for="nacionalidad">Nacionalidad</label>
                                    <select  type="text"
                                    class="is_required validate account_input form-select {{ ($errors->has('nacionalidad'))?"input-error":"" }}"
                                    name="nacionalidad" id="nacionalidad">
            
                                    <option value="">Seleccióna un nacionalidad</option>
                                    <option selected value="V" {{ (old('nacionalidad')) ? 'selected':'' }}>Venezolano(a)</option>
                                    <option value="E" {{ (old('nacionalidad')) ? 'selected':'' }}>Extranjero(a)</option>
                                    
                                
                                    </select>
                                    @if ($errors->has('nacionalidad'))
                                    <span class="help-block">
                                        {{ $errors->first('nacionalidad') }}
                                    </span>
                                    @endif
                                </div>
                            
                            </div>
                        @endif

                        @if (sc_config('customer_razon_social'))
                            <div class="col-md-6 oculta_razon_social">
                                <div class="form-group {{ $errors->has('razon_social') ? ' has-error' : '' }} ">
                                    <input required disabled="true" type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('razon_social'))?"input-error":"" }}"
                                        name="razon_social" id="razon_social" placeholder="Razon social"
                                        value="{{ old('razon_social') }}">

                                    @if ($errors->has('razon_social'))
                                    <span class="help-block">
                                        {{ $errors->first('razon_social') }}
                                    </span>
                                    @endif
                                </div>
                            
                            </div>
                        @endif

                        @if (sc_config('customer_rif'))
                            <div class="col-md-6 oculta_rif">
                                <div class="form-group {{ $errors->has('rif') ? ' has-error' : '' }}">
                                    <input disabled="true" required type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('rif'))?"input-error":"" }}"
                                        name="rif" id="rif" placeholder="Rif"
                                        value="{{ old('rif') }}">

                                    @if ($errors->has('rif'))
                                    <span class="help-block">
                                        {{ $errors->first('rif') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div style="display: none;" class="col-12 text-center title mb-2">
                                <h5>Datos del representante legal</h5>
                            </div>
                        @endif

                        @if (sc_config('customer_cedula'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('cedula') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('cedula'))?"input-error":"" }}"
                                        name="cedula" id="cedula" placeholder="{{ sc_language_render('customer.cedula') }}"
                                        value="{{ old('cedula') }}">

                                    @if ($errors->has('cedula'))
                                    <span class="help-block">
                                        {{ $errors->first('cedula') }}
                                    </span>
                                    @endif
                                </div>
                            
                            </div>

                        @if (sc_config('customer_estado_civil'))
                            <div class=" col-md-6 ">
                                <div class="form-group {{ $errors->has('estado_civil') ? ' has-error' : '' }}">
                                    <select required  type="text"
                                    class="is_required validate account_input form-select "
                                    name="estado_civil" id="estado_civil">
                                        <option value="" >Estado civil</option>

                                        <option value="SOLTERO(a)" >Soltero(a)</option>
                                        <option value="CASADO(a)" >Casado(a)</option>

                                        <option value="DIVORCIADO(a)" >DIVORCIADO(a)</option>
                                        <option value="VIUDO(a)" >VIUDO(a)</option>
                                        <option value="CONCUBINATO(a)" >Concubinato</option>
                                    </select>
                                    @if ($errors->has('estado_civil'))
                                    <span class="help-block">
                                        {{ $errors->first('estado_civil') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('first_name'))?"input-error":"" }}"
                                        name="first_name" placeholder="{{ sc_language_render('customer.first_name') }}"
                                        value="{{ old('first_name') }}">
                                    @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        {{ $errors->first('first_name') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('last_name'))?"input-error":"" }}"
                                        name="last_name" placeholder="{{ sc_language_render('customer.last_name') }}" value="{{ old('last_name') }}">
                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        {{ $errors->first('last_name') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <input type="text"
                                            class="is_required validate account_input form-control {{ ($errors->has('first_name'))?"input-error":"" }}"
                                            name="first_name" placeholder="{{ sc_language_render('customer.name') }}" value="{{ old('first_name') }}">
                                        @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            {{ $errors->first('first_name') }}
                                        </span>
                                        @endif
                                    </div>
                            </div>
                        @endif
                
                        @if (sc_config('customer_name_kana'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('first_name_kana') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('first_name_kana'))?"input-error":"" }}"
                                        name="first_name_kana" placeholder="{{ sc_language_render('customer.first_name_kana') }}"
                                        value="{{ old('first_name_kana') }}">
                                    @if ($errors->has('first_name_kana'))
                                    <span class="help-block">
                                        {{ $errors->first('first_name_kana') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group{{ $errors->has('last_name_kana') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('last_name_kana'))?"input-error":"" }}"
                                        name="last_name_kana" placeholder="{{ sc_language_render('customer.last_name_kana') }}" value="{{ old('last_name_kana') }}">
                                    @if ($errors->has('last_name_kana'))
                                    <span class="help-block">
                                        {{ $errors->first('last_name_kana') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="text"
                                    class="is_required validate account_input form-control {{ ($errors->has('email'))?"input-error":"" }}"
                                    name="email" placeholder="{{ sc_language_render('customer.email') }}" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        {{ $errors->first('email') }}
                                    </span>
                                    @endif
                            </div>
                        </div>
                
                        @if (sc_config('customer_phone'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('phone'))?"input-error":"" }}"
                                        name="phone" placeholder="{{ sc_language_render('customer.phone') }}" value="{{ old('phone') }}">
                                    @if ($errors->has('phone'))
                                    <span class="help-block">
                                        {{ $errors->first('phone') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (sc_config('customer_phone2'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('phone2'))?"input-error":"" }}"
                                        name="phone2" placeholder="telefono2" value="{{ old('phone2') }}">
                                    @if ($errors->has('phone2'))
                                    <span class="help-block">
                                        {{ $errors->first('phone2') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                
                        @if (sc_config('customer_estado'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
                                    <select    type="text"
                                    class="is_required validate account_input form-select {{ ($errors->has('estado'))?"input-error":"" }}"
                                    name="cod_estado" id="cod_estado"   >
            
                                    <option  value="0">Seleccióna un Estado</option>
            
                                    @foreach ($estado as $estados)
                                    
                                    <option 
                                    data-latitud={{$estados->latitud}} 
                                    data-longitud={{$estados->longitud}}
                                    value="{{ $estados->codigoestado }}" {{ (old('cod_estado')) ? 'selected':'' }}
                                    >
                                    {{$estados->nombre}}
                                    </option>           
                                    @endforeach                
                                </select>
                                    @if ($errors->has('cod_estado'))
                                    <span class="help-block">
                                        {{ $errors->first('cod_estado') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if (sc_config('customer_municipio'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('cod_municipio') ? ' has-error' : '' }}">
                                    <select  type="text"
                                    class="is_required validate account_input form-select {{ ($errors->has('cod_municipio'))?"input-error":"" }}"
                                    name="cod_municipio" id="cod_municipio">
            
                                    <option value="">Seleccióna un Municipio</option>
                                    
                                
                                </select>
                                    @if ($errors->has('cod_municipio'))
                                    <span class="help-block">
                                        {{ $errors->first('cod_municipio') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (sc_config('customer_parroquias'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('parroquias') ? ' has-error' : '' }}">
                                    <div class="form-group{{ $errors->has('parroquias') ? ' has-error' : '' }}">
                                    <select required  type="text"
                                    class="is_required validate account_input form-select {{ ($errors->has('parroquias'))?"input-error":"" }}"
                                    name="cod_parroquia" id="cod_parroquia" >
            
                                    <option value="">Seleccióna una parroquias</option>
                                    
                                
                                </select>
                                    @if ($errors->has('parroquias'))
                                    <span class="help-block">
                                        {{ $errors->first('parroquias') }}
                                    </span>
                                    @endif
                                </div>
                                </div>
                            </div>
                        @endif

                        @if (sc_config('customer_postcode'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('postcode'))?"input-error":"" }}"
                                        name="postcode" placeholder="{{ sc_language_render('customer.postcode') }}" value="{{ old('postcode') }}">
                                    @if ($errors->has('postcode'))
                                    <span class="help-block">
                                        {{ $errors->first('postcode') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                
                        <div class="col-md-6">
                        <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                            <input type="text"
                                class="is_required validate account_input form-control {{ ($errors->has('address1'))?"input-error":"" }}"
                                name="address1" placeholder="{{ sc_language_render('customer.address1') }}" value="{{ old('address1') }}">
                            @if ($errors->has('address1'))
                            <span class="help-block">
                                {{ $errors->first('address1') }}
                            </span>
                            @endif
                        </div>
                        </div>

                        @if (sc_config('customer_address2'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('address2'))?"input-error":"" }}"
                                        name="address2" placeholder="{{ sc_language_render('customer.address2') }}" value="{{ old('address2') }}">
                                    @if ($errors->has('address2'))
                                    <span class="help-block">
                                        {{ $errors->first('address2') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                
                        @if (sc_config('customer_address3'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('address3') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('address3'))?"input-error":"" }}"
                                        name="address3" placeholder="{{ sc_language_render('customer.address3') }}" value="{{ old('address3') }}">
                                    @if ($errors->has('address3'))
                                    <span class="help-block">
                                        {{ $errors->first('address3') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (sc_config('customer_company'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                    <input type="text"
                                        class="is_required validate account_input form-control {{ ($errors->has('company'))?"input-error":"" }}"
                                        name="company" placeholder="{{ sc_language_render('customer.company') }}" value="{{ old('company') }}">
                                    @if ($errors->has('company'))
                                    <span class="help-block">
                                        {{ $errors->first('company') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                
                        @if (sc_config('customer_country'))
                            <div class="col-md-6">
                                <div class="form-group  {{ $errors->has('country') ? ' has-error' : '' }}">
                                    <select class="form-select country" style="width: 100%;" name="country">
                                        <option>__{{ sc_language_render('customer.country') }}__</option>
                                        @foreach ($countries as $k => $v)
                                        <option value="{{ $k }}" {{ (old('country') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                    <span class="help-block">
                                        {{ $errors->first('country') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (sc_config('customer_birthday'))
                            <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                <input type="date"
                                    class="is_required validate account_input form-control {{ ($errors->has('birthday'))?"input-error":"" }}"
                                    name="birthday" data-date-format="YYYY-MM-DD" placeholder="{{ sc_language_render('customer.birthday') }}"
                                    value="{{ old('birthday','2015-08-09') }}">
                                @if ($errors->has('birthday'))
                                <span class="help-block">
                                    {{ $errors->first('birthday') }}
                                </span>
                                @endif
                            </div>
                        @endif
                
                        @if (sc_config('customer_group'))
                            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                <input type="text"
                                    class="is_required validate account_input form-control {{ ($errors->has('group'))?"input-error":"" }}"
                                    name="group" placeholder="{{ sc_language_render('customer.group') }}" value="{{ old('group') }}">
                                @if ($errors->has('group'))
                                <span class="help-block">
                                    {{ $errors->first('group') }}
                                </span>
                                @endif
                            </div>
                        @endif
                        
                

                    
                        {{-- Custom fields --}}
                        @if ($customFields)
                                            @foreach ($customFields as $keyField => $field)
                                            <div class="form-group{{ $errors->has('fields.'.$field->code) ? ' has-error' : '' }}">
                                            @php
                                                $default  = json_decode($field->default, true);
                                            @endphp
                                                    @if ($field->option == 'radio')
                                                        @if ($default)
                                                            <b>{{ sc_language_render($field->name) }}:</b> 
                                                            @foreach ($default as $key => $name)
                                                            <div>
                                                                <input type="radio" id="{{ $keyField.'__'.$key }}" name="fields[{{ $field->code }}]" value="{{ $key }}" {{ (old('fields.'.$field->code) == $key)?'checked':'' }}>
                                                                <label for="{{ $keyField.'__'.$key }}">
                                                                    {{ $name }}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    @elseif($field->option == 'select')
                                                        @if ($default)
                                                        <select required class="form-control input-sm {{ $field->code }}" style="width: 100%;"
                                                            name="fields[{{ $field->code }}]">
                                                            <option value="">{{ sc_language_render($field->name) }}</option>
                                                            @foreach ($default as $key => $name)
                                                            <option value="{{ $key }}" {{ (old('fields.'.$field->code) == $key) ? 'selected':'' }}>
                                                                {{ $name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @endif
                                                    @else
                                                        <input type="text"
                                                            class="is_required validate account_input form-control {{ ($errors->has('fields.'.$field->code))?"input-error":"" }}"
                                                            name="fields[{{ $field->code }}]" placeholder="{{ sc_language_render($field->name) }}" value="{{ old('fields.'.$field->code) }}">
                                                    @endif

                                                    @if ($errors->has('fields.'.$field->code))
                                                    <span class="help-block">
                                                        <i class="fa fa-info-circle"></i> {{ $errors->first('fields.'.$field->code) }}
                                                    </span>
                                                    @endif
                                            </div>
                                            @endforeach
                        @endif
                        {{-- //Custom fields --}}

                        @if (sc_config('customer_nos_conocio'))
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nos_conocio') ? ' has-error' : '' }}">
                                    <select required  type="text"
                                    class="is_required validate account_input form-select {{ ($errors->has('nos_conocio'))?"input-error":"" }}"
                                    name="nos_conocio" id="nos_conocio">

                                    <option value="">¿COMO NOS CONOCISTE?</option>
                                    <option value="facebook" {{ (old('Facebook')) ? 'selected':'' }}>Facebook</option>
                                    <option value="instagram" {{ (old('instagram')) ? 'selected':'' }}>instagram</option>
                                    <option value="twitter" {{ (old('Twitter')) ? 'selected':'' }}>Twitter</option>
                                    <option value="amigo" {{ (old('Amigo')) ? 'selected':'' }}>Amigo</option>
                                    
                                
                                    </select>
                                    @if ($errors->has('nos_conocio'))
                                    <span class="help-block">
                                        {{ $errors->first('nos_conocio') }}
                                    </span>
                                    @endif
                                </div>
                            
                            </div>
                        @endif


                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password"
                                    class="is_required validate account_input form-control {{ ($errors->has('password'))?"input-error":"" }}"
                                    name="password" placeholder="{{ sc_language_render('customer.password') }}" value="">
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                        
                        <div class=" {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input type="password"
                                class="is_required validate account_input form-control {{ ($errors->has('password_confirmation'))?"input-error":"" }}"
                                placeholder="{{ sc_language_render('customer.password_confirm') }}" name="password_confirmation" value="">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                            @endif
                        </div>
                        </div>

                        @if (sc_config('customer_sex'))
                            <div class="col-md-6">
                                <div class="{{ $errors->has('sex') ? ' has-error' : '' }}">
                                    <label class="validate account_input {{ ($errors->has('sex'))?"input-error":"" }}">
                                        {{ sc_language_render('customer.sex') }}:
                                    </label>
                                    <div class="form-check form-check-inline">
                                        <input value="0" type="radio" name="sex" id="radio_f" {{ (old('sex') == 0)?'checked':'' }}>
                                        <label class="radio-inline" for="radio_f">
                                            {{ sc_language_render('customer.sex_women') }}
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input value="1" type="radio" name="sex" id="radio_m" {{ (old('sex') == 1)?'checked':'' }}>
                                        <label class="radio-inline" for="radio_m">
                                            {{ sc_language_render('customer.sex_men') }}
                                        </label>
                                    </div>
                                    
                                    @if ($errors->has('sex'))
                                        <span class="help-block">
                                            {{ $errors->first('sex') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {!! $viewCaptcha ?? ''!!}
                        <div class="col-12">
                            <div class="submit d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block" id="button-form-process">{{ sc_language_render('customer.signup') }}</button>
                            </div>
                        </div>  
                        <div class="col-12 col-md-12 text-center">
                                ¿Ya te encuentras Registrado?
                            <a class="text-decoration-none" href="{{ sc_route('login') }}">Iniciar Sesion</a>
                        </div>
                    
                    </div>  
                </form>
            </div>
        </div>
    </div>
</section>
<!--/form-->
@endsection
