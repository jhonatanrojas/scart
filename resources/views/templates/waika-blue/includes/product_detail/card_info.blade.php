<div class="card">
    <div class="card-body">
        <form id="buy_block" class="product-information" action="{{ sc_route('cart.add') }}" method="post">
            {{ csrf_field() }}
            
            <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
            <input type="hidden" name="storeId" id="product-detail-storeId" value="{{ $product->store_id }}" />
            
            <div class="single-product">
                <h4 class="text-transform-none font-weight-medium" id="product-detail-name">{{ $product->name }}</h4>
            
                {!! $product->displayVendor() !!}
            
                {{-- <p>
                SKU: <span id="product-detail-model">{{ $product->sku }}</span>
                </p> --}}

                {{-- Show price --}}
                <div class="">
                    <div class="single-product-price" id="product-detail-price">
                        @php
                        $product->nro_coutas=      $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
                        $product->price_con_inicial=  $product->price-$product->monto_inicial;
                        @endphp
                        
                        @if( $product->precio_de_cuota)
                            <div class="product-price-wrap">
                            <div class="sc-new-price">${!!  number_format($product->price_con_inicial/$product->nro_coutas,2) !!} </div>
                            </div>
                        @else
                            {!! $product->showPriceDetail() !!}
                        @endif
                    
                        @php
                            $total_cuotas=0;
                            if($product->nro_coutas>0) {
                            $product->nro_coutas = $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
                            $total_cuotas=  $product->price / $product->nro_coutas;  
                            }
                        @endphp
                    </div>
                    <div>
                        <h5> @if( $product->monto_inicial > 0 )

                        Inicial de  ${!! number_format($product->monto_inicial,2)  !!} <br>
                        @endif</h5>
                        <small class=" text-info  " style="font-size:1rem"> {{ $product->description}}</small>
                    </div>
                </div>
                {{--// Show price --}}

                <hr class="hr-gray-100">
            
            
                <div class="d-flex justify-content-center">

                    @if (sc_config('customer_pagar_al_contado'))
                        <div  class="m-2">
                            <button onclick="validachecke1()" id="descotado" class="btn btn-info btn-lg p-3"  type="button"  name="Des_contado"   ><small style="font-size: 12;">PAGAR AL CONTADO</small></button>
                        </div>
                    @endif
                    <div class="m-2 col-md-12">
                        <button id="finansiamiento" onclick="validachecke2() ,gen_table()"  data-toggle="modal" data-target="#myModal" type="button" class="pedido p-3  text-white " name="Financiamiento"  ><small  style="font-size: 15px;">CALCULAR SOLICITUD</small></button>
                    </div>

                </div>
            
                <div>
                    <p class="text-danger" id="msg"></p>
                </div>
                
                <hr class="hr-gray-100">

                {{-- Button add to cart --}}
                @if ($product->kind != SC_PRODUCT_GROUP && $product->allowSale() && !sc_config('product_cart_off'))
                <div id="group" class="group-xs group-middle" >
                    <div class="product-stepper" >
                    <input class="form-input" name="qty" type="number" data-zeros="true" value="1" min="1" max="100">
                    </div>
                    <div>
                        <button    id="buton"  class="button button-lg button-secondary button-zakaria" type="submit">{{ sc_language_render('action.add_to_cart') }}</button>
                    </div>
                </div>
                @endif
                {{--// Button add to cart --}}

                {{-- Show attribute --}}
                @if (sc_config('product_property'))
                <div id="product-detail-attr">
                    @if ($product->attributes())
                    {!! $product->renderAttributeDetails() !!}
                    @endif
                </div>
                @endif
                {{--// Show attribute --}}

                {{-- Stock info --}}
                @if (sc_config('product_stock'))
                <div>
                    {{ sc_language_render('product.stock_status') }}:
                    <span id="stock_status">
                        @if($product->stock <=0 && !sc_config('product_buy_out_of_stock'))
                            {{ sc_language_render('product.out_stock') }} 
                            @else 
                            {{ sc_language_render('product.in_stock') }} 
                            @endif 
                    </span> 
                </div>
                @endif
                {{--// Stock info --}}

                {{-- date available --}}
                @if (sc_config('product_available') && $product->date_available >= date('Y-m-d H:i:s'))
                    {{ sc_language_render('product.date_available') }}:
                    <span id="product-detail-available">
                        {{ $product->date_available }}
                    </span>
                @endif
                {{--// date available --}}

                {{-- Category info --}}
                <div>
                    {{ sc_language_render('product.category') }}: 
                    @foreach ($product->categories as $category)
                    <a href="{{ $category->getUrl() }}">{{ $category->getTitle() }}</a>,
                    @endforeach
                </div>
                {{--// Category info --}}

                {{-- Brand info --}}
                @if (sc_config('product_brand') && !empty($product->brand->name))
                <div>
                    {{ sc_language_render('product.brand') }}:
                    <span id="product-detail-brand">
                        {!! empty($product->brand->name) ? 'None' : '<a href="'.$product->brand->getUrl().'">'.$product->brand->name.'</a>' !!}
                    </span>
                </div>
                @endif
                {{--// Brand info --}}

                {{-- Product kind --}}
                @if ($product->kind == SC_PRODUCT_GROUP)
                <div class="products-group">
                    @php
                    $groups = $product->groups
                    @endphp
                    <b>{{ sc_language_render('product.kind_group') }}</b>:<br>
                    @foreach ($groups as $group)
                    <span class="sc-product-group">
                        <a target=_blank href="{{ $group->product->getUrl() }}">
                            {!! sc_image_render($group->product->image) !!}
                        </a>
                    </span>
                    @endforeach
                </div>
                @endif

                @if ($product->kind == SC_PRODUCT_BUILD)
                <div class="products-group">
                    @php
                    $builds = $product->builds
                    @endphp
                    <b>{{ sc_language_render('product.kind_bundle') }}</b>:<br>
                    <span class="sc-product-build">
                        {!! sc_image_render($product->image) !!} =
                    </span>
                    @foreach ($builds as $k => $build)
                    {!! ($k) ? '<i class="fa fa-plus" aria-hidden="true"></i>':'' !!}
                    <span class="sc-product-build">{{ $build->quantity }} x
                        <a target="_new" href="{{ $build->product->getUrl() }}">{!!
                            sc_image_render($build->product->image) !!}</a>
                    </span>
                    @endforeach
                </div>
                @endif
                {{-- Product kind --}}

                
            </div>
            
            <hr class="hr-gray-100">
            {{-- Social --}}
            <div class="social_link d-flex gap-2">
                <b class="">Compartir: </b>
                <a target="blank" class="fs-5" href="https://api.whatsapp.com/send?phone=584126354041"><i class="fa-brands fa-facebook"></i></a>
                <a target="blank" class="fs-5" href="https://www.instagram.com/waikaimport/"><i class="fa-brands fa-instagram"></i></a>
            </div>

            {{--// Social --}}
            <input type="hidden" name="Cuotas" value="{!!$product->nro_coutas!!}">
            <input type="hidden" name="modalidad_pago" value="{!!$product->modalidad == "Mensual" ? 3: 2!!}">

        </form>
    </div>
</div>