

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
<h1 class="text-center text-info">El Cliente no adjutado los documentos </h1>
    
    @endif

     

<script type="">

$('#descarga[download]').each(function() {
  var $a = $(this),
      fileUrl = $a.attr('href');

  $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
});
</script>
@endsection