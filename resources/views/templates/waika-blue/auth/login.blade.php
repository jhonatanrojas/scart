@extends($sc_templatePath.'.layout')

@section('block_main')
<!--form-->
<section class=" section section-sm section-first bg-default text-md-left animate__animated animate__fadeIn">
    <div class="container">
        <div class="container  h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
              <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                  <div class="card-body p-5 text-center">
        
                    <div class="row align-items-center flex-column">
                        <div class="col text-center">
                            <img width="200px" class="img-fluid" src="/images/logo_loging.jpg"  alt="Logo">
                        </div>
                        <div class="col ">
                            <h4 class="text-center">{{ sc_language_render('customer.title_login') }}</h4>
                        </div>
        
                    </div>

                    <form action="{{ sc_route('postLogin') }}" method="post" class="box">
                        {!! csrf_field() !!}
                        <div class="form-outline mb-4">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{-- <label for="email" class="control-label">{{ sc_language_render('customer.email') }}</label> --}}
                            <input class="is_required validate account_input form-control {{ ($errors->has('email'))?"input-error":"" }}"
                                type="text" name="email" placeholder="Correo electrónico" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{-- <label for="password" class="control-label">{{ sc_language_render('customer.password') }}</label> --}}
                            <input class="is_required validate account_input form-control {{ ($errors->has('password'))?"input-error":"" }}"
                                type="password" placeholder="contraseña" name="password" value="">
                            @if ($errors->has('password'))
                            <span class="help-block">
                                {{ $errors->first('password') }}
                            </span>
                            @endif
                            
                    
                        </div>
                        <button type="submit " name="SubmitLogin" class="btn btn-primary btn-lg btn-block w-100 m-0">{{ sc_language_render('front.login') }}</button>
        
                   
                      
                            
                       
                        
                       
                    </form>
        
                    <hr class="my-2">
                    @if (empty(sc_config('LoginSocialite')))
                        
                        <div class="row justify-content-between">
                               <div class="col-md-3">
                                <a target="blanck" href="https://www.instagram.com/waikaimport/"  class="btn btn-link btn-floating mx-1"
                                type="submit"><i class="icon mdi mdi-instagram me-2"></i> instagram</a>
                               </div>

                               <div class="col-md-3">
                                <a href="https://www.facebook.com/people/Waikaimport-CA/100080342899840/" class="btn btn-link btn-floating mx-1"
                                type="submit"><i class="fab fa-facebook me-2"></i> facebook</a>
                               </div>

                               <div class="col-md-3">
                                <a target="blanck" href="https://api.whatsapp.com/send?phone=584126354041&text=%20Estoy%20interesado%20en%20un%20producto" class="btn btn-link btn-floating mx-1" 
                                ><i class="fab fa-whatsapp me-2"></i> whatsapp</a>
                               </div>
                        
    
                         
    
                            </div>

                        
                     
                      @endif

                      <div class=" mt-2">
                
                        <div class="col-12 col-md-12">
                            <a class="btn btn-link" href="{{ sc_route('forgot') }}">
                                {{ sc_language_render('customer.password_forgot') }}
                            </a>
                        </div>
                       
                       
                    
                    
                        <div class="col-12 col-md-12">
                            <a class="btn btn-link" href="{{ sc_route('register') }}">
                                {{ sc_language_render('customer.title_register') }}
                            </a>
                        </div>
                    
                </div>
        
                  </div>
                </div>
              </div>
            </div>
          </div>
    {{-- <div class="row">
        <div class="col-12 col-md-6 m-auto">
          
            <div class="row align-items-center flex-column">
                <div class="col text-center">
                    <img width="200px" class="img-fluid" src="/images/logo_loging.jpg"  alt="Logo">
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
                <button type="submit " name="SubmitLogin" class=" button  button-secondary w-100 m-0">{{ sc_language_render('front.login') }}</button>

           
                @if (empty(sc_config('LoginSocialite')))
                    <ul class="row">
                    <li class="rd-dropdown-item col-12 col-md-4">
                      <a class="btn btn-link" href="https://www.facebook.com/people/Waikaimport-CA/100080342899840/"><i class="fab fa-facebook"></i>
                          facebook</a>
                    </li>
                    <li class="rd-dropdown-itemcol-12 col-md-4">
                      <a class="btn btn-link" target="blanck" href="https://www.instagram.com/waikaimport/"><i class="icon mdi mdi-instagram"></i>
                          instagram</a>
                    </li>
                    <li class="btn btn-link col-12 col-md-4">
                      <a class="rd-dropdown-link" target="blanck" href="https://l.instagram.com/?u=https%3A%2F%2Fwa.link%2Fyhz51u&e=ATPzNMZbjg4XZlDLpIlk0xL17fvTKx6-P_Lm6o8upk1GLRhsj1LvFWLwuPw_iyvpz3OREpBiMbif5NdY1ViRry4&s=1"><i class="fab fa-whatsapp"></i>
                          whatsapp</a>
                    </li>
                    </ul>
                @endif
                
               
            </form>
            <div class="d-flex align-items-center mt-2">
                
                    <div class="col-12 col-md-6">
                        <a class="btn btn-link" href="{{ sc_route('forgot') }}">
                            {{ sc_language_render('customer.password_forgot') }}
                        </a>
                    </div>
                   
                   
                
                
                    <div class="col-12 col-md-6">
                        <a class="btn btn-link" href="{{ sc_route('register') }}">
                            {{ sc_language_render('customer.title_register') }}
                        </a>
                    </div>
                
            </div>
        </div>
    </div> --}}
</div>
</section>
<!--/form-->
@endsection