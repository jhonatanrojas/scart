
@extends($templatePathAdmin.'layout')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
@section('main')
<div class="row">
    <div class="col-12">
      <div class="card" >
        <div class="card-header with-border">
            <div class="card-tools">
                <div class="menu-right">
                    <a onclick="modal_create()"  href="#" class="btn  btn-success  btn-flat mostrar_estatus_pago" title="New"  data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal"  >
                    <i class="fa fa-plus" title="Añadir nuevo"></i>
                    </a>
                </div>
            </div>
    
    
             <div class="float-left">
                          <div class="menu-left">
                  <button type="button" class="btn btn-default grid-select-all"><i class="far fa-square"></i></button>
                </div>
                <div class="menu-left">
                  <span class="btn btn-flat btn-danger grid-trash" title="Borrar"><i class="fas fa-trash-alt"></i></span>
                </div>
              
              
                        <div class="menu-left">
                <div class="input-group float-right ml-1" style="width: 350px;">
                  <div class="btn-group">
                    <select class="form-control rounded-0 float-right" id="order_sort">
                    <option value="id__desc">ID descendente</option><option value="id__asc">ID ascendente</option><option value="first_name__desc">Nombre en orden z-a</option><option value="first_name__asc">Nombre en orden z-a</option><option value="last_name__desc">Apellido en orden z-a</option><option value="last_name__asc">Apellido en orden z-a</option>
                    </select>
                  </div>
                  <div class="input-group-append">
                      <button id="button_sort" type="submit" class="btn btn-primary"><i class="fas fa-sort-amount-down-alt"></i></button>
                  </div>
                </div>
              </div>
              
              
            </div>
    
          </div>
  
    
  
        <!-- /.card-header -->
        <div class="card-body p-0" id="pjax-container">
          @php
              $urlSort = $urlSort ?? '';
          @endphp
          <div id="url-sort" data-urlsort="{!! strpos($urlSort, "?")?$urlSort."&":$urlSort."?" !!}"  style="display: none;"></div>
          <div class="table-responsive">
          <table class="table table-hover box-body text-wrap table-bordered">
            <thead>
              <tr>
                @if (!empty($removeList))
                <th></th>
                @endif
                @foreach ($listTh as $key => $th)
                  <th>{!! $th !!}</th>
                @endforeach
               </tr>
            </thead>
            <tbody>
              @foreach ($dataTr as $keyRow => $tr)
              <tr>
                  @if (!empty($removeList))
                  <td>
                    <input class="checkbox grid-row-checkbox" type="checkbox" data-id="{{ $keyRow }}">
                  </td>
                  @endif
                  @foreach ($tr as $key => $trtd)
                      <td>{!! $trtd !!}</td>
                  @endforeach
              </tr>
              @endforeach
            </tbody>
          </table>
          </div>
          
          <div class="block-pagination clearfix m-10">
            <div class="ml-3 float-left">
              {!! $resultItems??'' !!}
            </div>
            <div class="pagination pagination-sm mr-3 float-right">
              {!! $pagination??'' !!}
            </div>
          </div>
  
        </div>
        <!-- /.card-body -->
  
        <div class="card-footer clearfix">
          @if (!empty($blockBottom) && count($blockBottom))
          @foreach ($blockBottom as $item)
            <div class="clearfix">
              @php
              $arrCheck = explode('view::', $item);
              @endphp
              @if (count($arrCheck) == 2)
                @if (view()->exists($arrCheck[1]))
                  @include($arrCheck[1])
                @endif
              @else
                {!! trim($item) !!}
              @endif
            </div>    
          @endforeach
        @endif
        </div>
  
  
      </div>
      <!-- /.card -->
    </div>
  </div>


  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Crear fecha de entrega</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('fecha_create')}}" method="get">
        <div class="modal-body">
           

                
                    <input id="fecha" required name="fecha_entrega" class="form-control" type="date">

                    <div class="form-group row mt-3 align-items-center">
                        <label for="status" class="col-sm-2 col-form-label">Estatus</label>
                        <div class="col-sm-9 ">
                            <div class="icheckbox_square-blue " style="position: relative;"><input class="checkbox" value="1"   id="checkboxs"  type="checkbox" name="stado"  ></ins></div>
                        </div>
                    </div>
               
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Crear</button>
        </div>
        
      </div>
      <input name="modalidad" value="0" type="hidden" id="modalidad">
      <input name="id_fecha" value="0" type="hidden" id="id_fecha">
    </form>
    </div>
  </div>

@endsection

@push('styles')
{!! $css ?? '' !!}
@endpush

@push('scripts')


<script type="text/javascript">

    function modal_create(){
        const title = document.getElementById('exampleModalLabel');
        title.innerHTML = "Crear fecha de entrega";
        $('#modalidad').val(0)
    }

        function edit_fecha(id , activo){
            const title = document.getElementById('exampleModalLabel');
            title.innerHTML = "Edit fecha de entrega";
            $.ajax({
                url :`sc_admin/fecha_edit/${id}`,
                type : "post",
                dateType:"application/json; charset=utf-8",
                data : {
                     id : id,
                     activo:activo,
                     "_token": "{{ csrf_token() }}",
                    
                },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(returnedData){
              $('#modalidad').val(1)
                returnedData.success.forEach(element => {

                  $('#id_fecha').val(element.id)

                  var fecha =  element.fecha_entrega

                  $('#fecha').val( fecha);

                 

                    
                });


           $('#exampleModal').modal('show')
            $('#loading').hide();

                }
            });
        }

        function deleteItem(id){
            $.ajax({
                url :`sc_admin/fecha_delete/'${id}`,
                type : "post",
                dateType:"application/json; charset=utf-8",
                data : {
                     id : id,
                     "_token": "{{ csrf_token() }}",
                    
                },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(returnedData){
            $('#loading').hide();
            location.reload()

                }
            });
        }



       

</script>
