<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">




@extends($sc_templatePath.'.layout')
@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    
    <div class="container  ">
       

      <div class="row ">
        
    
        <div class="col-12  col-md-4">
          @include($sc_templatePath.'.account.nav_customer')
        </div>

        <div class="col-12 col-md-8">
        
            <div class="row estilos_card p-3 m-auto text-center align-items-center justify-content-center">
            <form action="{{route('enviar_document')}}"  method="post" enctype="multipart/form-data">
           
                @csrf
           
                <div class=" col-md-12">
                  <div class="input-group mb-4">
                    <input value="" name="cedula" type="file" class="form-control" id="Cedula">
                    <label class="input-group-text" for="cedula">adjuntar Cedula</label>
                   
                  </div>

                  
              
                     @error('cedula')
                    <small style="color: red">{{$message}}</small>
                @enderror

                @if (empty($documentos['cedula']))
                <input type="hidden" name="c_vacio" value="cedula">
                <input type="hidden" name="id" value="{{$documentos['id']}}">
                @endif
       
              
                    </div>
                     
                   
                  
                    <div class=" col-md-12">
                      <div class="input-group mb-4">
                        <input name="rif" type="file" class="form-control" id="rif">
                        <label class="input-group-text" for="rif"> adjuntar Rif</label>
                      </div>

                 
                        
                        @error('rif')
                        <small style="color: red">{{$message}}</small>
                    @enderror

                    @if (empty($documentos['rif']))
                <input type="hidden" name="r_vacio" value="rif">
                <input type="hidden" name="id" value="{{$documentos['id']}}">
                @endif
                    
                          </div>
       
                     
                          
                   
                  
    
         
                          <div class=" col-12  col-md-12  ">
                            
                       

                        <div class="input-group mb-4">
                          <input name="carta_trabajo" type="file" class="form-control" id="carta_trabajo">
                          <label class="input-group-text" for="carta_trabajo">Constancia de  trabajo</label>
                        </div>
               
                           
                            @error('carta_trabajo')
                            <small style="color: red">{{$message}}</small>
                        @enderror


                    @if (empty($documentos['carta_trabajo']))
                    <input type="hidden" name="k_vacio" value="carta">
                    <input type="hidden" name="id" value="{{$documentos['id']}}">
                    @endif
                              </div>

                             
                   
                          
               
                  
    

                <div class=" col-12 mt-3 p-2 text-center ">
                    <button id="guarda"  class="btn btn-primary w-100">guardar</button>

                </div>


                <div class="row">

                 
                    @if (empty($documentos['cedula']))
                    <div class="col-md-4">
                      <div class=" text-center ">
                         
                          <div class="alert alert-danger">
                             <span class="h6"> Disculpa tu cédula fue rechazada vuelva a carga la cédula</span>
                          </div>
                         
                      </div>
                  </div>
  
                    @else
                    <div class="col-md-4">
                      <img height="200" width="300" src="{{$documentos['cedula']}}" alt="">
                    </div>
                    @endif
  
                   
  
                    @if (empty($documentos['rif']))
                    <div class="col-md-4">
                      <div class=" text-center ">
                         
                          <div class="alert alert-danger">
                             <span class="h6"> Disculpa tu rif fue rechazada vuelva a carga el  rif</span>
                          </div>
                         
                      </div>
                  </div>
  
                    @else
                    <div class="col-md-4">
                      <img height="200" width="300" src="{{$documentos['rif']}}" alt="">
                    </div>
                    @endif
  
                    @if (empty($documentos['carta_trabajo']))
                    <div class="col-md-4">
                      <div class=" text-center ">
                         
                          <div class="alert alert-danger">
                             <span class="h6"> Disculpa tu contancia de trabajo  fue rechazada vuelva a carga la contancia de trabajo</span>
                          </div>
                         
                      </div>
                  </div>
  
                    @else
                    <div class="col-md-4">
                      <img height="200" width="300" src="{{$documentos['carta_trabajo']}}" alt="">
                    </div>
                    @endif
                 
                </div>
                <input  type="hidden" name="first_name" value="{{$customer['first_name']}}">
                <input type="hidden" name="id_usu" value="{{$customer['id']}}">
                <input type="hidden" name="email" value="{{$customer['email']}}">
                <input type="hidden" name="phone" value="{{ $customer['phone'] }}">

               
    
           
            </form>
        </div>

        <div class="col-12 col-md-4">
          <div class=" text-center ">
              @if (isset($mensaje) && $mensaje != "")
              <div class="alert alert-danger">
                 <span class="h6"> {{ $mensaje }} </span>
              </div>
              @endif
          </div>
      </div>
          
        </div>
       


</div>
</section>



@endsection