@php
$productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top'))->getData();
@endphp

@if ($productsNew)
      <!-- New Products-->
<section class="section section-xxl bg-default">
    <div class="container">
        <div class="row">
            <h2 class="">{{ sc_language_render('front.products_new') }}</h2>
        </div>

        <article class="d-flex flex-wrap gap-5">
            @foreach ($productsNew as $key => $productNew)
                {{-- Render product single --}}
                @include($sc_templatePath.'.common.product_single', ['product' => $productNew])
                {{-- //Render product single --}}
            @endforeach
        </article>
    </div>
</section>
@endif