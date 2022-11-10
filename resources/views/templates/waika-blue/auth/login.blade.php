@extends($sc_templatePath.'.layout')

@section('block_main')
<!--form-->
<section class="p-0 section section-sm section-first bg-default text-md-left">
    <div class="container">
    <div class="row">
        <div class="col-12 col-md-6 m-auto">
          
            <div class="row align-items-center flex-column">
                <div class="col text-center">
                    <img width="200px" class="img-fluid" src="/images/logo2.png" alt="">
                </div>
                <div class="col ">
                    <h4 class="text-center">{{ sc_language_render('customer.title_login') }}</h4>
                </div>

            </div>
            <form action="{{ sc_route('postLogin') }}" method="post" class="box">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">{{ sc_language_render('customer.email') }}</label>
                    <input class="is_required validate account_input form-control {{ ($errors->has('email'))?"input-error":"" }}"
                        type="text" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">{{ sc_language_render('customer.password') }}</label>
                    <input class="is_required validate account_input form-control {{ ($errors->has('password'))?"input-error":"" }}"
                        type="password" name="password" value="">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        {{ $errors->first('password') }}
                    </span>
                    @endif
            
                </div>

                <button type="submit" name="SubmitLogin" class="button button-lg button-secondary w-100">{{ sc_language_render('front.login') }}</button>
                @if (!empty(sc_config('LoginSocialite')))
                    <ul>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ sc_route('login_socialite.index', ['provider' => 'facebook']) }}"><i class="fab fa-facebook"></i>
                         {{ sc_language_render('front.login') }} facebook</a>
                    </li>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ sc_route('login_socialite.index', ['provider' => 'google']) }}"><i class="fab fa-google-plus"></i>
                         {{ sc_language_render('front.login') }} google</a>
                    </li>
                    <li class="rd-dropdown-item">
                      <a class="rd-dropdown-link" href="{{ sc_route('login_socialite.index', ['provider' => 'github']) }}"><i class="fab fa-github"></i>
                         {{ sc_language_render('front.login') }} github</a>
                    </li>
                    </ul>
                @endif
                
               
            </form>
            <div class="d-flex align-items-center">
                
                    <div class="col">
                        <a class="btn btn-link" href="{{ sc_route('forgot') }}">
                            {{ sc_language_render('customer.password_forgot') }}
                        </a>
                    </div>
                   
                   
                
                
                    <div class="col">
                        <a class="btn btn-link" href="{{ sc_route('register') }}">
                            {{ sc_language_render('customer.title_register') }}
                        </a>
                    </div>
                
            </div>
        </div>
    </div>
</div>
</section>
<!--/form-->
@endsection