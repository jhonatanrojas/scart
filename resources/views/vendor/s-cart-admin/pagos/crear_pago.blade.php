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


      <!-- /.card-header -->
      <div class="card-body p-0" id="pjax-container">
        @php
            $urlSort = $urlSort ?? '';
        @endphp
        <div id="url-sort" data-urlsort="{!! strpos($urlSort, "?")?$urlSort."&":$urlSort."?" !!}"  style="display: none;"></div>
   
        
        <div class="row">
            <div class="col-sm-12">
              <div class="box collapsed-box">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <th> Numero de orden: {{ $order->id}}</th>
                  </thead>
                  <thead>
                
                      <tr>
                        <th> Producto</th>
                        <th class="product_price">{{ sc_language_render('product.price') }}</th>
                        <th class="product_qty">{{ sc_language_render('product.quantity') }}</th>
                        <th class="product_total">{{ sc_language_render('order.totals.sub_total') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $item)
                              <tr>
                                <td>{{ $item->name }}
                                  @php
                                  $html = '';
                                    if($item->attribute && is_array(json_decode($item->attribute,true))){
                                      $array = json_decode($item->attribute,true);
                                          foreach ($array as $key => $element){
                                            $html .= '<br><b>'.$attributesGroup[$key].'</b> : <i>'.$element.'</i>';
                                          }
                                    }
                                  @endphp
                                {!! $html !!}
                                </td>
                   
                                <td class="product_price">{{ $item->price }}</td>
                                <td class="product_qty"> {{ $item->qty }}</td>
                                <td class="product_total item_id_{{ $item->id }}">{{ sc_currency_render_symbol($item->total_price,$order->currency)}}</td>
                           
                              </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            </div>
        
          </div>
          <hr>
            <div class="card">
              <form action="{{route('historial_pagos.postreportar')}}"  method="post" enctype="multipart/form-data">
               @csrf
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-body">
                  <div class="form-group col-md-12">
                    @if($historial_pago)
                    <h5 class="text-center">   Monto cuota: {{ $historial_pago->importe_couta }}$ <br> <small> Vence:    {{ date('d-m-Y',strtotime($historial_pago->fecha_venciento)); }}</small></h5>
                    @endif
                  </div>
              
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="forma_pago">Forma de pago</label>
                            <select id="forma_pago" name="forma_pago" required class="form-control">
                              @foreach($metodos_pagos as $metodo)
                              <option value="{{ $metodo->id}}" >{{ $metodo->name}}</option>
                            
                              @endforeach;
                            </select>  
                          </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Nro de referencia</label>
                          <input type="text" class="form-control"  required name="referencia" id="referencia" placeholder="referencia">
                        </div>
                        @error('referencia')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                      </div>
            
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Fecha de pago</label>
                          <input type="date" class="form-control" required value="@php echo date('Y-m-d')  @endphp" name="fecha" id="fecha" placeholder="referencia">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="forma_pago">Monto</label>
                          <input type="number" required class="form-control"  name="monto" id="monto" placeholder="Monto">
                          @error('monto')
                          <small style="color: red">{{$message}}</small>
                      @enderror
                        </div>
                      </div>
        
                      <div class="form-row">
                     
                        <div class="form-group col-md-6">
                          <label for="forma_pago">Divisa</label>
                          <select id="forma_pago" class="form-control" required name="moneda">
                            <option >Bs</option>
                            <option selected>USD</option>
                          </select>      
                         
                        </div>
        
                        <div class="form-group col-md-6">
                       
                            <label for="forma_pago">Adjunta  referencia</label>
                            <input type="file" class="form-control-file" id="capture" name="capture" required="">
                            @error('capture')
                            <small style="color: red">{{$message}}</small>
                        @enderror
                              </div>
                              <div class="form-group col-md-12">
                       
                                <label for="forma_pago">Observación</label>
                                <input type="text" class="form-control" id="observacion" name="observacion" required="">
                  
                                  </div>
                      </div>
        
            <input type="hidden" name="order_id" value="{{ $order->id}}">
            <input type="hidden" name="id_pago" value="{{ $id_pago}}">
        <input type="hidden" name="id_detalle_orden" value="{{ isset($order->details[0]) ? $order->details[0]->id  : 0}}">
        <input type="hidden" name="product_id" value="{{ isset($order->details[0]) ? $order->details[0]->product_id  : 0}}">
        
        
        
        
                  <button type="submit" class="btn btn-primary">Reportar</button>
                </div>
              </form>
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

@endsection


@push('styles')
{!! $css ?? '' !!}
@endpush

@push('scripts')
    {{-- //Pjax --}}
   <script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

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
