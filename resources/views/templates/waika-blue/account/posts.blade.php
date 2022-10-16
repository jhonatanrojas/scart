


@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    
    <div class="container  ">

      <div class="row  ">
        <div class="col-12 col-sm-12 col-md-6">
          @include($sc_templatePath.'.account.nav_customer')
        </div>
        <div class="">
        
            <form action="{{route('enviar_document')}}"  method="post" enctype="multipart/form-data">
                @csrf
                
                <div class=" ">
                    
                  
                    
                    <div class="form-group  row {{ $errors->has('image') ? ' text-red' : '' }}">
                        <label for="image" class="col-sm-2 col-form-label">Cedula</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input readonly type="text" id="cedula" name="cedula" value="{{ old('cedula',$banner['cedula']??'') }}" class="form-control image" placeholder=""  />
                                <div class="input-group-append">
                                 <a data-input="cedula" data-preview="cedula" data-type="cedula" class="btn btn-primary lfm">
                                   <i class="fa fa-image"></i> {{sc_language_render('product.admin.choose_image')}}
                                 </a>
                                </div>
                            </div>
                                @if ($errors->has('image'))
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                    </span>
                                @endif
                            <div id="cedula" class="img_holder">
                                @if (old('cedula',$banner['cedula']??''))
                                <img width="20%" src="{{ sc_file(old('cedula',$banner['cedula']??'')) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                  
    
                  
                    
                </div>
                
                <div class=" ">
                    
                    
                    <div class="form-group  row {{ $errors->has('image') ? ' text-red' : '' }}">
                        <label for="image" class="col-sm-2 col-form-label">Rif</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input readonly type="text" id="rif" name="rif" value="{{ old('rif',$banner['rif']??'') }}" class="form-control image" placeholder=""  />
                                <div class="input-group-append">
                                 <a data-input="rif" data-preview="preview_image" data-type="rif" class="btn btn-primary lfm">
                                   <i class="fa fa-image"></i> {{sc_language_render('product.admin.choose_image')}}
                                 </a>
                                </div>
                            </div>
                                @if ($errors->has('image'))
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                    </span>
                                @endif
                            {{-- <div id="preview_image" class="img_holder">
                                @if (old('rif',$banner['rif']??''))
                                <img src="{{ sc_file(old('rif',$banner['rif']??'')) }}">
                                @endif
                            </div> --}}
                        </div>
                    </div>
                  
    
                  
                    
                </div>
                <div class="d-flex  ">
         
                    <div class="form-group  row {{ $errors->has('image') ? ' text-red' : '' }}">
                        <label for="image" class="col-sm-2 col-form-label">constancia de trabajo</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input readonly type="text" id="image" name="image" value="{{ old('image',$banner['image']??'') }}" class="form-control image" placeholder=""  />
                                <div class="input-group-append">
                                 <a data-input="image" data-preview="preview_image" data-type="images" class="btn btn-primary lfm">
                                   <i class="fa fa-image"></i> {{sc_language_render('product.admin.choose_image')}}
                                 </a>
                                </div>
                            </div>
                                @if ($errors->has('image'))
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                    </span>
                                @endif
                            {{-- <div id="preview_image" class="img_holder">
                                @if (old('image',$banner['image']??''))
                                <img src="{{ sc_file(old('image',$banner['image']??'')) }}">
                                @endif
                            </div> --}}
                        </div>
                    </div>
    
                  
                    
                </div>

                <div class="mt-3 m-auto text-center">
                    <button id="guarda"  class="btn btn-primary">guardar</button>

                </div>
                <input  accept=".png, .jpg, .jpeg" type="hidden" name="first_name" value="{{$customer['first_name']}}">
                <input type="hidden" name="id_usu" value="{{$customer['id']}}">
                <input type="hidden" name="email" value="{{$customer['email']}}">
                <input type="hidden" name="phone" value="{{ $customer['phone'] }}">

               
    
               
            </form>
        </div>


</div>
</section>
@vite('resources/js/adjuntar_document.js')


@endsection