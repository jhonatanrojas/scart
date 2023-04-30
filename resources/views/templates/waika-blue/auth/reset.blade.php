@php
/*
$layout_page = shop_auth
$token 
$email
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ sc_route('password.request') }}" aria-label="{{ sc_language_render('customer.password_reset') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row">
                            <div class="col-12">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ sc_language_render('customer.email') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <div class="col-12">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ sc_language_render('customer.password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-12">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ sc_language_render('customer.password_confirm') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="button button-lg button-secondary">
                                    {{ sc_language_render('customer.password_reset') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
