<div class="section-wrapper">
    <style>
        .owl-nav, .owl-next, .owl-dots{
          display: none;
        }
        .item_carrousel_step{
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            text-align: center;
        }
        .item_carrousel_step figure{
          display: block;
          position: relative;
          margin: 0;
          width: 100%;
          height: 100%;
          border-radius: 20px;
          overflow: hidden;
        }
        .item_carrousel_step img{
          display: block;
          width: 100% !important;
          height: 100% !important;
          background-color: #E6F3F8;
          object-fit: cover;
          object-position: center;
          overflow: hidden;
        }
        .item_carrousel_step a{
          font-family: Roboto;
          font-size: 16px;
          font-weight: 600;
          line-height: 19px;
          text-align: center;
          text-decoration: none;
          color: #000;
        }
        .bg-overlay{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 128, 182, 0.65) 0%, rgba(254, 195, 55, 0.65) 100%, rgba(254, 195, 55, 0.65) 100%);
        }
      </style>

   
    <section class="section">
        <div class="container">
            <div class="row">
                <h3 class="title-section">
                    {{-- {{ sc_language_render('front.products_recommend') }} --}}
                    Financiamiento en 5 pasos
                </h3>
            </div>

            <article class="section_carrousel">
                <div class="owl-carousel carrousel_step owl-theme owl-loaded">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                          <div class="owl-item">
                              <div class="item_carrousel_step">
                                <figure>
                                    <img src="{{asset('data/page/img-carrousel-1.png')}}" alt="#">
                                    <div class="bg-overlay"></div>
                                </figure>
                                    <a class="" href="#">1 Selecciona el producto</a>
                              </div>
                          </div>
                          <div class="owl-item">
                            <div class="item_carrousel_step">
                                <figure>
                                    <img src="{{asset('data/page/img-carrousel-2.png')}}" alt="#">
                                    <div class="bg-overlay"></div>
                                </figure>
                                <a class="" href="#">2 Contáctanos o visítanos en la oficina comercial</a>
                            </div>
                        </div>
                        <div class="owl-item">
                            <div class="item_carrousel_step">
                                <figure>
                                    <img src="{{asset('data/page/img-carrousel-3.png')}}" alt="#">
                                    <div class="bg-overlay"></div>
                                </figure>
                                <a class="" href="#">3 Firma de convenio</a>
                            </div>
                        </div>
                        <div class="owl-item">
                            <div class="item_carrousel_step">
                                <figure>
                                    <img src="{{asset('data/page/img-carrousel-4.png')}}" alt="#">
                                    <div class="bg-overlay"></div>
                                </figure>
                                <a class="" href="#">4 Realiza el pago de las primeras cuotas o pago inicial</a>
                            </div>
                        </div>
                        <div class="owl-item">
                            <div class="item_carrousel_step">
                                <figure>
                                    <img src="{{asset('data/page/img-carrousel-5.png')}}" alt="#">
                                    <div class="bg-overlay"></div>
                                </figure>
                                <a class="" href="#">5 Disfruta de tu producto y sigue pagando en cómodas cuotas</a>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
@pushOnce('scripts')
  <script>
      $('.carrousel_step').owlCarousel({
          loop: false,
          margin:20,
          nav: false,
          responsiveClass:true,
          autoplay: true,
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
                  items: 4,
                  nav:true,
                  loop:false
              },
              1200:{
                  items: 5,
                  nav:true,
                  loop:false
              }
          }
      })
  </script>
@endPushOnce