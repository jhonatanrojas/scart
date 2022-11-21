@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
            <div class=" row">
               
               <div class="col-md-12">
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
     
   
<script>
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