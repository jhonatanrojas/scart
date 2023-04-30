@php
    /*
    $layout_page = shop_checkout
    **Variables:**
    - $cart: no paginate
    - $shippingMethod: string
    - $paymentMethod: string
    - $dataTotal: array
    - $shippingAddress: array
    - $attributesGroup: array
    - $products: paginate
    Use paginate: $products->appends(request()->except(['page','_token']))->links()
    */
@endphp



@extends($sc_templatePath . '.layout')

@section('block_main')
    <section class="">
        <style>
            .img_product {
                width: 64px;
                height: 64px;
                object-fit: cover;
                object-position: center;
                border-radius: 6px;
            }
        </style>
        <div class="container">
            <div class=" text-center ">
                @if (isset($mensaje) && $mensaje != '' && $cart[0]->financiamiento == '1')
                    <div class="alert alert-danger">
                        <span class="h6"> {{ $mensaje }} <a class="text-info"
                                href="{{ route('adjuntar_document') }}">haga click aqui para Adjuntar</a></span>
                    </div>
                @endif
            </div>
            <div class="row gap-3">

           
      
                @if (count($cart) == 0)
                    <div class="col-md-12 text-danger min-height-37vh">
                        {!! sc_language_render('cart.cart_empty') !!}
                    </div>
                @else
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No.</th>

                                        <th colspan="2">Articulo</th>
                                        <th>{{ sc_language_render('product.quantity') }}</th>
                                        <th>Monto de la cuotas</th>
                                        @if ($cart[0]->financiamiento == '1' || $cart[0]->financiamiento == 2)
                                            <th>Nro de cuotas</th>
                                            <th>Inicial</th>
                                            <th>Frecuencia de pago</th>
                                        @endif
                                        
                                        @if ($cart[0]->financiamiento != '1' &&  $cart[0]->financiamiento != '2')
                                            <th>{{ sc_language_render('product.subtotal') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($cart as $item)
                                        @php
                                            $n = isset($n) ? $n : 0;
                                            $n++;
                                            $product = $modelProduct->start()->getDetail($item->id, null, $item->storeId);
                                            if($cart[0]->financiamiento==2){
                                                $product->nro_coutas=$product->cuotas_inmediatas;
                                                $item->Cuotas=$product->cuotas_inmediatas;
                                            }
                                            $product->nro_coutas=      $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
                                            if( $product->precio_de_cuota > 0 ):
                                                $product->precio=  $product->price-$product->monto_inicial;
                                            endif;
                                        @endphp

                                        {{-- Render product in cart --}}
                                        <tr class="row_cart">
                                            <td>{{ $n }}</td>
                                            <td>
                                                <a href="{{ $product->getUrl() }}">
                                                    <img src="{{ sc_file($product->getImage()) }}" alt="" class="img_product">
                                                </a>
                                            </td>
                                            <td>
                                                {{ $product->name }}<br>
                                                {{-- Process attributes --}}
                                                @if ($item->options->count())
                                                    (@foreach ($item->options as $keyAtt => $att)
                                                        <b>{{ $attributesGroup[$keyAtt] }}</b>: {!! sc_render_option_price($att) !!}
                                                    @endforeach)
                                                    <br>
                                                @endif
                                                {{-- //end Process attributes --}}
                                            </td>
                                   
                                            <td>{{ $item->qty }}</td>
                                            <td>
                                                @php
                                                if($item->inicial>0){
                                                $totalinicial= $item->inicial * $product->price/100;
                                                $number1 = $product->price-($item->inicial * $product->price /100);
                                                $Precio_cuotas = number_format($number1 / $product->nro_coutas,2);


                                                }else{

                                                    $Precio_cuotas = number_format($product->price / $product->nro_coutas,2);

                                                }
                                                @endphp

                                                @if( $product->precio_de_cuota )

                                                    {{$Precio_cuotas}}

                                                @else
                                                {!! $product->showPrice() !!}
                                              
                                                @endif
                                            </td>
                                            
                                            @if ($cart[0]->financiamiento == '1' || $cart[0]->financiamiento == 2)
                                                <td>{{ $item->Cuotas }}</td>
                                                @php
                                                    $inicial = '0.00';
                                                    if ($item->inicial > 0) {
                                                        $inicial = number_format(($product->price * $item->inicial) / 100, 2);
                                                    }
                                                    
                                                @endphp
                                                <td>${{ $inicial }} </td>
                                                <td>{{ $item->modalidad_pago == '3' ? 'Mensual' : 'Quincenal' }}</td>
                                            @endif
                                            
                                        
                                            @if ($cart[0]->financiamiento != '1' &&  $cart[0]->financiamiento != '2')
                                                <td>{{ sc_currency_render($item->subtotal) }}</td>
                                            @endif
                                        </tr>
                                        {{-- // Render product in cart --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <form class="sc-shipping-address" id="form-order" role="form" method="POST"
                            action="{{ sc_route('order.add') }}">
                            {{-- Required csrf for secirity --}}
                            @csrf
                            {{-- // Required csrf for secirity --}}
                            <div class="row">
                                {{-- Display address --}}
                                <div class="col-12 col-sm-12 col-md-6">
                                    <h3 class="control-label"><i class="fa fa-truck" aria-hidden="true"></i>
                                        {{ sc_language_render('cart.shipping_address') }}:<br></h3>
                                    
                                    <div class="table-responsive">
                                        <table class="table box table-bordered" id="showTotal">
                                            <tr>
                                                <th>{{ sc_language_render('order.name') }}:</td>
                                                <td>{{ $shippingAddress['first_name'] }} {{ $shippingAddress['last_name'] }}
                                                </td>
                                            </tr>
                                            @if (sc_config('customer_name_kana'))
                                                <tr>
                                                    <th>{{ sc_language_render('order.name_kana') }}:</td>
                                                    <td>{{ $shippingAddress['first_name_kana'] . $shippingAddress['last_name_kana'] }}
                                                    </td>
                                                </tr>
                                            @endif
    
                                            @if (sc_config('customer_phone'))
                                                <tr>
                                                    <th>{{ sc_language_render('order.phone') }}:</td>
                                                    <td>{{ $shippingAddress['phone'] }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>{{ sc_language_render('order.email') }}:</td>
                                                <td>{{ $shippingAddress['email'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ sc_language_render('order.address') }}:</td>
                                                <td>{{ $shippingAddress['address1'] . ' ' . $shippingAddress['address2'] . ' ' . $shippingAddress['address3'] . ',' . $shippingAddress['country'] }}
                                                </td>
                                            </tr>
                                            @if (sc_config('customer_postcode'))
                                                <tr>
                                                    <th>{{ sc_language_render('order.postcode') }}:</td>
                                                    <td>{{ $shippingAddress['postcode'] }}</td>
                                                </tr>
                                            @endif
    
                                            @if (sc_config('customer_company'))
                                                <tr>
                                                    <th>{{ sc_language_render('order.company') }}:</td>
                                                    <td>{{ $shippingAddress['company'] }}</td>
                                                </tr>
                                            @endif
    
                                            <tr>
                                                <th>{{ sc_language_render('cart.note') }}:</td>
                                                <td>{{ $shippingAddress['comment'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                {{-- // Display address --}}

                                <div class="col-12 col-sm-12 col-md-6">
                                    @if ( $cart[0]->financiamiento != "1")
                                 
                                    {{-- Total --}}
                                    <h3 class="control-label"><br></h3>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table box table-bordered" id="showTotal">
                                                    @foreach ($dataTotal as $key => $element)
                                                        @if ($element['code'] == 'total')
                                                            <tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
                                                                <th>{!! $element['title'] !!}</th>
                                                                <td style="text-align: right" id="{{ $element['code'] }}">
                                                                    {{ $element['text'] }}
                                                                </td>
                                                            </tr>
                                                        @elseif($element['value'] != 0)
                                                            <tr class="showTotal">
                                                                <th>{!! $element['title'] !!}</th>
                                                                <td style="text-align: right" id="{{ $element['code'] }}">
                                                                    {{ $element['text'] }}
                                                                </td>
                                                            </tr>
                                                        @elseif($element['code'] == 'shipping')
                                                            <tr class="showTotal">
                                                                <th>{!! $element['title'] !!}</th>
                                                                <td style="text-align: right" id="{{ $element['code'] }}">
                                                                    {{ $element['text'] }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </div>

                                            @if (!sc_config('payment_off'))
                                                {{-- Payment method --}}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <h3 class="control-label"><i class="fas fa-credit-card"></i>
                                                                {{ sc_language_render('order.payment_method') }}:<br></h3>
                                                        </div>
                                                        <div class="form-group">
                                                            <div>
                                                                <label class="radio-inline">
                                                                    <img title="{{ $paymentMethodData['title'] }}"
                                                                        alt="{{ $paymentMethodData['title'] }}"
                                                                        src="{{ sc_file($paymentMethodData['image']) }}"
                                                                        style="width: 120px;">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- //Payment method --}}
                                            @endif

                                        </div>
                                    </div>
                                    {{-- End total --}}
                                    @endif
                                    {{-- Button process cart --}}
                                    <div class="row">
                                        <div class="col-12 d-grid gap-2">
                                            <button class="btn btn-outline-primary" type="button"
                                                style="cursor: pointer;padding:10px 30px"
                                                onClick="location.href='{{ sc_route('cart') }}'"><i
                                                    class="fa fa-arrow-left"></i>
                                                {{ sc_language_render('cart.back_to_cart') }}</button>
                                                
                                                <button class="btn btn-primary" id="submit-order"
                                                    type="submit" style="cursor: pointer;padding:10px 30px"><i
                                                        class="fa fa-check"></i>
                                                    {{ sc_language_render('cart.confirm') }}</button>
                                        </div>
                                    </div>
                                    {{-- // Button process cart --}}

                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection



@push('scripts')
    {{-- //script here --}}
@endpush

@push('styles')
    {{-- Your css style --}}
@endpush
