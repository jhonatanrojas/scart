


@extends($sc_templatePath.'.layout')
{{-- <?= dd($documentos)?> --}}

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    
    <div class="container  ">
       

      <div class="row ">
        <div class="col-12 col-md-12">
            <div class=" text-center ">
                @if (isset($mensaje) && $mensaje != "")
                <div class="alert alert-danger">
                   <span class="h6"> {{ $mensaje }} </span>
                </div>
                @endif
            </div>
        </div>
    
        <div class="col-12  col-md-4">
          @include($sc_templatePath.'.account.nav_customer')
        </div>

        <div class="col-12 col-md-8">
        
            <div class="row m-auto">
            <form action="{{route('enviar_document')}}"  method="post" enctype="multipart/form-data">
           
                @csrf
                
            

                   
                       
                        <div class="col-md-12">
                            <div class="input-group">
                                <label for="image" class="col-sm-12 col-form-label fa fa-id-card-o  fs-4 ">Cedula</label>
                                <input readonly type="text" id="cedula" name="cedula" value="{{ old('cedula',$documentos[0]['cedula'] ??'') }}" class="form-control image" placeholder="Adjuntar cedula"  />
                                <div class="input-group-append">
                                 <a data-input="image" data-preview="cedula" data-type="file" class="btn btn-primary lfm">
                                   <i class="fa fa-image"></i>
                                 </a>
                                </div>
                            </div>
                        @error('cedula')
                            <small style="color: red">{{$message}}</small>
                        @enderror
                        <div style="border: solid 1px rgba(78, 78, 78, 0.466" id="cedula" class="img_holder">
                            @if (old('cedula',$documentos[0]['cedula']??''))
                            <img src="{{ sc_file(old('image',$documentos[0]['cedula']??'')) }}">
                            @endif
                        </div>
                        </div>
                  
                  
    
                  
             
 
                    
                  
                       
                        <div class="col-md-12">
                            <div class="input-group">
                                <label for="rif" class="col-sm-12 col-form-label fa fa-list-alt ">Rif</label>
                                <input readonly type="text" id="rif" name="rif" value="{{ old('rif',$documentos[0]['rif'] ??'') }}" class="form-control image" placeholder="Adjuntar Rif"  />
                                <div class="input-group-append">
                                 <a data-input="rif" data-preview="rif" data-type="rif" class="btn btn-primary lfm">
                                   <i class="fa fa-image"></i>
                                 </a>
                                </div>
                            </div>
                            @error('rif')
                            <small style="color: red">{{$message}}</small>
                        @enderror
                        <div style="border: solid 1px rgba(78, 78, 78, 0.466" id="rif" class="img_holder">
                            @if (old('rif',$documentos[0]['rif']??''))
                            <img  src="{{ sc_file(old('rif',$documentos[0]['rif']??'')) }}">
                            @endif
                        </div> 
                        </div>
                   
                  
    
         
         
                   
                       
                        <div class="col-md-12 tex-center ">
                            <div class="input-group">
                                <label for="image" class="col-sm-12  fa fa-list-alt  text-red ">Constancia trabajo</label>
                                <input readonly type="text" id="carta_trabajo" name="carta_trabajo" value="{{ old('carta_trabajo',$documentos[0]['carta_trabajo'] ??'') }}" class="form-control image" placeholder="adjuntar Constancia trabajo "  />
                                <div class="input-group-append">
                                 <a data-input="carta_trabajo" data-preview="carta_trabajo" data-type="carta_trabajo" class="btn btn-primary lfm">
                                   <i class="fa fa-image"></i> 
                                 </a>
                                </div>
                            </div>
                            @error('carta_trabajo')
                            <small style="color: red">{{$message}}</small>
                        @enderror
                            <div style="border: solid 1px rgba(78, 78, 78, 0.466)" id="carta_trabajo" class="img_holder">
                                @if (old('carta_trabajo',$documentos[0]['carta_trabajo']??''))
                                <img src="{{ sc_file(old('carta_trabajo',$documentos[0]['carta_trabajo']??'')) }}">
                                @endif
                            </div>
                        </div>
                  
    

                <div class=" col-12 mt-3 p-2 text-center ">
                    <button id="guarda"  class="btn btn-primary w-100">guardar</button>

                </div>
                <input  type="hidden" name="first_name" value="{{$customer['first_name']}}">
                <input type="hidden" name="id_usu" value="{{$customer['id']}}">
                <input type="hidden" name="email" value="{{$customer['email']}}">
                <input type="hidden" name="phone" value="{{ $customer['phone'] }}">

               
    
           
            </form>
        </div>
          
        </div>
       


</div>
</section>



@endsection