@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
            <div class=" row ">
                <div class="col-12 mb-4 text-center">
                  <a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href="#">Agregar Referencia Personal</a>  
                </div>
                <div class="col-12 col-md-3"></div>
               <div class="col-md-9 col-12  text-center">
                <table class="table table-hover   table-responsive " style="width: 100%;">
                    <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>Telefono</th>
                          <th>Parentesco</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
               
                      @foreach ($referencia as $ref)
                  
                    <tbody>
                        <td>{{$ref->nombre_ref}}</td>
                        <td>{{$ref->apellido_ref}}</td>
                        <td>{{$ref->telefono}}</td>      
                        <td>{{$ref->parentesco}}</td>      
                        <td><span onclick="deleteItem('{!!$ref->id!!}');" title="Borrar" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt">X</i></span>
                        </td>      
                               
                                
                         
                            

                    </tbody>
                    @endforeach
    
    
               
            </table>
               </div>
            
              
        </div>
     
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
<script>

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
    function deleteItem(id){

   
$.ajax({
      dataType: "json",
      data: {
        id:id,
        "_token": "{{ csrf_token() }}",
        
       
    },
      url:'{{ route("ref_delete") }}',
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
icon: 'error',
title: 'Registro eliminado '
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
}
</script>

@endsection