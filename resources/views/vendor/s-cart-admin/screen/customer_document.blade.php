
<style>

.view {
    box-sizing: border-box;
    width: 100%;
    height: 250px;
    
    overflow: hidden;
    position: relative;
    text-align: center;
    /* box-shadow: 1px 1px 2px #e6e6e6; */
    cursor: default;
    /* background: #fff url(../images/bgimg.jpg) no-repeat center center */
}
.view .mask, .view .content {
    width: 100%;
    height:250px;
    position: absolute;
    /* overflow: hidden; */
    top: 0;
    left: 0
}
.view img {
    display: block;
    position: relative
}
.view h2 {
    text-transform: uppercase;
    color: #fff;
    text-align: center;
    position: relative;
    font-size: 17px;
    padding: 10px;
    background: rgba(0, 0, 0, 0.8);
    margin: 20px 0 0 0
}
.view p {
    font-family: Georgia, serif;
    font-style: italic;
    font-size: 12px;
    position: relative;
    color: #fff;
    padding: 10px 20px 20px;
    text-align: center
}
.view a.info {
    display: inline-block;
    text-decoration: none;
    padding: 7px 14px;
    background: #000;
    color: #fff;
    text-transform: uppercase;
    box-shadow: 0 0 1px #000
}
.view a.info:hover {
    box-shadow: 0 0 5px #000
}


.view-first img { 
    transition: all 0.2s linear;
}
.view-first .mask {
    opacity: 0;
    background-color: rgba(219,127,8, 0.7); 
    transition: all 0.4s ease-in-out;
}
.view-first h2 {
    transform: translateY(-100px);
    opacity: 0;
    transition: all 0.2s ease-in-out;
}
.view-first p { 
    transform: translateY(100px);
    opacity: 0;
	transition: all 0.2s linear;
}
.view-first a.info{
    opacity: 0;
	transition: all 0.2s ease-in-out;
}

