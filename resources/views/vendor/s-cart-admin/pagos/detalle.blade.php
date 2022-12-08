@extends($templatePathAdmin.'layout')

@section('main')
<div class="row">
  <div class="col-12">
    <div class="card" >
      <div class="card-header with-border">
        <div class="card-tools">
          @if (!empty($topMenuRight) && count($topMenuRight))
            @foreach ($topMenuRight as $item)
                <div class="menu-right">
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
        <div class="float-left">
          @if (!empty($topMenuLeft) && count($topMenuLeft))
            @foreach ($topMenuLeft as $item)
                <div class="menu-left">
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
        <!-- /.box-tools -->
      </div>

      <div class="card-header with-border">
        <div class="card-tools">
           @if (!empty($menuRight) && count($menuRight))
             @foreach ($menuRight as $item)
                 <div class="menu-right">
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


         <div class="float-left">
          @if (!empty($removeList))
            <div class="menu-left">
              <button type="button" class="btn btn-default grid-select-all"><i class="far fa-square"></i></button>
            </div>
            <div class="menu-left">
              <span class="btn btn-flat btn-danger grid-trash" title="{{ sc_language_render('action.delete') }}"><i class="fas fa-trash-alt"></i></span>
            </div>
          @endif

          @if (!empty($buttonRefresh))
            <div class="menu-left">
              <span class="btn btn-flat btn-primary grid-refresh" title="{{ sc_language_render('action.refresh') }}"><i class="fas fa-sync-alt"></i></span>
            </div>
          @endif

          @if (!empty($buttonSort))
          <div class="menu-left">
            <div class="input-group float-right ml-1" style="width: 350px;">
              <div class="btn-group">
                <select class="form-control rounded-0 float-right" id="order_sort">
                {!! $optionSort??'' !!}
                </select>
              </div>
              <div class="input-group-append">
                  <button id="button_sort" type="submit" class="btn btn-primary"><i class="fas fa-sort-amount-down-alt"></i></button>
              </div>
            </div>
          </div>
          @endif

          @if (!empty($menuLeft) && count($menuLeft))
            @foreach ($menuLeft as $item)
                <div class="menu-left">
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

      <!-- Modal -->
<div class="modal fade" id="modal_estatus_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('post_status_pago')}}"  method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar el estatus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       @csrf
        <div class="form-group">
          <label for="estatus_pagos"></label>
          <select class="form-control" id="estatus_pagos" name="estatus_pagos">
            @foreach ($statusPayment as $item)
            <option  value="@php echo $item->id @endphp  "  >   @php  echo $item->name @endphp</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="observacion">Observación</label>
       <input type="text" class="form-control" id="observacion" name="observacion">
        </div>
        <input type="hidden" name="id_pago" id="id_pago">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </form>
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

 <!-- Modal detaalle pago -->
 <div class="modal fade" id="modal_detalle_pago" tabindex="-1" role="dialog" aria-labelledby="modal_detalle_pago" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle de pago #<span id="idpago"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-md-6">
              <label for="forma_pago">Forma de pago</label>
              <input id="mforma_pago" name="" required class="form-control" readonly>
   
              </select>  
            </div>
          <div class="form-group col-md-6">
            <label for="inputEmail4">Nro de referencia</label>
            <input type="text" class="form-control"  required name="" id="mreferencia" placeholder="referencia" readonly>
          </div>

        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Fecha de pago</label>
            <input type="text" class="form-control" required value="" name="fecha" readonly id="mfecha" placeholder="referencia">
          </div>
          <div class="form-group col-md-6">
            <label for="inputEmail4">Fecha de Vencimiento</label>
            <input type="text" class="form-control" required value="" name="fecha"  readonly id="mvencimiento" placeholder="referencia">
          </div>
          <div class="form-group col-md-6">
            <label for="forma_pago">Monto</label>
            <input type="text" required class="form-control"  id="mmonto" name=""  readonly  placeholder="Monto">

          </div>
          <div class="form-group col-md-6">
            <label for="forma_pago">Divisa</label>
            <input type="text" required  readonly class="form-control readonly"  id="mdivisa" name=""  placeholder="divisa">

           
          </div>
        </div>

        <div class="form-row">
       
     

          <div class="form-group col-md-6">
         
              <label for="forma_pago"> descargar referencia </label>
              <a href="#" data-id="" id="dcomprobante"><span  data-id=" " title="Descargar referencia" type="button" class="btn btn-flat  btn-sm btn-primary"><i class="fa fa-file"></i></span></a>
                </div>
                <div class="form-group col-md-6">
         
                  <label for="forma_pago">Estatus</label>
                  <input type="text"  id="mstatus" class="form-control" name=""  readonly required="">
    
                    </div>

                    <div class="form-group col-md-6">
         
                      <label for="forma_pago">Tasa de cambio</label>
                      <input type="text"  id="mtasa" class="form-control" readonly name="" required="" readonly>
        
                        </div>
                <div class="form-group col-md-6">
         
                  <label for="forma_pago">Observación</label>
                  <input type="text"  id="mobservacion" class="form-control" readonly name="" required="">
    
                    </div>
        </div>


      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        
    
      </div>
    </div>
  </div>
