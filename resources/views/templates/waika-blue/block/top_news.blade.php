@php
$news = $modelNews->start()->setlimit(sc_config('item_top'))->getData();
@endphp

@if ($news)
<!-- START SECTION NEWS -->
  <section class="section section-xxl section-last bg-gray-21">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="">{{ sc_language_render('front.blog') }}</h2>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
          @foreach ($news as $blog)
            {{-- Render product single --}}
            @include($sc_templatePath.'.common.blog_single', ['blog' => $blog])
            {{-- //Render product single --}}
            @endforeach
      </div>
    </div>
      
  </section>
<!-- END SECTION NEWS -->
@endif