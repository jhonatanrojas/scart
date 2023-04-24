@switch($kind)
    @case(SC_PRODUCT_GROUP)
        <span class="price__product_new">{!! sc_language_render('product.price_group') !!}</span>
        @break
    @default
        @if ($price == $priceFinal)
            <span class="price__product_new">{!! sc_currency_render($price) !!}</span>
        @else
            <span class="price__product_new">{!! sc_currency_render($priceFinal) !!}</span>
            <span class="price__product_old">{!!  sc_currency_render($price) !!}</span>
        @endif
@endswitch