</div>
@endsection


@push('styles')
{!! $css ?? '' !!}
@endpush

@push('scripts')
    {{-- //Pjax --}}
   <script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

function obtener_detalle_pago(id_pago){

$.ajax({
              url : '{{ sc_route_admin('obtener_pago') }}',
              type : "get",
              dateType:"application/json; charset=utf-8",
              data : {
                   id : id_pago,
                  
              },
          beforeSend: function(){
              $('#loading').show();
          },
          success: function(returnedData){
         $('#modal_detalle_pago').modal('show')

         var data = returnedData.data;

         $("#idpago").text(data.id)
          $("#mforma_pago").val(data.metodo)
          $("#mreferencia").val(data.referencia)

          $("#mfecha").val(data.fecha_pago)
          $("#mvencimiento").val(data.fecha_venciento)
          $("#mmonto").val(data.importe_pagado)
          $("#mreferencia").val(data.referencia)
          $("#mdivisa").val(data.moneda)
          $("#mobservacion").val(data.comment)
          $("#mstatus").val(data.status)
          $("#mtasa").val(data.mtasa)
          $("#dcomprobante").attr('href', data.comprobante)
          

          

          
              $('#loading').hide();
              }
          });
      

}
$('.mostrar_estatus_pago').click(function(){
  $("#modal_estatus_pago").modal('show');

  $("#id_pago").val($(this).data('id'))
  

    });

    $('.grid-refresh').click(function(){
      $.pjax.reload({container:'#pjax-container'});
    });

      $(document).on('submit', '#button_search', function(event) {
        $.pjax.submit(event, '#pjax-container')
      })

    $(document).on('pjax:send', function() {
      $('#loading').show()
    })
    $(document).on('pjax:complete', function() {
      $('#loading').hide()
    })

    // tag a
    $(function(){
     $(document).pjax('a.page-link', '#pjax-container')
    })


    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

    @if ($buttonSort)
      $('#button_sort').click(function(event) {
        var url = $('#url-sort').data('urlsort')+'sort_order='+$('#order_sort option:selected').val();
        $.pjax({url: url, container: '#pjax-container'})
      });
    @endif

  </script>
    {{-- //End pjax --}}


<script type="text/javascript">
{{-- sweetalert2 --}}
var selectedRows = function () {
    var selected = [];
    $('.grid-row-checkbox:checked').each(function(){
        selected.push($(this).data('id'));
    });

    return selected;
}

$('.grid-trash').on('click', function() {
  var ids = selectedRows().join();
  deleteItem(ids);
});

function deleteItem(ids){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ sc_language_render('action.delete_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ $urlDeleteItem ?? '' }}',
                data: {
                  ids:ids,
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    if(data.error == 1){
                      alertMsg('error', data.msg, '{{ sc_language_render('action.warning') }}');
                      $.pjax.reload('#pjax-container');
                      return;
                    }else{
                      alertMsg('success', data.msg);
                      $.pjax.reload('#pjax-container');
                      resolve(data);
                    }

                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}');
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}


function cloneProduct(id){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ sc_language_render('product.admin.clone_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ sc_route_admin('admin_product.clone') }}',
                data: {
                  pId:id,
                  _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    if(data.error == 1){
                      alertMsg('error', data.msg, '{{ sc_language_render('action.warning') }}');
                      $.pjax.reload('#pjax-container');
                      return;
                    }else{
                      alertMsg('success', data.msg);
                      $.pjax.reload('#pjax-container');
                      resolve(data);
                    }

                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ sc_language_render('product.admin.clone_success') }}', '');
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}

{{--/ sweetalert2 --}}


</script>

{!! $js ?? '' !!}
@endpush
