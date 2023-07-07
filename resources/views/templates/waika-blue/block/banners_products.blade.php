@php
$banners = $modelBanner->start()->setType('banner')->getData();

$counterBanners = 1;
@endphp
@if (!empty($banners))

<div class="section-wrapper">
  
  <style>
    .container-banners {
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      display: grid;
    }

    /* distribución de areas */
    .banner1 { grid-area: banner1; }
    .banner2 { grid-area: banner2; }
    .banner3 { grid-area: banner3; }
    .banner4 { grid-area: banner4; }

    /* background de banners */
    .banner1 { background: linear-gradient(180deg, #0084B9 0%, #00396A 100%);}
    .banner2 { background: linear-gradient(103.7deg, #FFC2D8 30.73%, #FFDAE7 100%);}
    .banner3 { background: linear-gradient(127.99deg, #FEC337 57.83%, #FFDB85 93.99%);}
    .banner4 { background: linear-gradient(100.08deg, #CF191A 3.16%, #FF0001 92.06%);}

    /* Colores de titulos en banners */
    .banner1 .title-banner { color: #ffffff; }
    .banner2 .title-banner { color: #ffffff; }
    .banner3 .title-banner { color: #0080B6; }
    .banner4 .title-banner { color: #ffffff; }

    /* teléfonos <576px */
    .container-banners {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        gap: 16px 16px;
        grid-auto-flow: row;
        grid-template-areas:
          "banner1"
          "banner2"
          "banner3"
          "banner4";
      }

      .banner1, .banner2, .banner3, .banner4{
        max-width: 100%;
        height: 100%;
        min-height: 380px;
        position: relative;
        display: flex;
        flex-direction: row;
        border-radius: 12px;
      }

      /* Padding banners */
      .banner1, .banner2, .banner3, .banner4{ padding: 16px; }

      /* Tamaños de titulos en banners */
      .banner1 .title-banner, .banner2 .title-banner, .banner3 .title-banner, .banner4 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 32px;
        line-height: 36px;
        z-index: 1;
      }

      /* Tamaños de imagenes en banners */
      .banner1 img, .banner2 img, .banner3 img, .banner4 img{
        width: 100% !important;
        height: 100% !important;
        max-width: 360px;
        max-height: 380px;
        object-fit: contain;
        object-position: center;
      }
    
    /* media query dispositivos ≥576px*/
    @media (min-width: 576px)
    {
      .container-banners {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        gap: 16px 16px;
        grid-auto-flow: row;
        grid-template-areas:
          "banner1"
          "banner2"
          "banner3"
          "banner4";
      }

      .banner1, .banner2, .banner3, .banner4{
        max-width: 100%;
        height: 100%;
        min-height: 380px;
        position: relative;
        display: flex;
        flex-direction: row;
        border-radius: 12px;
      }

      /* Padding banners */
      .banner1, .banner2, .banner3, .banner4{ padding: 16px; }

      /* Tamaños de titulos en banners */
      .banner1 .title-banner, .banner2 .title-banner, .banner3 .title-banner, .banner4 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 32px;
        line-height: 36px;
        z-index: 1;
      }

      /* Tamaños de imagenes en banners */
      .banner1 img, .banner2 img, .banner3 img, .banner4 img{
        width: 100% !important;
        height: 100% !important;
        max-width: 360px;
        max-height: 380px;
        object-fit: contain;
        object-position: center;
      }
    }
    @media (min-width: 768px)
    {
      .container-banners {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        gap: 16px 16px;
        grid-auto-flow: row;
        grid-template-areas:
          "banner1"
          "banner2"
          "banner3"
          "banner4";
      }

      .banner1, .banner2, .banner3, .banner4{
        max-width: 100%;
        height: 100%;
        min-height: 380px;
        position: relative;
        display: flex;
        flex-direction: row;
        border-radius: 12px;
      }

      /* Padding banners */
      .banner1, .banner2, .banner3, .banner4{ padding: 16px; }

      /* Tamaños de titulos en banners */
      .banner1 .title-banner, .banner2 .title-banner, .banner3 .title-banner, .banner4 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 32px;
        line-height: 36px;
        z-index: 1;
      }

      /* Tamaños de imagenes en banners */
      .banner1 img, .banner2 img, .banner3 img, .banner4 img{
        width: 100% !important;
        height: 100% !important;
        max-width: 360px;
        max-height: 380px;
        object-fit: contain;
        object-position: center;
      } 
    }
    @media (min-width: 992px)
    {
      .container-banners {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 16px 16px;
        grid-auto-flow: row;
        grid-template-areas:
          "banner1 banner2"
          "banner3 banner4";
      }

      .banner1, .banner2, .banner3, .banner4{
        max-width: 100%;
        height: 100%;
        min-height: 280px;
        position: relative;
        display: flex;
        flex-direction: row;
        border-radius: 12px;
      }

      /* Padding banners */
      .banner1, .banner2, .banner3, .banner4{ padding: 16px; }

      /* Tamaños de titulos en banners */
      .banner1 .title-banner, .banner2 .title-banner, .banner3 .title-banner, .banner4 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 42px;
        line-height: 48px;
        z-index: 1;
      }

      /* Tamaños de imagenes en banners */
      .banner1 img, .banner2 img, .banner3 img, .banner4 img{
        width: 100% !important;
        height: 100% !important;
        max-width: 260px;
        max-height: 280px;
        object-fit: contain;
        object-position: center;
      } 
    }
    @media (min-width: 1200px)
    {
      .container-banners {
        grid-template-columns: 2fr 1fr 1fr;
        grid-template-rows: 228px 152px;
        gap: 16px 16px;
        grid-auto-flow: row;
        grid-template-areas:
          "banner1 banner2 banner2"
          "banner1 banner3 banner4";
      }
      .banner1, .banner2, .banner3, .banner4{
        max-width: 100%;
        height: 100%;
        min-height: 152px;
        position: relative;
        display: flex;
        flex-direction: row;
        border-radius: 12px;
      }

      /* Padding banners */
      .banner1, .banner2, .banner3, .banner4{ padding: 16px; }
      .banner1 { padding: 54px; }

      /* Tamaños de titulos en banners */
      .banner1 .title-banner, .banner2 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 42px;
        line-height: 48px;
        z-index: 1;
      }
      .banner3 .title-banner, .banner4 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 26px;
        line-height: 26px;
        z-index: 1;
      }

      /* Tamaños de imagenes en banners */
      .banner1 img, .banner2 img, .banner3 img, .banner4 img{
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        object-position: center;
      }
      .banner1 img{
        max-width: 260px;
        max-height: 280px;
      }
      .banner2 img{
        max-width: 260px;
        max-height: 220px;
      }
      .banner3 img, .banner4 img{
        max-width: 130px;
        max-height: 130px;
      }      
    }
    @media (min-width: 1400px)
    {
      .container-banners {
        grid-template-columns: 2fr 1fr 1fr;
        grid-template-rows: 228px 152px;
        gap: 16px 16px;
        grid-auto-flow: row;
        grid-template-areas:
          "banner1 banner2 banner2"
          "banner1 banner3 banner4";
      }
      .banner1, .banner2, .banner3, .banner4{
        max-width: 100%;
        height: 100%;
        min-height: 152px;
        position: relative;
        display: flex;
        flex-direction: row;
        border-radius: 12px;
      }

      /* Padding banners */
      .banner1, .banner2, .banner3, .banner4{ padding: 16px; }
      .banner1 { padding: 54px; }

      /* Tamaños de titulos en banners */
      .banner1 .title-banner, .banner2 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 42px;
        line-height: 48px;
        z-index: 1;
      }
      .banner3 .title-banner, .banner4 .title-banner {
        font-style: normal;
        font-weight: 800;
        font-size: 26px;
        line-height: 26px;
        z-index: 1;
      }

      /* Tamaños de imagenes en banners */
      .banner1 img, .banner2 img, .banner3 img, .banner4 img{
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        object-position: center;
      }
      .banner1 img{
        max-width: 260px;
        max-height: 280px;
      }
      .banner2 img{
        max-width: 260px;
        max-height: 220px;
      }
      .banner3 img, .banner4 img{
        max-width: 130px;
        max-height: 130px;
      }
    }
  </style>

  <div class="container">
    <div class="row">
      <div class="col-12">

        <div class="container-banners">
      
          @foreach ($banners as $key => $banner)
          <div class="flex flex-wrap banner{{$counterBanners}}">
            <div class="col-12 col-md-6 col-lg-7 col-xl-7 col-xxl-6 p-2 d-flex flex-column justify-content-center align-items-start gap-2">
              <h3 class="title-banner">{{ $banner->title }}</h3>
              <a href="{{ $banner->url }}" class="btn btn-light rounded-pill btn-sm" target="{{ $banner->target }}" rel="noopener noreferrer">
                {{ sc_language_render('action.buy_now') }}	
              </a>
            </div>
            <div class="col-12 col-md-6 col-lg-5 col-xl-5 col-xxl-6 p-0 d-flex flex-column justify-content-center align-items-end">
              <img src="{{ sc_file($banner->image) }}" alt="{{ $banner->title }}">
            </div>
            {{-- {!! sc_html_render($banner->html) !!} --}}
            
            @php
              $counterBanners = $counterBanners + 1;
            @endphp
          </div>
          @endforeach
        </div>


      </div>
    </div>
  </div>
    
      
  <!--slider-->
</div>

@endif