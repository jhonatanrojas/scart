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
<h class="title-store text-center"></h4>
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
      <form action="{{route('post_reporte_pago')}}"  method="post" enctype="multipart/form-data">
       @csrf
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-body">
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
                    <option selected>Bs</option>
                    <option>USD</option>
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

<input type="hidden" name="id_detalle_orden" value="{{ isset($order->details[0]) ? $order->details[0]->id  : 0}}">
<input type="hidden" name="product_id" value="{{ isset($order->details[0]) ? $order->details[0]->product_id  : 0}}">




          <button type="submit" class="btn btn-primary">Reportar</button>
        </div>
      </form>
      </div>

    

@endsection