<div class="col-md-12">
@php


@endphp
    <div class="table-responsive">
        <style>
            .img_product_card {
                width: 64px;
                height: 64px;
                object-fit: cover;
                object-position: center;
                border-radius: 6px;
            }
        </style>
        <table class="table table-striped align-middle">
            <thead>
                @if($cartItem[0]->financiamiento == "1" || $cartItem[0]->financiamiento==2)
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th colspan="2">{{ sc_language_render('product.name') }}</th>
                        <th> Monto $</th> 
                        <th>Cuotas</th>
                        <th>Frecuencia</th>
                        <th>Inicial</th>
                        <th> Cuota de entrega</th>
                        <th>{{ sc_language_render('product.quantity') }}</th>
                    
                        <th></th>
                    </tr>

                @else
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th colspan="2">{{ sc_language_render('product.name') }}</th>
                        <th>{{ sc_language_render('product.price') }}</th>
                        <th>{{ sc_language_render('product.quantity') }}</th>
                        <th>{{ sc_language_render('product.subtotal') }}</th>
                        <th></th>
                    </tr>
                @endif
            </thead>

            <tbody class="table-group-divider">
                @if($cartItem[0]->financiamiento == "1" || $cartItem[0]->financiamiento==2)
                @foreach($cartItem as $item)
                    @php
             
                        $n = (isset($n)?$n:0);
                        $n++;
                        // Check product in cart
                        $product = $modelProduct->start()->getDetail($item->id, null, $item->storeId);
                        if(!$product) {
                            continue;
                        }
                        // End check product in cart
                    @endphp
                    <tr class="{{ session('arrErrorQty')[$product->id] ?? '' }}{{ (session('arrErrorQty')[$product->id] ?? 0) ? ' has-error' : '' }}">
                        <td>{{ $n }}</td>
                        <td colspan="2">
                            <a href="{{$product->getUrl() }}" class="row_cart-name">
                                <img class="img_product_card" src="{{sc_file($product->getImage())}}" alt="{{ $product->name }}">
                            </a>
                                <span>
                                <a href="{{$product->getUrl() }}" class="row_cart-name">{{ $product->name }}</a><br />
                                    <b>{{ sc_language_render('product.sku') }}</b> : {{ $product->sku }}
                                    {!! $product->displayVendor() !!}<br>
                                    {{-- Process attributes --}}
                                    @if ($item->options->count())
                                    @foreach ($item->options as $groupAtt => $att)
                                    <b>{{ $attributesGroup[$groupAtt] }}</b>: {!! sc_render_option_price($att) !!}
                                    @endforeach
                                    @endif
                                    {{-- //end Process attributes --}}
                                </span>
                            </a>
                        </td>
                    
                        @php
                          $Precio_cuota = 0;
                       
                            if($cartItem[0]->financiamiento==2){
                                $product->nro_coutas=$product->cuotas_inmediatas;
                                $item->Cuotas=$product->cuotas_inmediatas;
                            }
                            
                                                                    
                            if ($product->monto_cuota_entrega >0){

                                $Precio_cuota =number_format(($product->price/$item->Cuotas) * $item->qty ,2);


                            }else if($item->inicial > 0){

                                $total_price = ($product->price - $item->inicial) ;
                                $precio_coutas = round( $total_price / $item->Cuotas);

                               
                                $Precio_cuota = ($precio_coutas * $item->qty );  
                                                    
                            }else{
                                $Precio_cuota =number_format($product->price / $item->Cuotas ,2);  

                            }
                        

                        @endphp

                        <td>
                            {{$Precio_cuota}} 
                        </td> 

                        <td>{{$item->Cuotas}} </td>
                        <td>{{$item->modalidad_pago  == "3" ? "Mensual":"Quincenal"}}</td>
                 
                        
                    
                        <td>${!!number_format($inicial=  $item->inicial * $item->qty ,2)!!}</td>
  
                        <td>{{ $product->monto_cuota_entrega}}</td>
                        <td class="cart-col-qty">
                            <div class="cart-qty">
                                <input style="width: 100px;" type="number" data-id="{{ $item->id }}"
                                    data-rowid="{{$item->rowId}}" data-store_id="{{$product->store_id}}" onChange="updateCart($(this));"
                                    class="item-qty form-control" name="qty-{{$item->id}}" value="{{$item->qty}}">
                            </div>
                            <span class="text-danger item-qty-{{$item->id}}" style="display: none;"></span>
                            @if (session('arrErrorQty')[$product->id] ?? 0)
                                <span class="help-block">
                                    <br>{{ sc_language_render('cart.minimum_value', ['value' => session('arrErrorQty')[$product->id]]) }}
                                </span>
                            @endif
                        </td>
  
                  
  
                        <td >
                            <a onClick="return confirm('Confirm?')" title="Remove Item" alt="Remove Item"
                                class="cart_quantity_delete"
                                href="{{ sc_route("cart.remove", ['id'=>$item->rowId, 'instance' => 'cart']) }}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                
                @else

                @foreach($cartItem as $item)
                    @php
                        $n = (isset($n)?$n:0);
                        $n++;
                        // Check product in cart
                        $product = $modelProduct->start()->getDetail($item->id, null, $item->storeId);
                        if(!$product) {
                            continue;
                        }
                        // End check product in cart
                    @endphp
                    <tr class=" {{ session('arrErrorQty')[$product->id] ?? '' }}{{ (session('arrErrorQty')[$product->id] ?? 0) ? ' has-error' : '' }}">
                        <td>{{ $n }}</td>
                        <td>
                            <a href="{{$product->getUrl() }}" class="row_cart-name">
                                <img class="img_product_card" src="{{sc_file($product->getImage())}}" alt="{{ $product->name }}">
                            </a>
                        </td>
                        <td>
                            <span>
                                <a href="{{$product->getUrl() }}" class="row_cart-name">{{ $product->name }}</a>
                                
                                <br/>
                                <b>{{ sc_language_render('product.sku') }}</b> : {{ $product->sku }}
                                
                                {!! $product->displayVendor() !!}<br>
                                
                                {{-- Process attributes --}}
                                @if ($item->options->count())
                                    @foreach ($item->options as $groupAtt => $att)
                                        <b>{{ $attributesGroup[$groupAtt] }}</b>: {!! sc_render_option_price($att) !!}
                                    @endforeach
                                @endif
                                {{-- //end Process attributes --}}
                            </span>
                        </td>
    
                        <td>{!! $product->showPrice() !!}</td>
    
                        <td class="cart-col-qty">
                            <div class="cart-qty">
                                <input type="number" data-id="{{ $item->id }}" style="width: 100px;" 
                                    data-rowid="{{$item->rowId}}" data-store_id="{{$product->store_id}}" onChange="updateCart($(this));"
                                    class="item-qty form-control" name="qty-{{$item->id}}" value="{{$item->qty}}">
                            </div>
                            <span class="text-danger item-qty-{{$item->id}}" style="display: none;"></span>
                            @if (session('arrErrorQty')[$product->id] ?? 0)
                                <span class="help-block">
                                    <br>{{ sc_language_render('cart.minimum_value', ['value' => session('arrErrorQty')[$product->id]]) }}
                                </span>
                            @endif
                        </td>
    
                        <td >
                            {{sc_currency_render($item->subtotal)}}
                        </td>
    
                        <td>
                            <a onClick="return confirm('Confirm?')" title="Remove Item" alt="Remove Item"
                                class="cart_quantity_delete"
                                href="{{ sc_route("cart.remove", ['id'=>$item->rowId, 'instance' => 'cart']) }}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
  
                @endforeach
                    
                
                @endif
            </tbody>
        </table>
    </div>
  </div>
  
  
  @push('scripts')
  <script type="text/javascript">
      function updateCart(obj){
          let new_qty = obj.val();
          let storeId = obj.data('store_id');
          let rowid = obj.data('rowid');
          let id = obj.data('id');
          $.ajax({
              url: '{{ sc_route('cart.update') }}',
              type: 'POST',
              dataType: 'json',
              async: false,
              cache: false,
              data: {
                  id: id,
                  rowId: rowid,
                  new_qty: new_qty,
                  storeId: storeId,
                  _token:'{{ csrf_token() }}'},
              success: function(data){
                  error= parseInt(data.error);
                  if(error ===0)
                  {
                      window.location.replace(location.href);
                  }else{
                      $('.item-qty-'+id).css('display','block').html(data.msg);
                  }
  
                  }
          });
      }
  
      function buttonQty(obj, action){
          var parent = obj.parent();
          var input = parent.find(".item-qty");
          if(action === 'reduce'){
              input.val(parseInt(input.val()) - 1);
          }else{
              input.val(parseInt(input.val()) + 1);
          }
          updateCart(input)
      }
  </script>
  @endpush