<div class="section-wrapper">
    @php
    $productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top'))->getData();
    @endphp

    @if ($productsNew)
        <!-- New Products-->
    <section class="section section-xxl bg-default">
        <div class="container">
            <div class="row">
                <h3 class="title-section">{{ sc_language_render('front.products_new') }}</h3>
            </div>

            <article class="section-products">
                @foreach ($productsNew as $key => $productNew)
                    {{-- Render product single --}}
                    @include($sc_templatePath.'.common.product_single', ['product' => $productNew])
                    {{-- //Render product single --}}
                @endforeach
            </article>
        </div>
    </section>
    @endif
</div>