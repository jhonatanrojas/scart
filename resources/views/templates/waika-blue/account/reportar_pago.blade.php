@php
/*
$layout_page = shop_profile
** Variables:**
- $statusOrder
- $orders
*/ 




@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
  <h4 class="title-store text-center"></h4>
  <div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <th> Numero de orden: {{ $order->id}}</th>
            </thead>
            <thead>
              <tr>
                <th> Producto</th>
    
              </tr>
            </thead>
              <tbody>
                  @foreach ($order->details as $item)
                        <tr>
                          <td>{{ $item->name }}
                            {{-- 
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
                            --}}
                          </td>
            
                 
                        </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      @if (count($errors) > 0)
        <div class = "alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div>
      @endif
    </div>
  </div>

  <div class="card mb-1">
    <form action="{{route('post_reporte_pago')}}"  method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id_pago" value="{{$id_pago}}">
      <div class="card-header">
        <h5>{{ $title }}</h5>
      </div>
   


      <div class="row justify-content-center align-items-center">
    
 
        <div class="col-md-8">
          <div class="card-body">
            @if (isset($lisPago))
              @if (sc_config('customer_Transferencia'))
                <div class="row justify-content-center align-items-center">
            
                  <div  class="col-12 col-lg-6 p-1">
                    @if (sc_config('customer_pago_movil'))
                      <ul class="list-group">
                        <li class="list-group-item text-center"> @if($historial_pago)
                          <h5 class="card-title">
                            Monto cuota: {{ $historial_pago->importe_couta }}$ 
                          </h5>
                          <h6 class="card-subtitle text-danger"> Vence: {{ date('d-m-Y',strtotime($historial_pago->fecha_venciento)); }}</h6>
                          @endif</li>
                  
                        <li class="list-group-item text-center">Datos Pago Movil</li>
                          <li class="list-group-item">Banco de Venezuela</li>
                          <li class="list-group-item">Teléfono: 04126354038</li>
                          <li class="list-group-item">RIF: J501450536 </li>
                      </ul>
                    @endif
                  </div>
                </div>
              @endif  
            @endif
          </div>

        </div>
      </div>
      

      <div class="card-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label for="telefono_origen">Teléfono del Pagador</label>
              <input type="text" class="form-control"  value="{{ old('telefono_origen') }}"   required name="telefono_origen" id="telefono_origen" placeholder="telefono">
              @error('telefono_origen')
                  <small style="color: red">{{$message}}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="inputEmail4">Cedula del Pagador </label>
              <div class="input-group mb-3">
     
                <select name="nacionalidad" id="nacionalidad" class=""  style="   
                width:100px;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;">
                <option class="V">V</option>
                <option class="J">J</option>
                </select>
                <input type="text" class="form-control" value="{{ old('cedula_origen') }}"  required name="cedula_origen" id="cedula_origen" placeholder="Cedula">
              </div>
              
         
              @error('referencia')
                  <small style="color: red">{{$message}}</small>
              @enderror
            </div>
            <div class="col-lg-6">
              <input id="forma_pago" name="forma_pago" type="hidden" type="hidden" value="4">
         
      
                <label for="codigo_banco">Banco de Origen</label>
                <select id="codigo_banco" class="form-control" required name="codigo_banco">
                  @foreach ($bancos as $banco )
                  <option value="{{$banco->codigo}}" >{{$banco->nombre}}</option>
                  @endforeach
                  
                </select>       
                @error('codigo_banco')
                    <small style="color: red">{{$message}}</small>
                @enderror
   
        
            </div>

            <div class="col-md-6">
              <label for="inputEmail4">Nro de referencia</label>
              <input type="text" class="form-control" value="{{ old('referencia') }}"   required name="referencia" id="referencia" placeholder="referencia">
              @error('referencia')
                  <small style="color: red">{{$message}}</small>
              @enderror
            </div>
          
            <div class="col-md-6">
              <label for="inputEmail4">Fecha de pago</label>
              <input type="date" class="form-control" required value="{{ old('fecha', date('Y-m-d')) }}" name="fecha" id="fecha" placeholder="referencia">
            </div>
            <div class="col-md-6">
              <label for="forma_pago">Monto Pagado</label>
              <input step="any" type="number" step="any" required class="form-control"   value="{{ old('monto') }}"   name="monto" id="monto" placeholder="Monto">
              @error('monto')
                <small style="color: red">{{$message}}</small>
              @enderror
            </div>

                {{--   <div class="col-md-6">
       
              <select id="divisa" class="form-control" required name="moneda"
               >
                <option value="Bs" selected="" data-exchange_rate="31"> Bs</option>
         
              </select>      --}} 
              @error('divisa')
                <small style="color: red">{{$message}}</small>
              @enderror
            </div>

        {{--      <div class="col-md-6">
              <label for="forma_pago">Tasa de cambio</label>
              <input id="tipo_cambio" class="form-control" type="text" required name="tipo_cambio" readonly value="{{sc_currency_all()[1]->exchange_rate}}">     
              @error('tipo_cambio')
                <small style="color: red">{{$message}}</small>
              @enderror
            </div>   --}} 
       
                {{--    <div class="col-md-6">
                <label for="forma_pago">Adjunta  referencia</label>
                <input type="file" class="form-control-file" id="capture" name="capture" required="">
                @error('capture')
                    <small style="color: red">{{$message}}</small>
                @enderror
            </div> --}} 
        
            <br>
            <div class="col">
              <input type="hidden" name="order_id" value="{{ $order->id}}">
              <input type="hidden" name="id_detalle_orden" value="{{ isset($order->details[0]) ? $order->details[0]->id  : 0}}">
              <input type="hidden" name="product_id" value="{{ isset($order->details[0]) ? $order->details[0]->product_id  : 0}}">
            </div>
            <div class="col-12">
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Reportar</button>
              </div>
            </div>
          </div>

          
      </div>
    </form>
  </div>
@endsection


@push('scripts')

<script type="text/javascript">
  $("#divisa").change(function(){
    $("#tipo_cambio").val($(this).find(':selected').attr('data-exchange_rate'))
  
  
  });
    </script>
    @endpush