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
        <button class="btn btn-primary" onclick="pdf_coBrAnZaS()" id="pdf">Descarga pdf</button>
       

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

         
      </div>






@php
       $Moneda_CAMBIOBS = sc_currency_all();
                    foreach($Moneda_CAMBIOBS as $cambio){
                        if($cambio->name == "Bolivares"){
                           $cod_bolibares =  $cambio->exchange_rate;
                        }
                    }
@endphp

      <!-- /.card-header -->
      <div class="card-body p-0" id="pjax-container">
        <div class="p-3">
            <h3 class="text-center">COBRANZAS DIARIAS</h3>
       
        </div>
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
        <div class="">
          <table class=" table table-hover box-body text-wrap table-bordered">
            <thead>
              <tr>
                <th>Forma de pago</th>
                <th>Divisa</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($totales as $forma_pago => $monedas): ?>
                <?php foreach ($monedas as $moneda => $total): ?>
                  <tr>
                    <td><?php echo $forma_pago; ?></td>
                    <td><?php echo $moneda; ?></td>
                    <td><?php echo $total; ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </tbody>
          </table>



          <table class=" table table-hover box-body text-wrap table-bordered" style="width: 49%; margin-left: 50%">
            <thead>
              <tr>
                <th>Divisa</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($totaleudsBS as $forma_pago => $monedas): ?>
                <?php foreach ($monedas as $moneda => $total): ?>
                  <tr>
                    <td><?php echo $moneda; ?></td>
                    <td><?php echo $total; ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
           
            <div class="col-md-1 p-3">

               
    
            </div>
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

</div>


@endsection


@push('styles')
{!! $css ?? '' !!}
@endpush

@push('scripts')
    {{-- //Pjax --}}
   <script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">


function pdf_coBrAnZaS(){
  var fecha = $("#fecha1").val()

  if(!fecha){
    alert('la fecha esta vacia');

  }else{
    window.location.href = '{{route('pago_diarios')}}?pdf_cobranzas=5&fecha1='+fecha

  }
  


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
