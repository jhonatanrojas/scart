<style>
.estilos_card{
  background-image: url('/images/fondo_documentos.png');
  background-repeat: no-repeat;
  background-origin: border-box
 border: solid 1px red;

   
}

@media only screen and (max-width: 600px) {
  .estilos_card{

    background-image: none;

}
}
@media only screen and (max-width: 820px) {
  .estilos_card{

    background-image: none;

}
}
@media only screen and (max-width: 1024px) {
  .estilos_card{
    background-image: none;


}
}


input[type=file]{
  padding:10px;
  background:#000d144b;
  color: rgb(8, 5, 5);
  border-radius: 10px;
  }


.cedula::after {
content: " <- Cedula";
color: rgb(10, 1, 1);
}
  .rif::after {
content: " <- Rif";
color: rgb(10, 1, 1);
}
  .carta::after {
content: " <- Contancia";
color: rgb(10, 1, 1);
}
</style>


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
           
                <div class="form-group col-md-12">
               
                    <label class="h6 text-primary"  for="forma_pago">Adjunta Cedula </label>
                    <input value="" type="file" class="form-control-file cedula" id="cedula" name="cedula" required="">
                    @error('cedula')
                    <small style="color: red">{{$message}}</small>
                @enderror
                      </div>
                     
                   
                  
                    <div class="form-group col-md-12">
               
                        <label class="h6 text-primary" for="forma_pago">Adjunta  Rif</label>
                        <input  value="" type="file" class="form-control-file rif" id="rif" name="rif" required="">
                        @error('rif')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                          </div>
       
                     
                          
                   
                  
    
         
                          <div class="form-group col-12  col-md-12  ">
               
                            <label class="h6 text-primary" for="forma_pago text-info">Constancia de  trabajo</label>
                            <input value="" type="file" class="form-control-file carta" id="carta_trabajo" name="carta_trabajo" required="">
                            @error('Constancia trabajo')
                            <small style="color: red">{{$message}}</small>
                        @enderror
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

        <div class="col-12 col-md-12">
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