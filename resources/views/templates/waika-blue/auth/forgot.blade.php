@php
/*
$layout_page = shop_auth
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="my-4" style="min-height: 400px;">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <h2>{{ sc_language_render('customer.password_forgot') }}</h2>

            <form class="container" method="POST" action="{{ sc_route('password.email') }}" id="form-process">
                {{ csrf_field() }}
                <div class="row gap-3">
                    <div class="col-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">{{ sc_language_render('customer.email') }}</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            {!! $viewCaptcha ?? ''!!}
                    </div>
                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" name="SubmitLogin" class="btn btn-primary" id="button-form-process">{{ sc_language_render('action.submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</section>

@endsection