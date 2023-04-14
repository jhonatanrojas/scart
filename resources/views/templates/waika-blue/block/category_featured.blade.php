<div class="section-wrapper">
  <style>
    .owl-nav, .owl-next, .owl-dots{
      display: none;
    }
    .item_category{
      display: flex;
      flex-direction: column;
      gap: 20px;
      align-items: center;
      text-align: center;
    }
    .item_category img{
      display: block;
      width: 160px !important;
      height: 160px !important;
      background-color: #E6F3F8;
      border-radius: 20px;
      object-fit: cover;
      object-position: center;
      overflow: hidden;
    }
    .item_category a{
      font-family: Roboto;
      font-size: 16px;
      font-weight: 400;
      line-height: 19px;
      text-align: center;
      text-decoration: none;
      color: #000;
    }
  </style>
  <div class="container">
    <div class="row gap-1">
        <div class="col-12">
          <h3 class="title-section">{{ sc_language_render('front.categories') }}</h3>
        </div>
        <div class="col-12">
            @php
                $categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
            @endphp
            @if ($categoriesTop->count())
            <div class="owl-carousel categories owl-theme owl-loaded">
                <div class="owl-stage-outer">
                    <div class="owl-stage">
                      @foreach ($categoriesTop as $key => $category)
                      <div class="owl-item">
                          <div class="item_category">
                              <a class="d-inline-block" href="{{ $category->getUrl() }}">
                                  <img src="{{$category->image}}" alt="{{ $category->title }}">
                              </a>
                              <a class="" href="{{ $category->getUrl() }}"> {{ $category->title }}</a>
                          </div>
                      </div>
                      @endforeach
                    </div>
                </div>
                
            </div>
            @else
            No existen categorías
            @endif
        </div>
    </div>
  </div>

</div>

@pushOnce('scripts')
  <script>
      $('.categories').owlCarousel({
          loop:true,
          margin:10,
          nav: false,
          responsiveClass:true,
          responsive:{
              0:{
                  items:2,
                  nav:false
              },
              768:{
                  items:3,
                  nav:false
              },
              992:{
                  items: 5,
                  nav:true,
                  loop:false
              },
              1200:{
                  items: 7,
                  nav:true,
                  loop:false
              }
          }
      })
  </script>
@endPushOnce