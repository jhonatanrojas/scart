@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
  <div class="container">
    <div class=" row ">
      <div class="col-12 mb-4 text-end">
        <a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href="#">Agregar Referencia Personal</a>  
      </div>

      <div class="col-12">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>cedula</th>
                <th>Telefono</th>
                <th>Parentesco</th>
                <th>Acciones</th>
                
              </tr>
            </thead>
                  
            @foreach ($referencia as $ref)
              <tbody>
                  <td>{{$ref->nombre_ref}}</td>
                  <td>{{$ref->apellido_ref}}</td>
                  <td>{{$ref->cedula_ref}}</td>
                  <td>{{$ref->telefono}}</td>      
                  <td>{{$ref->parentesco}}</td>      
                  <td><span onclick="deleteItem('{!!$ref->id!!}');" title="Borrar" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span></td>      
              </tbody>
            @endforeach
          </table>
        </div>
      </div>      
    </div>
  </div>
     
    
<div class="modal" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-center">Referencia personal</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form  method="POST" id="referencia">
            <div class="row gap-3 justify-content-center">
                <div class="col-12">
                    <input value="{{ (old('nombre_ref' ?? ''))}}" id="nombre_ref" name="nombre_ref" type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="addon-wrapping">
                </div>
                <div class="col-12">
                    <input value="{{ (old('apellido_ref' ?? ''))}}" id="apellido_ref" name="apellido_ref" type="text" class="form-control" placeholder="Apellido" aria-label="Apellido" aria-describedby="addon-wrapping">
                </div>
      
                <div class="col-12">
                    <input value="{{ (old('cedula_ref' ?? ''))}}" id="cedula_ref" name="cedula_ref" type="text" class="form-control" placeholder="cedula" aria-label="cedula" aria-describedby="addon-wrapping">
                </div>
                
                <div class="col-12">
                    <input value="{{ (old('telefono' ?? ''))}}" id="telefono_ref" name="telefono_ref" type="text" class="form-control" placeholder="Telefono" aria-label="Telefono" aria-describedby="addon-wrapping">
                </div>
              
                <div class="col-12">
                    <input value="{{ (old('parentesco' ?? ''))}}" id="parentesco" name="parentesco" type="text" class="form-control" placeholder="Parentesco" aria-label="parentesco" aria-describedby="addon-wrapping">
                </div>
              <input type="hidden" name="">
            </div>
            <div class="modal-footer">
              <button  type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
              <button onclick="enViar_refencia()"  type="button" class="btn btn-primary">Guardar</button>
            </div>
            <input type="hidden" id="id_usuario" name="id_usuario" value="{{$customer['id']}}">
          </form>
        </div>
      </div>
    </div>
  </div>

</div>


<!-- /.modal-content -->
</div>
              
       
<script>

function enViar_refencia(){
let nombre_ref = $('#nombre_ref').val()
 let apellido_ref = $('#apellido_ref').val()
 let cedula_ref = $('#cedula_ref').val()
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
            cedula_ref:cedula_ref,
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