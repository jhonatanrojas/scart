

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
            <div class="col-12 col-md-4 ">
                <p class="text-black text-center   h5">Cedula</p>
                <div class="view view-first ">  
    
                    <img  width="100%" class="img-fluid" src="{{$documento[0]->cedula}}" />  
                    <div class="mask">  
                    <h2 class="fs-5">Cedula</h2>  
                    <p>{{$customer->cedula}}</p>  
                    <div class="mt-2">
                        <a target=" blank" id="ver" href="{{$documento[0]->cedula}}" class="info">Ver documentos
    
                        </a> 
                    </div>
                    <div class="mt-2">
                        
                        <a class="info" id="descarga" href="{{$documento[0]->cedula}}" download="{{$documento[0]->cedula}}">
                        Descargar
                          </a>
                    
                    </div>
                    </div>
                   
                       
                </div>
                
            </div>
            <div class="col-12 col-md-4 ">
                <p class="text-black text-center  h5">Rif</p>
                <div class="view view-first">  
    
                    <img width="100%" class="img-fluid" src="{{$documento[0]->rif}}" />  
                    <div class="mask">  
                    <h2 class="fs-5">Rif</h2>  
                    <p>{{$customer->cedula}}</p>  
                    <div class="mt-2">
                        <a target=" blank" id="ver" href="{{$documento[0]->rif}}" class="info">Ver documentos
    
                        </a> 
                    </div>
                    <div class="mt-2">
                        
                        <a class="info" id="descarga" href="{{$documento[0]->cedula}}" download="{{$documento[0]->rif}}">
                        Descargar
                          </a>
                    
                    </div>
                    </div>
                       
                    </div>
            </div>
            <div class="col-12 col-md-4">
                <p class="text-black text-center  h5">Contancia</p>
                <div class="view view-first">  
    
                    <img width="100%"   class="img-fluid" src="{{$documento[0]->carta_trabajo}}" />  
                    <div class="mask">  
                    <h2 class="fs-5">Contancia de trabajo</h2>  
                    <p>{{$customer->cedula}}</p>  
                       
                        <div class="mt-2">
                            <a target=" blank" id="ver" href="{{$documento[0]->carta_trabajo}}" class="info">Ver documentos
    
                            </a> 
                        </div>
                        <div class="mt-2">
                            
                            <a class="info" id="descarga" href="{{$documento[0]->carta_trabajo}}" download="{{$documento[0]->carta_trabajo}}">
                            Descargar
                              </a>
                        
                        </div>
                    </div>
                       
                    </div>
            </div>
        
        </div>
        <div class="card-header">
           
        </div>

    </div>
   
   

</div>


@else
 {{-- t1 --}}
<h1 class="text-center text-info">El Cliente no adjutado los documentos </h1>

<div class="container  ">
       

      <div class="col-12 col-md-12">
          <div class=" text-center ">
              @if (isset($mensaje) && $mensaje != "")
              <div class="alert alert-danger">
                 <span class="h6"> {{ $mensaje }} </span>
              </div>
              @endif
          </div>
      </div>
  
    

      <div class="row  align-items-center justify-content-center">
      <form action="{{route('document_admin')}}"  method="post" enctype="multipart/form-data">
         
              @csrf
              <div class="col-md-12">
                <div class="input-group">
                    <label for="cedula" class="col-sm-12 col-form-label fa fa-list-alt ">Cedula</label>
                    <input readonly type="text" id="cedula" name="cedula" value="{{ old('cedula',$documentos[0]['cedula'] ??'') }}" class="form-control image" placeholder="Adjuntar Cedula"  />
                    <div class="input-group-append">
                     <a data-input="cedula" data-preview="cedula"dat-working_dir="asadsada"    data-type="{{$id_cliente}}"  data-id="{{$id_cliente}}" class="btn btn-primary lfm">
                       <i class="fa fa-image"></i>
                     </a>
                    </div>
                </div>
                @error('cedula')
                <small style="color: red">{{$message}}</small>
            @enderror
            <div style="border: solid 1px rgba(78, 78, 78, 0.466" id="cedula" class="img_holder">
                @if (old('cedula',$documentos[0]['cedula']??''))
                <img  src="{{ sc_file(old('cedula',$documentos[0]['cedula']??'')) }}">
                @endif
            </div> 
            </div>
       
                

                
                     
                      <div class="col-md-12">
                          <div class="input-group">
                              <label for="rif" class="col-sm-12 col-form-label fa fa-list-alt ">Rif</label>
                              <input readonly type="text" id="rif" name="rif" value="{{ old('rif',$documentos[0]['rif'] ??'') }}" class="form-control image" placeholder="Adjuntar Rif"  />
                              <div class="input-group-append">
                               <a data-input="rif" data-preview="rif" data-type="{{$id_cliente}}" class="btn btn-primary lfm">
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
                 
                
  
       
       
                 
                     
                      <div class="col-md-12 ">
                          <div class="input-group">
                              <label for="image" class="col-sm-12  fa fa-list-alt   ">Constancia trabajo</label>
                              <input readonly type="text" id="carta_trabajo" name="carta_trabajo" value="{{ old('carta_trabajo',$documentos[0]['carta_trabajo'] ??'') }}" class="form-control image" placeholder="adjuntar Constancia trabajo "  />
                              <div class="input-group-append">
                               <a data-input="carta_trabajo" data-preview="carta_trabajo" data-type="{{$id_cliente}}" class="btn btn-primary lfm">
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