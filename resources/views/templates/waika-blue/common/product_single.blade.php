<article class="product wow fadeInRight">
    <div class="product-body">
      <div class="product-figure">
          <a href="{{ $product->getUrl() }}">
          <img src="{{ sc_file($product->getThumb()) }}" alt="{{ $product->name }}"/>
          </a>
      </div>
      <h6 class="product-title"><a href="{{ $product->getUrl() }}">{{ $product->name }}</a></h6>



 
      {!! $product->displayVendor() !!}
     @php
     $product->nro_coutas=      $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
     if( $product->precio_de_cuota > 0 ):
     $product->price=  $product->price-$product->monto_inicial;
    endif;


     @endphp
      @if( $product->precio_de_cuota)
   
      @php
      $modalida_pago='Quincenales';
         if($product->id_modalidad_pagos==3)
         $modalida_pago='Mensuales';
   
         @endphp
         <div class="product-price-wrap">
          @if( $product->monto_inicial > 0 )

          Inicial de  ${!! number_format($product->monto_inicial,0)  !!} <br>
           @endif
           <div class="product-modern-title "> 
          
             <a href="{{ $product->getUrl() }}">
            
          {{ $product->nro_coutas}} cuotas de
             
           </a>
           
           </div>
      
      <div class="product-price-wrap">
      
        <div class="product-price">${!!  number_format($product->price/$product->nro_coutas,2) !!}   </div>
        <div class="product-cuotas">    <a href="{{ $product->getUrl() }}">{!! $modalida_pago !!}     </a>  </div>

      </div>

      @else
      {!! $product->showPrice() !!} 
      @endif


   
        </div>
      {{-- @if (empty($hiddenStore))
      {!! $product->displayVendor() !!}
      @endif --}}

      {{-- @if ($product->allowSale() && !sc_config('product_cart_off'))
      <a onClick="addToCartAjax('{{ $product->id }}','default','{{ $product->store_id }}')" class="button button-secondary button-zakaria add-to-cart-list">
        <i class="fa fa-cart-plus"></i> {{sc_language_render('action.add_to_cart')}}</a>
      @endif --}}

      {{-- {!! $product->showPrice() !!} --}}
    </div>
    @if( $product->precio_de_cuota)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/etiqueta.png') }}" class="new" alt="" /></span> 
    @endif
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
        <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','wishlist','{{ $product->store_id }}')">
          <i class="fas fa-heart"></i>
        </a>
      </div>
      @endif

      @if (!sc_config('product_compare_off'))
      <div class="product-button">
          <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','compare','{{ $product->store_id }}')">
              <i class="fa fa-exchange"></i>
          </a>
      </div>
      @endif
    </div>
</article>