.view-first:hover img { 
	transform: scale(1.1);
} 
.view-first:hover .mask { 
	opacity: 1;
}
.view-first:hover h2,
.view-first:hover p,
.view-first:hover a.info {
    opacity: 1;
    transform: translateY(0px);
}
.view-first:hover p {
    transition-delay: 0.1s;
}
.view-first:hover a.info {
    transition-delay: 0.2s;
}

  .estilos_card{
       /* border: solid  salmon 1px ; */

        
    }
    .estilos_card img{

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




{{-- {!!dd($documento)!!} --}}
@extends($templatePathAdmin.'layout')
@section('main')
@if (!empty($documento))
<div class="card">
    <div class="card-body">
        <div class="card-header">
            Documentos adjunto del cliente : {{$customer->first_name}}
        </div>
        <div class="row">

           

            @if ($documento[0]->cedula == '')
            <form action="{{route('document_update')}}"  method="post" enctype="multipart/form-data">
                @csrf
                      <label class="h6 text-primary"  for="forma_pago">Adjunta Cedula </label>
                      <input value="" type="file" class="form-control-file cedula" id="cedula" name="cedula" required="">
                      @error('cedula')
                      <small style="color: red">{{$message}}</small>
                  @enderror
                <div class=" col-12 mt-6  text-center ">
                    <button id="guarda"  class="btn btn-primary w-100">guardar</button>
                </div>
                <input  type="hidden" name="upCedula" value="cedula">
                

              <input type="hidden" name="id_usuario" value="{!!$customer->id!!}">

              <input type="hidden" name="id_document" value="{!!$documento[0]->id!!}">
            </form>
           
            @else
            <div class="col-12 col-md-4 ">
                <p class="text-black text-center   h5">Cedula</p>
                <div class="view view-first ">  
    
                    <img  width="100%" class="img-fluid" src="/{{$documento[0]->cedula}}" />  
                    <div class="mask">  
                    <h2 class="fs-5">Cedula</h2>  
                    <p>{{$customer->cedula}}</p>  
                    <div class="mt-2">
                        <a target=" blank" id="ver" href="/{{$documento[0]->cedula}}" class="info">Ver documentos
    
                        </a> 
                    </div>
                    <div class="mt-2">
                        
                        <a class="info" id="descarga" href="/{{$documento[0]->cedula}}" download="/{{$documento[0]->cedula}}">
                        Descargar
                          </a>
                    
                    </div>

                    <div class="mt-2">
                        
                        <a class="info" id="descarga" onclick="eliminar(cedula = 'cedula' , {!!$documento[0]->id!!})">
                            Eliminar
                              </a>
                    
                    </div>
                    </div>
                   
                       
                </div>
                
            </div>

         
            @endif

            @if (!$documento[0]->rif == '')
            <div class="col-12 col-md-4 ">
                <p class="text-black text-center  h5">Rif</p>
                <div class="view view-first">  
    
                    <img width="100%" class="img-fluid" src="/{{$documento[0]->rif}}" />  
                    <div class="mask">  
                    <h2 class="fs-5">Rif</h2>  
                    <p>{{$customer->cedula}}</p>  
                    <div class="mt-2">
                        <a target=" blank" id="ver" href="/{{$documento[0]->rif}}" class="info">Ver documentos
    
                        </a> 
                    </div>
                    <div class="mt-2">
                        
                        <a class="info" id="descarga" href="/{{$documento[0]->cedula}}" download="/{{$documento[0]->rif}}">
                        Descargar
                          </a>
                    
                    </div>
                    <div class="mt-2">
                        
                        <a class="info" id="descarga" onclick="eliminar(rif = 'rif' , {!!$documento[0]->id!!})">
                            Eliminar
                              </a>
                    
                    </div>
                    </div>
                       
                    </div>
            </div>
                @else


                <form action="{{route('document_update')}}"  method="post" enctype="multipart/form-data">
                    @csrf
                          <label class="h6 text-primary"  for="forma_pago">Adjunta Cedula </label>
                          <input value="" type="file" class="form-control-file cedula" id="rif" name="rif" required="">
                          @error('rif')
                          <small style="color: red">{{$message}}</small>
                      @enderror
                    <div class=" col-12 mt-6  text-center ">
                        <button id="guarda"  class="btn btn-primary w-100">guardar</button>
                    </div>
                    <input  type="hidden" name="uprif" value="rif">
                    
    
                  <input type="hidden" name="id_usuario" value="{!!$customer->id!!}">
    
                  <input type="hidden" name="id_document" value="{!!$documento[0]->id!!}">
                </form>



            @endif

            @if (!$documento[0]->carta_trabajo == '')

            <div class="col-12 col-md-4">
                <p class="text-black text-center  h5">Contancia</p>
                <div class="view view-first">  
    
                    <img width="100%"   class="img-fluid" src="/{{$documento[0]->carta_trabajo}}" />  
                    <div class="mask">  
                    <h2 class="fs-5">Contancia de trabajo</h2>  
                    <p>{{$customer->cedula}}</p>  
                       
                        <div class="mt-2">
                            <a target=" blank" id="ver" href="/{{$documento[0]->carta_trabajo}}" class="info">Ver documentos
    
                            </a> 
                        </div>
                        <div class="mt-2">
                            
                            <a class="info" id="descarga" href="/{{$documento[0]->carta_trabajo}}" download="/{{$documento[0]->carta_trabajo}}">
                            Descargar
                              </a>
                        
                        </div>

                        <a class="info" id="descarga" onclick="eliminar(contacia = 'contacia' , {!!$documento[0]->id!!})">
                            Eliminar
                              </a>
                    </div>
                       
                    </div>
            </div>

            @else


            <form action="{{route('document_update')}}"  method="post" enctype="multipart/form-data">
                @csrf
                      <label class="h6 text-primary"  for="forma_pago">Adjunta Cedula </label>
                      <input value="" type="file" class="form-control-file carta_trabajo" id="carta_trabajo" name="carta_trabajo" required="">
                      @error('carta_trabajo')
                      <small style="color: red">{{$message}}</small>
                  @enderror
                <div class=" col-12 mt-6  text-center ">
                    <button id="guarda"  class="btn btn-primary w-100">guardar</button>
                </div>
                <input  type="hidden" name="upcarta" value="carta">
                

              <input type="hidden" name="id_usuario" value="{!!$customer->id!!}">

              <input type="hidden" name="id_document" value="{!!$documento[0]->id!!}">
            </form>



            @endif
        
        </div>
        <div class="card-header">
           
        </div>

    </div>
   
   

</div>


@else
 {{-- t1 --}}


<div class="container card  ">
    <div class="card-body">
        
    <div class="card-header">
        <h4 class="text-center">El Cliente no adjuntado los documentos </h4>

    </div>
       

      <div class="col-12 col-md-12 ">
          <div class=" text-center ">
              @if (isset($mensaje) && $mensaje != "")
              <div class="alert alert-danger">
                 <span class="h6"> {{ $mensaje }} </span>
              </div>
              @endif
          </div>
      </div>
  
    

      <div class="row  align-items-center justify-content-center p-4">
      <form action="{{route('document_admin')}}"  method="post" enctype="multipart/form-data">
         
              @csrf
              
              <div class="form-group col-md-12">
               
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
                
  

              <div class=" col-12 mt-6 p-2 text-center ">
                  <button id="guarda"  class="btn btn-primary w-100">guardar</button>

              </div>
              <input  type="hidden" name="first_name" value="{{$customer['first_name']}}">
              <input type="hidden" name="id_usu" value="{{$customer['id']}}">
              <input type="hidden" name="email" value="{{$customer['email']}}">
              <input type="hidden" name="phone" value="{{ $customer['phone'] }}">

         
            <input type="hidden" name="id_usuario" value="{!!$customer->id!!}">
          </form>
        </div>
    </div>
          
   
  
     


</div>
    
    @endif

     

<script type="">

$('#descarga[download]').each(function() {
  var $a = $(this),
      fileUrl = $a.attr('href');

  $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
});


function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}

function  eliminar (documento , id ) { 

   
    $.ajax({
        url:'{{route("admin_delete_document") }}',
              type:'POST',
              dataType:'json',
              data:{id:id, documento:documento ,"_token": "{{ csrf_token() }}"},
           
              success: function(data){
                location.reload();
              }
    });
}

document.getElementById("file").onchange=function(e){
    let readi = new FileReader()

    readi.readAsDataURL(e.target.files[0])
    readi.onload = function(){
        let preview = document.getElementById("preview")
        let img  = document.createElement("img")
        img.style.width = "20%"
        img.src =  readi.result

        preview.appendChild(img)


    }

}
document.getElementById("file2").onchange=function(e){
    let readi = new FileReader()

    readi.readAsDataURL(e.target.files[0])
    readi.onload = function(){
        let preview = document.getElementById("preview2")
        let img  = document.createElement("img")
        img.style.width = "20%"
        img.src =  readi.result

        preview.appendChild(img)


    }

}

</script>
@endsection