@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
- $countries
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
            <h6 class="title-store">{{ $title }}</h6>
<section class="mb-5">
    <form class="row gap-3" method="POST" action="{{ sc_route('customer.post_change_infomation') }}">
        @csrf
        @if (sc_config('customer_lastname'))
            <div class="col-12 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name"
                    >{{ sc_language_render('customer.first_name') }}</label>
                    <input id="first_name" type="text" class="form-control" name="first_name" 
                        value="{{ (old('first_name'))?old('first_name'):$customer['first_name']}}">

                    @if($errors->has('first_name'))
                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
            </div>
        
            <div class="col-12  {{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="last_name">{{ sc_language_render('customer.last_name') }}</label>
                    <input id="last_name" type="text" class="form-control" name="last_name" 
                        value="{{ (old('last_name'))?old('last_name'):$customer['last_name']}}">

                    @if($errors->has('last_name'))
                    <span class="help-block">{{ $errors->first('last_name') }}</span>
                    @endif
            </div>
        @else
            <div class="col-12  {{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name"
                    >{{ sc_language_render('customer.name') }}</label>

            
                    <input id="first_name" type="text" class="form-control" name="first_name" 
                        value="{{ (old('first_name'))?old('first_name'):$customer['first_name']}}">

                    @if($errors->has('first_name'))
                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
            </div>
        @endif

        @if (sc_config('customer_name_kana'))
            <div class="col-12  {{ $errors->has('first_name_kana') ? ' has-error' : '' }}">
                <label for="first_name_kana"
                    >{{ sc_language_render('customer.first_name_kana') }}</label>

                
                    <input id="first_name_kana" type="text" class="form-control" name="first_name_kana" 
                        value="{{ (old('first_name_kana'))?old('first_name_kana'):$customer['first_name_kana']}}">

                    @if($errors->has('first_name_kana'))
                    <span class="help-block">{{ $errors->first('first_name_kana') }}</span>
                    @endif  
            </div>
            <div class="col-12  {{ $errors->has('last_name_kana') ? ' has-error' : '' }}">
                <label for="last_name_kana">{{ sc_language_render('customer.last_name_kana') }}</label>
                <div>
                    <input id="last_name_kana" type="text" class="form-control" name="last_name_kana" 
                        value="{{ (old('last_name_kana'))?old('last_name_kana'):$customer['last_name_kana']}}">

                    @if($errors->has('last_name_kana'))
                    <span class="help-block">{{ $errors->first('last_name_kana') }}</span>
                    @endif
                </div>
            </div>
        @endif


        @if (sc_config('customer_phone'))
            <div class="col-12  {{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone" >{{ sc_language_render('customer.phone') }}</label>
                <div>
                    <input id="phone" type="text" class="form-control" name="phone" 
                        value="{{ (old('phone'))?old('phone'):$customer['phone']}}">

                    @if($errors->has('phone'))
                    <span class="help-block">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
            </div>
        @endif

        @if (sc_config('customer_postcode'))
            <div class="col-12  {{ $errors->has('postcode') ? ' has-error' : '' }}">
                <label for="postcode"
                    >{{ sc_language_render('customer.postcode') }}</label>

                <div >
                    <input id="postcode" type="text" class="form-control" name="postcode" 
                        value="{{ (old('postcode'))?old('postcode'):$customer['postcode']}}">

                    @if($errors->has('postcode'))
                    <span class="help-block">{{ $errors->first('postcode') }}</span>
                    @endif

                </div>
            </div>


        @endif

        

        {{-- <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email"
                >{{ sc_language_render('customer.email') }}</label>

            <div >
                {{ $customer['email'] }}

            </div>
        </div> --}}

        <div class="col-12  {{ $errors->has('address1') ? ' has-error' : '' }}">
            <label for="address1" >{{ sc_language_render('customer.address1') }}</label>
            <div>
                <input id="address1" type="text" class="form-control" name="address1" 
                    value="{{ (old('address1'))?old('address1'):$customer['address1']}}">
                @if($errors->has('address1'))
                    <span class="help-block">{{ $errors->first('address1') }}</span>
                @endif
            </div>
        </div>


        @if (sc_config('customer_address2'))
            <div class="col-12  {{ $errors->has('address2') ? ' has-error' : '' }}">
                <label for="address2">{{ sc_language_render('customer.address2') }}</label>
                <div>
                    <input id="address2" type="text" class="form-control" name="address2" 
                        value="{{ (old('address2'))?old('address2'):$customer['address2']}}">
                    @if($errors->has('address2'))
                    <span class="help-block">{{ $errors->first('address2') }}</span>
                    @endif
                </div>
            </div>
        @endif


        @if (sc_config('customer_address3'))
            <div class="col-12  {{ $errors->has('address3') ? ' has-error' : '' }}">
                <label for="address3">{{ sc_language_render('customer.address3') }}</label>
                <div>
                    <input id="address3" type="text" class="form-control" name="address3" 
                        value="{{ (old('address3'))?old('address3'):$customer['address3']}}">

                    @if($errors->has('address3'))
                    <span class="help-block">{{ $errors->first('address3') }}</span>
                    @endif
                </div>
            </div>
        @endif

        @if (sc_config('customer_country'))
        @php
        $country = (old('country'))?old('country'):$customer['country'];
        @endphp

        <div class="col-12  {{ $errors->has('country') ? ' has-error' : '' }}">
            <label for="country"
                >{{ sc_language_render('customer.country') }}</label>
            <div>
                <select class="form-control country" style="width: 100%;" name="country">
                    <option>__{{ sc_language_render('customer.country') }}__</option>
                    @foreach ($countries as $k => $v)
                    <option value="{{ $k }}" {{ ($country ==$k) ? 'selected':'' }}>{{ $v }}</option>
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

        <div id="redes_sociales" class="col-12 col-md-12 ">
            <h5 class="text-center fas fa-star">REDES SOCIALES</h5>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                  </svg>
                            </span>
                        </div>
                        <input name="re_facebook" value="{{ (old('re_facebook'))?old('re_facebook'):$customer['re_facebook']}}" type="text" class="form-control" placeholder="Ingrese la URL de su perfil de Facebook">
                        @if($errors->has('re_facebook'))
                            <span class="help-block">{{ $errors->first('re_facebook') }}</span>
                            @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-2">
                                <i class="fab fa-twitter"></i>
                            </span>
                        </div>
                       
                        <input name="re_Twitter" 
                        value="{{ (old('re_Twitter'))?old('re_Twitter'):$customer['re_Twitter']}}"
                         type="text" class="form-control" placeholder="Ingrese la URL de su perfil de Twitter">
                        @if($errors->has('re_Twitter'))
                            <span class="help-block">{{ $errors->first('re_Twitter') }}</span>
                            @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-2">
                                <i class="fab fa-instagram"></i>
                            </span>
                        </div>
                        
                        <input name="re_Instagram"
                         value="{{ (old('re_Instagram'))?old('re_Instagram'):$customer['re_Instagram']}}"
                          type="text" class="form-control" placeholder="Ingrese la URL de su perfil de Instagram">
                        @if($errors->has('re_Instagram'))
                            <span class="help-block">{{ $errors->first('re_Instagram') }}</span>
                            @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-2">
                                <i class="fab fa-linkedin"></i>
                            </span>
                        </div>
                       
                        
                        <input name="LinkedIn" value="{{ (old('LinkedIn'))?old('LinkedIn'):$customer['LinkedIn']}}"
                         type="text" class="form-control" placeholder="Ingrese la URL de su perfil de LinkedIn">
                        @if($errors->has('LinkedIn'))
                            <span class="LinkedIn">{{ $errors->first('LinkedIn') }}</span>
                            @endif
                    </div>
                </div>
            </div>
        </div>


        @if (sc_config('customer_sex'))
            @php
            $sex = old('sex')?old('sex'):$customer['sex'];
            @endphp
            <div class="col-12 {{ $errors->has('sex') ? ' has-error' : '' }}">
                <label for="sex"
                    >{{ sc_language_render('customer.sex') }}</label>

                <div >
                    <label class="radio-inline"><input value="0" type="radio" name="sex"
                        {{ ($sex == 0)?'checked':'' }}> {{ sc_language_render('customer.sex_women') }}</label>
                <label class="radio-inline"><input value="1" type="radio" name="sex"
                        {{ ($sex == 1)?'checked':'' }}> {{ sc_language_render('customer.sex_men') }}</label>

                    @if($errors->has('sex'))
                    <span class="help-block">{{ $errors->first('sex') }}</span>
                    @endif

                </div>
            </div>
        @endif

        @if (sc_config('customer_birthday'))
        <div class="col-12  {{ $errors->has('birthday') ? ' has-error' : '' }}">
            <label for="birthday"
                >{{ sc_language_render('customer.birthday') }}</label>

            <div >
                <input type="date" id="birthday" data-date-format="YYYY-MM-DD" class="form-control"
                    name="birthday" 
                    value="{{ (old('birthday'))?old('birthday'):$customer['birthday']}}">

                @if($errors->has('birthday'))
                <span class="help-block">{{ $errors->first('birthday') }}</span>
                @endif

            </div>
        </div>
        @endif

        


        {{-- Custom fields --}}
        @if (isset($customFields) && $customFields)
            @php
                $fields = $customer->getCustomFields()
            @endphp
            @foreach ($customFields as $keyField => $field)
            @php
                $default  = json_decode($field->default, true)
            @endphp
            <div class="col  kind   {{ $errors->has('fields.'.$field->code) ? ' text-red' : '' }}">
                <label for="{{ $field->code }}" class="col-sm-2 col-form-label">{{ sc_language_render($field->name) }}</label>
                
                <div class="">
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
                    <span class="help-block">
                        <i class="fa fa-info-circle"></i> {{ $errors->first('fields.'.$field->code) }}
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
        {{-- //Custom fields --}}

        <div class="col-12">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    {{ sc_language_render('customer.update_infomation') }}
                </button>
            </div>
        </div>
    </form>
</section>
@endsection
