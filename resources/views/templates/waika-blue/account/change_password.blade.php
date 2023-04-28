@php
/*
$layout_page = shop_profile
**Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
    <h6 class="title-store">{{ $title }}</h6>

            <form class="row gap-3" method="POST" action="{{ sc_route('customer.post_change_password') }}">
                @csrf

                <div class="col-12 {{ Session::has('password_old_error') ? ' has-error' : '' }}">
                    <label for="password"
                        class="">{{ sc_language_render('customer.password_old') }}</label>
                        <input id="password" type="password" class="form-control" name="password_old" required>
                        @if(Session::has('password_old_error'))
                        <span class="help-block">{{ Session::get('password_old_error') }}</span>
                        @endif

                </div>

                <div class="col-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password"
                        class="">{{ sc_language_render('customer.password_new') }}</label>
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                </div>

                <div class="col-12">
                    <label for="password-confirm"
                        class="">{{ sc_language_render('customer.password_confirm') }}</label>
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required>
                </div>

                <div class="col-12 mb-0">
                        <button type="submit" class="btn btn-primary">
                            {{ sc_language_render('customer.update_infomation') }}
                        </button>
                </div>
            </form>
@endsection