


@extends($sc_templatePath.'.layout')


@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    
    <div class="container  ">

      <div class="row ">
        <div class="col-12 col-sm-12 col-md-4">
          @include($sc_templatePath.'.account.nav_customer')
        </div>
        <div class="">
        
            <form action="{{route('enviar_document')}}"  method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="d-flex align-items-center ">
                    
                        <img width="20%" class="img-fluid" src="../images/cedula-icon.png" alt="cedula">
         
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="cedula" name="cedula"
                                    value="{{ old('image',$category['image']??'') }}"
                                    class="form-control input image" placeholder="" />
                                <div class="input-group-append">
                                    <a data-input="image" data-preview="preview_image" data-type="category"
                                        class="btn btn-primary lfm">
                                        <i class="fa fa-image"></i> {{sc_language_render('product.admin.choose_image')}}
                                    </a>
                                </div>
                            </div>
                            @if ($errors->has('image'))
                            <span class="form-text">
                                <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                            </span>
                            @endif
                            <div id="preview_image" class="img_holder">
                                @if (old('image',$category['image']??''))
                                <img src="{{ sc_file(old('image',$category['image']??'')) }}">
                                @endif
        
                            </div>
                        </div>
                  
    
                  
                    
                </div>
                
                <div class="d-flex m-2 align-items-center">
                  
                        <img width="20%" src="../images/cedula-icon.png" alt="cedula">
                
                    
    
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="rif" name="rif"
                                    value="{{ old('image',$category['image']??'') }}"
                                    class="form-control input image" placeholder="" />
                                <div class="input-group-append">
                                    <a data-input="image" data-preview="preview_image" data-type="category"
                                        class="btn btn-primary lfm">
                                        <i class="fa fa-image"></i> {{sc_language_render('product.admin.choose_image')}}
                                    </a>
                                </div>
                            </div>
                            @if ($errors->has('image'))
                            <span class="form-text">
                                <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                            </span>
                            @endif
                            <div id="preview_image" class="img_holder">
                                @if (old('image',$category['image']??''))
                                <img src="{{ sc_file(old('image',$category['image']??'')) }}">
                                @endif
        
                            </div>
                        </div>
                    <div id="preview3"></div>
                </div>
                <div class="d-flex  align-items-center">
                
                        <img width="20%" src="../images/cedula-icon.png" alt="cedula">
                        
             
                    

                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="contacia" name="contacia"
                                    value="{{ old('image',$category['image']??'') }}"
                                    class="form-control input image" placeholder="" />
                                <div class="input-group-append">
                                    <a data-input="image" data-preview="preview_image" data-type="category"
                                        class="btn btn-primary lfm">
                                        <i class="fa fa-image"></i> {{sc_language_render('product.admin.choose_image')}}
                                    </a>
                                </div>
                            </div>
                            @if ($errors->has('image'))
                            <span class="form-text">
                                <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                            </span>
                            @endif
                            <div id="preview_image" class="img_holder">
                                @if (old('image',$category['image']??''))
                                <img src="{{ sc_file(old('image',$category['image']??'')) }}">
                                @endif
        
                            </div>
                        </div>
                       
                        <div id="preview2"></div>
                   
                    
                    
                    
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

@push('styles')

@endpush

@push('scripts')
@endpush
@endsection