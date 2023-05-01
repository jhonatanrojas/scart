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

  <div class="card mb-5">
    <form action="{{route('post_reporte_pago')}}"  method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id_pago" value="{{$id_pago}}">
      <div class="card-header">
        <h5>{{ $title }}</h5>
      </div>
      @if($historial_pago)
        <div class="card-body">
          <h5 class="card-title">
            Monto cuota: {{ $historial_pago->importe_couta }}$ 
          </h5>
          <h6 class="card-subtitle text-danger"> Vence: {{ date('d-m-Y',strtotime($historial_pago->fecha_venciento)); }}</h6>
        </div>
      @endif
      
      <div class="card-body">
        @if (isset($lisPago))
          @if (sc_config('customer_Transferencia'))
            <div class="row justify-content-center align-items-center">
              <div  class="col-12 col-lg-6 p-1">
                  <ul class="list-group">
                    <li class="list-group-item">{{sc_language_render('customer.banco1')}}</li>
                    <li class="list-group-item">{{ sc_language_render('customer.Transferencia') }}:{{sc_language_render('customer.cuenta') }}</li>
                    <li class="list-group-item">{{ sc_language_render('customer.rif') }}</li>
                  </ul>
              </div>
              <div  class="col-12 col-lg-6 p-1">
                @if (sc_config('customer_pago_movil'))
                  <ul class="list-group">
                      <li class="list-group-item">{{sc_language_render('customer.banco2')}}</li>
                      <li class="list-group-item">{{ sc_language_render('customer.pago_movil') }}:{{ sc_language_render('customer.telefono') }}</li>
                      <li class="list-group-item">{{ sc_language_render('customer.rif') }}</li>
                  </ul>
                @endif
              </div>
            </div>
          @endif  
        @endif
      </div>
      <div class="card-body">
          <div class="row g-3">
            <div class="col-lg-6">
              <label for="forma_pago">Forma de pago</label>
              <select  id="forma_pago" name="forma_pago" required class="form-control">
                @if (isset($lisPago['Transferencia']) || isset($lisPago['Pago Movil']))
                  @if (isset($lisPago['Transferencia'] ) )                      
                    <option  value="{{$metodos_pagos[1]->id}}" {!! $metodos_pagos[1]->name == $lisPago['Transferencia'] ? 'selected' :'' !!}  >{{ $metodos_pagos[1]->name}}</option>
                  @endif
                  @if (isset($lisPago['Pago Movil']))
                    <option  value="{{$metodos_pagos[3]->id}}" {!! $metodos_pagos[3]->name ==$lisPago['Pago Movil'] ? 'selected' :'' !!}  >{{ $metodos_pagos[3]->name}}</option>
                  @endif
                @else
                  @foreach($metodos_pagos as $metodo)
                    <option  value="{{ $metodo->id}}" {!! $metodo->name == $lisPago ? 'selected' :'' !!}  >{{ $metodo->name}}</option>
                  @endforeach;
                @endif
              </select>  
              @error('forma_pago')
                <small style="color: red">{{$message}}</small>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="inputEmail4">Nro de referencia</label>
              <input type="text" class="form-control"  required name="referencia" id="referencia" placeholder="referencia">
              @error('referencia')
                  <small style="color: red">{{$message}}</small>
              @enderror
            </div>
          
            <div class="col-md-6">
              <label for="inputEmail4">Fecha de pago</label>
              <input type="date" class="form-control" required value="@php echo date('Y-m-d')  @endphp" name="fecha" id="fecha" placeholder="referencia">
            </div>
            <div class="col-md-6">
              <label for="forma_pago">Monto</label>
              <input step="any" type="number" required class="form-control"  name="monto" id="monto" placeholder="Monto">
              @error('monto')
                <small style="color: red">{{$message}}</small>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="forma_pago">Divisa</label>
              <select id="divisa" class="form-control" required name="moneda">
                @foreach(sc_currency_all() as $moneda)
                <option  value="{{$moneda->code}}"  {!! $moneda->code =='Bs' ? 'selected' :''  !!} data-exchange_rate="{{$moneda->exchange_rate}}" > {{$moneda->code}}</option>
                @endforeach
              </select>       
              @error('divisa')
                <small style="color: red">{{$message}}</small>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="forma_pago">Tasa de cambio</label>
              <input id="tipo_cambio" class="form-control" type="text" required name="tipo_cambio" readonly value="{{sc_currency_all()[0]->exchange_rate}}">     
              @error('tipo_cambio')
                <small style="color: red">{{$message}}</small>
              @enderror
            </div>   
            <div class="col-md-6">
                <label for="forma_pago">Adjunta  referencia</label>
                <input type="file" class="form-control-file" id="capture" name="capture" required="">
                @error('capture')
                    <small style="color: red">{{$message}}</small>
                @enderror
            </div>
            <div class="col-md-12">
              <label for="forma_pago">Observación</label>
              <input type="text" class="form-control" id="observacion" name="observacion" required="">
              @error('observacion')
                  <small style="color: red">{{$message}}</small>
              @enderror    
            </div>
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