<div>
    <style>
        .title__product {
            font-style: normal;
            font-weight: 500;
            font-size: 22px;
            line-height: 26px;
            color: #000000;
        }
        .price__product_new {
            font-style: normal;
            font-weight: 300;
            font-size: 28px;
            line-height: 33px;
        }
        .price__product_old {
            font-style: normal;
            font-weight: 300;
            font-size: 20px;
            line-height: 23px;
            text-decoration: line-through;
        }
        .price__product_initial_payment {
            font-style: normal;
            font-weight: 300;
            font-size: 18px;
            line-height: 21px;
            color: #000000;
        }
        .extract__product {
            font-style: normal;
            font-weight: 300;
            font-size: 12px;
            line-height: 14px;
        }
        .btn-themes {
            color: #fff;
            background-color: #0080B6;
            border-color: #0080B6;
        }
        .btn-themes:hover {
            color: #fff;
            background-color: #03628A;
            border-color: #03628A;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <form id="buy_block" class="product-information" action="{{ sc_route('cart.add') }}" method="post">
                {{ csrf_field() }}
                
                <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
                <input type="hidden" name="storeId" id="product-detail-storeId" value="{{ $product->store_id }}" />
                
                <div class="single-product">
                    <h1 class="title__product" id="product-detail-name">
                        {{ $product->name }}
                    </h1>
                
                    {!! $product->displayVendor() !!}
                
                    {{-- <p>
                    SKU: <span id="product-detail-model">{{ $product->sku }}</span>
                    </p> --}}

                    {{-- Show price --}}
                    <div class="d-flex flex-column gap-2">
                        <div class="single-product-price" id="product-detail-price">
                            @php
                            $product->nro_coutas = $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
                            $product->price_con_inicial = ($product->price-$product->monto_inicial - $product->monto_cuota_entrega);


                            if($product->cuotas_inmediatas > 0 && $product->nro_coutas == 1){
                               
                                $total_inicial = number_format(($product->price  - $product->monto_inicial)/$product->cuotas_inmediatas,2);
                                

                            }

                               
           



                            @endphp
                            
                            @if( $product->precio_de_cuota)
                                <div class="product-price-wrap">
                                    <span class="price__product_new">
                                        ${!! $product->nro_coutas > 1 ? number_format($product->price_con_inicial/$product->nro_coutas,2):$total_inicial!!}
                                    </span>
                                </div>

                                
                            @else
                                {!! $product->showPriceDetail() !!}
                            @endif
                        
                            @php
                                $total_cuotas=0;
                                if($product->nro_coutas > 0) {
                                    $product->nro_coutas = $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
                                    $total_cuotas = $product->price / $product->nro_coutas;  
                                }

                               
                            @endphp
                        </div>
                        <div>
                            @if( $product->monto_inicial > 0 )
                            <span class="price__product_initial_payment text-muted">
                                Inicial de ${!! number_format($product->monto_inicial,2)  !!}
                            </span>
                            @endif
                            <br>

                             @if( $product->monto_cuota_entrega > 0 )
                            <span class="price__product_initial_payment text-muted">
                                Cuota especial ${!! number_format($product->monto_cuota_entrega,2)  !!}
                            </span>
                            @endif
                        </div>
                        
                        <p class="extract__product">
                            {{ $product->description}}
                        </p>
                    </div>
                    {{--// Show price --}}
                    <div class="d-flex flex-column gap-2">
                        <div class="d-grid gap-2">
                            @if (sc_config('customer_pagar_al_contado'))
                                <button class="btn btn-primary rounded-pill"
                                    onclick="validachecke1(), validachecke1()"
                                    id="descotado"
                                    name="Des_contado"
                                    type="button"
                                >Pagar al contado</button>
                            @endif
                            {{-- <button class="btn btn-themes rounded-pill" 
                                onclick="validachecke2() ,gen_table()"  
                                data-toggle="modal" 
                                data-target="#myModal" 
                                type="button" 
                                class="pedido p-3  text-white " 
                                name="Financiamiento"
                            >Calcular Solicitud</button> --}}
                            <button
                                onclick="validachecke2() ,gen_table()" 
                                name="Financiamiento"
                                type="button" class="btn btn-themes rounded-pill pedido" data-bs-toggle="modal" data-bs-target="#formModal">
                                Calcular Solicitud
                              </button>
                        </div>

                        <div class="messages">
                            <p class="text-danger" id="msg"></p>
                        </div>

                        {{-- Button add to cart --}}
                        @if ($product->kind != SC_PRODUCT_GROUP && $product->allowSale() && !sc_config('product_cart_off'))
                            <div id="group" class="group-xs group-middle" >
                                <div class="product-stepper" >
                                    <input class="form-input" name="qty" type="number" data-zeros="true" value="1" min="1" max="100">
                                </div>
                                <div class="d-grid gap-2">
                                    <button id="buton" class="btn-secondary" type="submit">{{ sc_language_render('action.add_to_cart') }}</button>
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
                                        <b>{{ sc_language_render('product.out_stock') }}</b>
                                    @else 
                                        <b>{{ sc_language_render('product.in_stock') }} </b>
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
                                <a class="text-decoration-none" href="{{ $category->getUrl() }}">{{ $category->getTitle() }}</a>,
                            @endforeach
                        </div>
                        {{--// Category info --}}
                        
                        {{-- Brand info --}}
                        @if (sc_config('product_brand') && !empty($product->brand->name))
                        <div>
                            {{ sc_language_render('product.brand') }}:
                            <span id="product-detail-brand">
                                {!! empty($product->brand->name) ? 'None' : '<a class="text-decoration-none" href="'.$product->brand->getUrl().'">'.$product->brand->name.'</a>' !!}
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
                                    <a class="text-decoration-none" target=_blank href="{{ $group->product->getUrl() }}">
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

                    {{-- Social --}}
                    <div class="social_link d-flex gap-2">
                        <b class="">Compartir: </b>
                        <a target="blank" class="fs-5" href="https://api.whatsapp.com/send?phone=584126354041"><i class="fa-brands fa-facebook"></i></a>
                        <a target="blank" class="fs-5" href="https://www.instagram.com/waikaimport/"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                    {{--// Social --}}
                    <input type="hidden" name="Cuotas" value="{!!$product->nro_coutas!!}">
                    <input type="hidden" name="modalidad_pago" value="{!!$product->modalidad == "Mensual" ? 3: 2!!}">
                </div>
            </form>
        </div>
    </div>

</div>