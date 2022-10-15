


@extends($sc_templatePath.'.layout')


@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    
    <div class="container  ">

      <div class="row ">
        <div class="col-12 col-sm-12 col-md-12">
          @include($sc_templatePath.'.account.nav_customer')
        </div>
        <div class="container">
            <form action="{{route('enviar_document')}}"  method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="d-flex align-items-center ">
                    
                        <img width="20%" class="img-fluid" src="../images/cedula-icon.png" alt="cedula">
         
                    <div class="d-flex  ">
                        <p class="h4">Cedula </p>
                        <input accept=".png, .jpg, .jpeg"  id="file" class="form-control " name="cedula" type="file" class="form-control-file" />
                        <div id="preview"></div>
                        
                    </div>
                  
    
                  
                    
                </div>
                
                <div class="d-flex m-2 align-items-center">
                  
                        <img width="20%" src="../images/cedula-icon.png" alt="cedula">
                
                    
    
                    <div class="d-flex">
                        <p class="h4">Rif </p>
                        <input accept=".png, .jpg, .jpeg"  id="file" class="form-control" name="Rif" type="file" class="form-control-file" />
                    </div>
                    <div id="preview3"></div>
                </div>
                <div class="d-flex  align-items-center">
                
                        <img width="20%" src="../images/cedula-icon.png" alt="cedula">
                        
             
                    

                    <div class="d-flex  ">
                        <p class="h4">Constancia</p>
                        <input  accept=".png, .jpg, .jpeg"  id="file2" class="form-control" name="carta_trabajo" type="file" class="form-control-file" />
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
@endsection