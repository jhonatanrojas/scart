@php if(!empty($convenio))$inconoAlert = "block";

@endphp

<ul class="list-group list-group-flush member-nav ">
    <li class="list-group-item  ">
        <span style="display:{{$inconoAlert ?? "" }} ;"  class="iconoAlert"><img width="30px" class="img-fluid" src="/images/documento.gif" alt=""></span>
        <a style="color: black;" href="{{ sc_route('customer.order_list') }}"><i class="fa fa-cart-arrow-down text-black" style="color: black;" aria-hidden="true"></i> {{ sc_language_render('customer.order_history') }}</a>
    </li>

    
 

    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.address_list') }}"><i class="fa fa-id-card-o" aria-hidden="true"></i> {{ sc_language_render('customer.address_list') }}</a>
    </li>
    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.historial_pagos') }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Historial de pagos</a>
    </li>
  
    <li class="list-group-item">
        <a style="color: black;" href="{{route('adjuntar_document')}}"><i class="fa fa-file" aria-hidden="true"></i> Adjuntar documentos </a>
    </li>
    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.change_infomation') }}"><i class="fa fa-list" aria-hidden="true"></i> 
            Actulizar mis datos
        </a>
    </li>
    
    
    
    <li class="menu list-group-item" id="menu">
      <i class="fa fa-file" aria-hidden="true"></i>
            Referencia
      <nav id="navega">
        <ul>
          <li><a data-toggle="modal" data-target="#myModal" href="#">Referencia personal</a>   </li>
          <li><a href="{{sc_route('customer.lista_referencia')}}">Lista de Referencia personal</a></li>
         
          
        </ul>
        
      </nav>
    </li>


    
    
 

    <li class="list-group-item">
        <a  style="color: black;"href="{{ sc_route('customer.change_password') }}"><i class="fa fa-key" aria-hidden="true"></i> {{ sc_language_render('customer.change_password') }}</a></li>
</ul>



<div class="container">
    
    <div class="modal  mt-5" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog  " role="document">
          <div class="modal-content">
            <div class="modal-header">
                
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
             
            </div>
            <h5 class="text-center">Referencia personal</h5>
            <div class="modal-body p-0">

               <div class="container">
                <form  method="POST" id="referencia">
                    <div class="row justify-content-center  ">
                        <div class="mt-4 col-12">
                            <div class="col-12 col mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input value="{{ (old('nombre_ref' ?? ''))}}" id="nombre_ref" name="nombre_ref" type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="addon-wrapping">
                                  </div></div>
                            <div class="col-12 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input value="{{ (old('apellido_ref' ?? ''))}}" id="apellido_ref" name="apellido_ref" type="text" class="form-control" placeholder="Apellido" aria-label="Apellido" aria-describedby="addon-wrapping">
                                  </div></div>
                            <div class="col-12 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input value="{{ (old('telefono' ?? ''))}}" id="telefono_ref" name="telefono_ref" type="text" class="form-control" placeholder="Telefono" aria-label="Telefono" aria-describedby="addon-wrapping">
                                  </div></div>
                            <div class="col-12 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input value="{{ (old('parentesco' ?? ''))}}" id="parentesco" name="parentesco" type="text" class="form-control" placeholder="Parentesco" aria-label="parentesco" aria-describedby="addon-wrapping">
                                  </div></div>
                        </div>
                        <input type="hidden" name="">
                       </div>
                        

                       
                       <div class="modal-footer mb-4">
                        <button  type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button onclick="enViar_refencia()"  type="button" class="btn btn-primary">continuar</button>
                      </div>
                      <input type="hidden" id="id_usuario" name="id_usuario" value="{{$customer['id']}}">
                    </form>
                    </div>

               </div>
              
              
            </div>
            
          </div>
          
          
          <!-- /.modal-content -->
        </div>
        
 
      </div>
    


<script type="text/javascript">



    const susMenu_ul = document.getElementById("susMenu_ul");
    const susMenu = document.getElementById("susMenu");
   
    document.getElementById("menu").addEventListener("click",function(){
  
  document.getElementById("navega").classList.toggle("mostrar");
});



   
  

  
  




function enViar_refencia(){
let nombre_ref = $('#nombre_ref').val()
 let apellido_ref = $('#apellido_ref').val()
 let telefono_ref = $('#telefono_ref').val()
 let parentesco = $('#parentesco').val()
 let id = $('#id_usuario').val()
if(nombre_ref !== "" && apellido_ref !== "" && telefono_ref !== "" && parentesco !== ""){
    $.ajax({
          dataType: "json",
          data: {
            id_usuario:id ,
            "_token": "{{ csrf_token() }}",
            nombre_ref:nombre_ref,
            apellido_ref:apellido_ref,
            telefono_ref: telefono_ref,
            parentesco: parentesco
        },
          url: '{{route("ref_personales") }}',
          type: "post",
  
            success: function (respuestas) {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                
            }
            
            })

Toast.fire({
  icon: 'success',
  title: 'Registro integrado con exito '
})
                location.reload();
          },
          error: function (xhr, err) {
            alert(
              "readyState =" +
                xhr.readyState +
                " estado =" +
                xhr.status +
                "respuesta =" +
                xhr.responseText
            );
            alert("ocurrio un error intente de nuevo");
          },
        });


}else{
    alert("los campo son obligatorio")
}
}
</script>