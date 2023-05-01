      <!-- Page Footer-->
      <footer class="section footer-classic py-5" style="background: #E6F3F8;">
        
        <div class="footer-classic-body section-lg bg-brown-2">
          <div class="container">
            <div class="row justify-content-between">
              
              <div class="col-sm-6 col-lg-3">
                <p>
                  <a href="{{ sc_route('home') }}">
                    <img class="logo-footer" src="{{  sc_file(sc_store('logo', ($storeId ?? null))) }}" alt="{{ sc_store('title', ($storeId ?? null)) }}">
                  </a>
                </p>
                
                <p>{{ sc_store('title', ($storeId ?? null)) }}</p>
                <p> {!! sc_store('time_active', ($storeId ?? null))  !!}</p>
                
                <div class="footer-classic-social">
                  <div class="group-lg group-middle">
                    <div>
                      <ul class="list-inline list-social list-inline-sm">
                        @if (sc_config('facebook_url'))
                        <li><a class="icon mdi mdi-facebook" href="{{ sc_config('facebook_url') }}"></a></li>
                        @endif
                        @if (sc_config('twitter_url'))
                        <li><a class="icon mdi mdi-twitter" href="{{ sc_config('twitter_url') }}"></a></li>
                        @endif
                        @if (sc_config('instagram_url'))
                        <li><a class="icon mdi mdi-instagram" href="{{ sc_config('instagram_url') }}"></a></li>
                        @endif
                        @if (sc_config('youtube_url'))
                        <li><a class="icon mdi mdi-youtube-play" href="{{ sc_config('youtube_url') }}"></a></li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-sm-6 col-lg-3">
                <h4 class="footer-classic-title">{{ sc_language_render('about.page_title') }}</h4>
                <ul class="nav flex-column">
                  <li class="d-flex gap-2">
                      <i class="fa-solid fa-location-dot py-2 lh-sm"></i>
                      <a class="nav-link px-0 text-body" href="#">{{ sc_language_render('store.address') }}: {{ sc_store('address', ($storeId ?? null)) }}</a>
                  </li>
                  <li class="d-flex gap-2">
                    <i class="fa-solid fa-phone py-2 lh-sm"></i>
                    <a class="nav-link px-0 text-body" href="tel:#">{{ sc_language_render('store.hotline') }}: {{ sc_store('long_phone', ($storeId ?? null)) }}</a>
                  </li>
                  <li class="d-flex gap-2">
                    <i class="fa-solid fa-envelope py-2 lh-sm"></i>
                    <a class="nav-link px-0 text-body" href="mailto:#{{ sc_store('email', ($storeId ?? null)) }}">{{ sc_language_render('store.email') }}: {{ sc_store('email', ($storeId ?? null)) }}</a>
                  </li>
                </ul>
              </div>
              
              <div class="col-sm-12 col-lg-3">
                <h4 class="footer-classic-title"> {{ sc_language_render('front.my_profile') }}</h4>
                <!-- RD Mailform-->
                <ul class="nav flex-column">
                    @if (!empty($sc_layoutsUrl['footer']))
                    @foreach ($sc_layoutsUrl['footer'] as $url)
                    <li>
                        <a {{ ($url->target =='_blank')?'target=_blank':''  }} class="nav-link px-0 text-body"
                            href="{{ sc_url_render($url->url) }}">{{ sc_language_render($url->name) }}</a>
                    </li>
                    @endforeach
                    @endif
                </ul>

                {{-- <h5>{{ sc_language_render('subscribe.title') }}</h5>
                <form class="rd-form-inline rd-form-inline-2"  method="post" action="{{ sc_route('subscribe') }}">
                  @csrf
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="{{ sc_language_render('subscribe.email') }}" aria-label="{{ sc_language_render('subscribe.email') }}" aria-describedby="button-addon2" id="subscribe-form-2-email" type="email" name="subscribe_email" required>
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">{{ sc_language_render('action.submit') }}</button>
                  </div>
                </form> --}}
              </div>
            </div>
          </div>
        </div>

        {{-- <div class="footer-classic-panel">
          <div class="container">
            <div class="row row-10 align-items-center justify-content-sm-between">
              <div class="col-md-auto">
                <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>{{ sc_store('title', ($storeId ?? null)) }}</span><span>.&nbsp; All rights reserved</span></p>
              </div>
              @if (sc_config('fanpage_url'))
              <div class="col-md-auto order-md-1"> <a target="_blank"
                href="{{ sc_config('fanpage_url') }}">Fanpage FB</a>
              </div>
              @endif
              @if (!sc_config('hidden_copyright_footer'))
              <div class="col-md-auto">
                    Power by <a href="{{ config('s-cart.homepage') }}">{{ config('s-cart.name') }} {{ config('s-cart.sub-version') }}</a>
              </div>
              @endif
            </div>
          </div>
        </div> --}}
      </footer>