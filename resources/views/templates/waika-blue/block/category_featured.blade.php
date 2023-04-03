<div class="container">
  <div class="row">
      <div class="col-12">
          @php
              $categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
          @endphp
          @if ($categoriesTop->count())
          <div class="owl-carousel owl-theme owl-loaded">
              <div class="owl-stage-outer">
                  <div class="owl-stage">
                      
                          @foreach ($categoriesTop as $key => $category)
                          <div class="owl-item">
                              <div class="item_category">
                                  <a class="" href="{{ $category->getUrl() }}">
                                      <img src="{{$category->image}}" width="200" alt="">
                                  </a>
                                  <a class="" href="{{ $category->getUrl() }}"> {{ $category->title }}</a>
                              </div>
                          </div>
                          @endforeach
                  </div>
              </div>
              {{-- <div class="owl-nav">
                  <div class="owl-prev">prev</div>
                  <div class="owl-next">next</div>
              </div>
              <div class="owl-dots">
                  <div class="owl-dot active"><span></span></div>
                  <div class="owl-dot"><span></span></div>
                  <div class="owl-dot"><span></span></div>
              </div> --}}
          </div>
          @else
          No existen categorías
          @endif
      </div>
  </div>
</div>
@push('scripts')
  <script>
      $('.owl-carousel').owlCarousel({
          loop:true,
          margin:10,
          responsiveClass:true,
          responsive:{
              0:{
                  items:1,
                  nav:true
              },
              600:{
                  items:3,
                  nav:false
              },
              1000:{
                  items:5,
                  nav:true,
                  loop:false
              }
          }
      })
  </script>
@endpush