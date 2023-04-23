<header class="section page-header bg-white mb-3">

  
    <div class="container">
      <div class="row align-items-center gy-2 gy-lg-0 py-2">
        <div class="col-6 col-lg-3 order-0 order-lg-0">
          {{-- LOGO --}}
          <a class="navbar-brand" href="{{ sc_route('home') }}">
            <img class="" src="{{ sc_file(sc_store('logo', ($storeId ?? null))) }}" alt="{{$title??sc_store('title')}}"/>
          </a>
        </div>

        <div class="col-12 col-lg-6 order-2 order-lg-1">
          {{-- FORM HEADER --}}
          <form class="form-header d-flex flex-fill mb-0" action="{{ sc_route('search') }}"  method="GET" role="search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="{{ sc_language_render('search.placeholder') }}" aria-label="{{ sc_language_render('search.placeholder') }}" aria-describedby="button-Search">
              <button class="btn btn-outline-secondary" type="submit" id="button-Search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
          </form>
        </div>
        
        <div class="col-6 col-lg-3 order-1 order-lg-2">
          {{-- MENÚ RIGHT --}}
            <ul class="nav-account nav justify-content-end">
              @if (sc_config('link_account', null, 1))
                @guest
                  <li class="nav-item">
                    <a class="nav-link text-uppercase" href="{{ sc_route('register') }}">{{ sc_language_render('customer.signup') }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase" href="{{ sc_route('login') }}">{{ sc_language_render('front.login') }}</a>
                  </li>
                @else
                  <li class="nav-item">
                    <a class="nav-link text-uppercase" href="{{ sc_route('customer.index') }}">{{ sc_language_render('customer.my_account') }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase" href="{{ sc_route('logout') }}">{{ sc_language_render('front.logout') }}</a>
                  </li>
                @endguest
              @endif
            </ul>
        </div>
        
      </div>
    </div>

  {{-- NAVBAR 2 --}}
  <nav class="navbar navbar-expand-lg py-2" style="background: #E6F3F8;">
    <div class="container">

      {{-- categorias --}}
      <div class="dropdown">
        <button class="btn btn-light rounded-pill btn-sm px-4 gap-2 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          {{ sc_language_render('front.categories') }}
          <i class="fa-solid fa-angle-down" style="margin-top: 4px;"></i>
        </button>
        
        @php
          $categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
        @endphp
        
        @if ($categoriesTop->count())
            <ul class="dropdown-menu">
              @foreach ($categoriesTop as $key => $category)
              <li class="">
                <a class="dropdown-item" href="{{ $category->getUrl() }}"> {{ $category->title }}</a>
              </li>
              @endforeach
            </ul>
        @endif
      </div>

      {{-- BOTON RESPONSIVE --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      
      <div class="collapse navbar-collapse flex-grow-0 py-3 py-lg-0" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-lg-0">
          {{-- menu dinamico --}}
          @if (!empty($sc_layoutsUrl['menu']))
              @foreach ($sc_layoutsUrl['menu'] as $url)
                <li class="nav-item">
                    <a class="nav-link text-capitalize" {{ ($url->target =='_blank')?'target=_blank':''  }}
                        href="{{ sc_url_render($url->url) }}">{{ sc_language_render($url->name) }}</a>
                </li>
              @endforeach 
          @endif
          {{-- wishlist y compare --}}
          <li class="nav-item">
            <a class="nav-link text-capitalize" href="{{ sc_route('wishlist') }}">{{ sc_language_render('front.wishlist') }} {{ Cart::instance('wishlist')->count() }}</a>
          </li>
         {{--  <li class="nav-item text-capitalize">
            <a class="nav-link" href="{{ sc_route('compare') }}">{{ sc_language_render('front.compare') }} {{ Cart::instance('compare')->count() }}</a>
          </li> --}}
          
        </ul>
      </div>
      
    </div>
  </nav>

</header>
