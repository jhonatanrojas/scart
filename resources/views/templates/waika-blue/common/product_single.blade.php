<product class="product-card card border border-0 shadow-sm overflow-hidden">
  <figure class="card-img-top m-0 img-featured">
    <a class="" href="{{$product->getUrl()}}">
      <img src="{{ sc_file($product->getThumb()) }}" alt="{{ $product->name }}" width="200px" height="190px"/>
    </a>
  </figure>
    
    <div class="card-body">
        @php
        $product->nro_coutas=$product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
          if( $product->precio_de_cuota > 0 ):
            $product->price=  ($product->price-$product->monto_inicial) - $product->monto_cuota_entrega;
          endif;


        
        @endphp
        
        @if( $product->precio_de_cuota)
          @php

            $total_inicial = 0.03;

            $modalida_pago='Quincenales';
            if($product->id_modalidad_pagos==3)
            $modalida_pago='Mensuales';


            if($product->cuotas_inmediatas > 0 && $product->nro_coutas == 1){
                               
                               $total_inicial = number_format(($product->cost  - $product->monto_inicial)/$product->cuotas_inmediatas,2);

                              
                               

                           }
          @endphp

          <div class="product-price-wrap">
            <div class="product-price">${!!$product->nro_coutas > 1 ? number_format($product->price/$product->nro_coutas,2):$total_inicial !!}</div>
          </div>

          <div class="product-price-wrap text-muted">
              @if( $product->monto_inicial > 0 )
                Inicial de  ${!! number_format($product->monto_inicial,2)  !!} <br>
              @endif

              @if( $product->monto_cuota_entrega > 0 )
              Cuota de  entrega  ${!!number_format($product->monto_cuota_entrega,2)!!} <br>
            @endif
              
              <span class="product-cuotas">{!!$product->nro_coutas > 1 ? $product->nro_coutas :$product->cuotas_inmediatas!!} cuotas {!! $modalida_pago !!}</span>
          </div>
  
          
  
        @else
        {!! $product->showPrice() !!} 
        @endif

        <h3 class="card-title"><a href="{{ $product->getUrl() }}">{{ $product->name }}</a></h3>
        {!! $product->displayVendor() !!}

      {{-- @if (empty($hiddenStore))
      {!! $product->displayVendor() !!}
      @endif --}}

      {{-- @if ($product->allowSale() && !sc_config('product_cart_off'))
      <a onClick="addToCartAjax('{{ $product->id }}','default','{{ $product->store_id }}')" class="button button-secondary button-zakaria add-to-cart-list">
        <i class="fa fa-cart-plus"></i> {{sc_language_render('action.add_to_cart')}}</a>
      @endif --}}

      {{-- {!! $product->showPrice() !!} --}}

    </div>

    
    {{-- @if( $product->precio_de_cuota)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/etiqueta.png') }}" class="new" alt="" /></span> 
    @endif --}}


     {{-- @if ($product->price != $product->getFinalPrice() && $product->kind !=SC_PRODUCT_GROUP)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
    @elseif($product->kind == SC_PRODUCT_BUILD)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
    @elseif($product->kind == SC_PRODUCT_GROUP)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
    @endif --}}
    
    <div class="product-button-wrap">
      
      @if (!sc_config('product_wishlist_off'))
      <div class="product-button">
        <a class="button-like" onClick="addToCartAjax('{{ $product->id }}','wishlist','{{ $product->store_id }}')">
          <i class="fas fa-heart"></i>
        </a>
      </div>
      @endif

      @if (!sc_config('product_compare_off'))
      <div class="product-button">
          <a class="button-exchange" onClick="addToCartAjax('{{ $product->id }}','compare','{{ $product->store_id }}')">
              <i class="fa fa-exchange"></i>
          </a>
      </div>
      @endif
    </div>
  </product>