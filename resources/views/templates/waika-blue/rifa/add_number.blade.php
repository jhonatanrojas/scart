{{-- @php

$layout_page = shop_product_detail
**Variables:**
- $product: no paginate
- $productRelation: no paginate

@endphp --}}

<div>
    <style>
        .splide__slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .splide__slide {
            opacity: 0.6;
        }

        .splide__slide.is-active {
            opacity: 1;
        }

        .splide__list {
            height: auto !important;
        }

        .splide__track--nav>.splide__list>.splide__slide {
            border: 1px solid #E8E8E8;
            border-radius: 2px;
            overflow: hidden;
        }

        .splide__track--nav>.splide__list>.splide__slide.is-active {
            border: 1px solid #0080B6 !important;
            border-radius: 2px;
        }

        @import url('https://fonts.googleapis.com/css?family=DM+Sans&display=swap');


        .fecha h5 {
            font-size: 2em;
        }

        .pedido {

            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;

            width: 100%;
            height: 51px;
            background-color: rgb(19.922, 95.751, 139.45);
            border-radius: 10px;

            border: none;

            /* Inside auto layout */
            flex: none;
            order: 2;
            align-self: stretch;
            flex-grow: 0;
            transition: 0.20s;
        }

        .pedido:hover {

            background: #208bff;

        }



        .modal {
            border: solid 1px rgba(126, 126, 126, 0.534);

        }

        /* .modal .modal-body{
          background-image: url('https://images.pexels.com/photos/6958525/pexels-photo-6958525.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
    
          background-repeat: no-repeat;
          background-size: cover;
    
    
          box-shadow: 0px 4px 50px 3px rgba(0, 0, 0, 0.25);
          border-radius: 20px;
        } */

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;

        }

        .financiando {
            flex-direction: row-reverse;
            display: flex;

        }

        @media screen and (max-width: 375px) {
            /* .modal .modal-dialog{
            margin-top: 5px;
          } */

            .table-1 {
                width: 80%;

            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 90%;
            }

            .financiando {
                flex-direction: column;
                text-align: center;
            }
        }

        @media screen and (max-width: 360px) {
            /* .modal .modal-dialog{
           margin-top: 5px;
    
          } */

            .table-1 {
                width: 100%;

            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
            }

            .financiando {
                flex-direction: column;
                text-align: center;
            }
        }

        @media screen and (min-width: 314px) {
            .table-1 {
                width: 90%;

            }
        }

        .radioContenedor2 #descotado:hover {
            color: white;
        }

        #contenedor,
        #contenedorTabla {
            /* background-color: #FFF; */
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            /* overflow: hidden; */
            width: 100%;
            max-width: 100%;
            /* margin: 20px; */
        }

        #contenedorTabla {
            width: 800px;
            max-height: 820px;
            overflow-y: scroll;
        }

        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #16a0b3;
        }

        .header,
        thead {
            border-bottom: 1px solid #F0F0F0;
            background-color: #F7F7F7;
            padding: 20px 40px;
        }

        .header h2 {
            margin: 0;
        }

        #frmPrestamo {
            padding: 10px 15px;
        }

        #frmPrestamo .control,
        #amortizaciones .control,
        .radios {
            margin-bottom: 10px;
            padding-bottom: 20px;
            position: relative;
        }

        #frmPrestamo .control label {
            margin-bottom: 5px;
        }

        #frmPrestamo .control input,
        #frmPrestamo .control select {
            border: 2px solid #F0F0F0;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
            padding: 10px;
            width: 100%;
        }

        #frmPrestamo .control input:focus {
            outline: 0;
            border-color: royalblue;
        }

        #frmPrestamo button {
            background: rgba(65, 105, 225, 90%);
            border: 2px solid royalblue;
            border-radius: 4px;
            color: #FFF;
            display: block;
            font-family: inherit;
            font-size: medium;
            padding: 10px;
            margin-top: 20px;
            width: 100%;
        }

        /* table {
          border-collapse: collapse;
          border-radius: 4px;
          width: 100%;
          font-family: inherit;
          font-size: 0.9em;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        } */

        table thead tr {
            background: royalblue;
            color: white;
            text-align: left;
            font-weight: bold;
        }

        table thead,
        td {
            padding: 12px 15px;
        }

        table tbody tr {
            border-bottom: 1px solid #F0F0F0;
        }

        table tbody tr:nth-last-of-type(even) {
            background-color: #F3F3F3;
        }

        table tbody tr:last-of-type {
            border-bottom: 2px solid royalblue;
        }

        table tbody tr:hover {
            color: white;
            background: #4169e0e6;
        }

        table tfoot {
            background: royalblue;
            color: white;
        }

        .radios {
            padding: 10px 20px;
        }

        .radioContenedor {
            display: inline-block;
            position: relative;
            cursor: pointer;
            user-select: none;


        }

        .radioContenedor2 {
            display: inline-block;
            position: relative;
            cursor: pointer;
            user-select: none;


        }

        .radioContenedor input {
            display: none;
        }

        .radioContenedor2 input {
            display: none;

        }



        .radioContenedor:hover .circle {
            background-color: royalblue;
        }


        .radioContenedor input:checked+.circle {
            background-color: royalblue;
        }

        .radioContenedor input:checked+.circle:after {
            content: '';
            height: 10px;
            width: 10px;
            background-color: white;
            position: absolute;
            border-radius: 50%;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</div>



@extends($sc_templatePath . '.layout')
{{-- block_main --}}

@section('block_main_content_center')
    @php
        $countItem = 0;
    @endphp
    <!-- Single Product-->
    <section class="card mb-4">
        <div class="card-body">

            <div class="row justify-content-center">

                <div class="col-lg-5">
                    {{-- main carousel --}}
                    <img height="600" src="{{ asset('images/kia-rio.jpeg') }}" />
                    {{-- slider thumbnail carousel --}}


                </div>

                <div class="col-lg-7">

                    <style>
                        .flex-container {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 20px;
                            max-width: 1000px;
                            margin: 10px auto;
                        }

                        .flex-item {
                            flex: 0 0 calc(5% - 5px);
                            /* Ajusta este valor según sea necesario */
                            background-color: #f2f2f2;
                            border: 1px solid #ddd;
                            text-align: center;
                            padding: 20px 0;
                            font-size: 20px;
                            cursor: pointer;
                            transition: background-color 0.3s;
                        }

                        .flex-item:hover {
                            background-color: #28a745;
                        }

                        .number-table {
                            margin-top: 20px;
                        }

                        .number-cell {
                            width: 60px;
                            height: 60px;
                            background-color: #f2f2f2;
                            border: 1px solid #ddd;
                            text-align: center;
                            vertical-align: middle;
                            line-height: 60px;
                            font-size: 20px;
                            transition: background-color 0.3s;
                        }




                        .grid-container {
                            display: grid;
                            grid-template-columns: repeat(20, 1fr);
                            gap: 5px;
                            max-width: 1000px;
                            margin: 20px auto;
                        }

                        .grid-item {
                            width: 100%;
                            background-color: #f2f2f2;
                            border: 1px solid #ddd;
                            text-align: center;
                            padding: 20px 0;
                            font-size: 20px;
                            cursor: pointer;
                            transition: background-color 0.3s;
                        }

                        .grid-item:hover {
                            background-color: #28a745;
                        }

                        .selected {
                            background-color: #2fdf58;
                            /* Color verde para la celda seleccionada */
                            color: white;
                        }

                        .highlight {
                            background-color: #a72828;
                            /* Un tono de verde de Bootstrap 4 */

                            cursor: not-allowed;
                            color: white;
                            /* Texto blanco para mejor contraste */
                        }
                    </style>
                    <div class="">


                        <input type="text" id="selectedNumber" readonly class="form-control mb-3"
                            placeholder="Número seleccionado" />
                        <div class="flex-container">
                            @php
                                $num_rows = 1000;
                                $items_per_page = 200;
                                $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                $total_pages = ceil($num_rows / $items_per_page);
                                $start = ($current_page - 1) * $items_per_page;
                                $end = min($start + $items_per_page, $num_rows);
                                $rifas = [1, 2, 3];

                                for ($row = $start; $row < $end; $row++) {
                                    $relleno = '0';
                                    $numero = str_pad($row, 3, $relleno, STR_PAD_LEFT);
                                    $class = in_array($numero, $rifas) ? 'highlight' : '';
                                    echo "<div class='flex-item $class'>$numero</div>";
                                }
                            @endphp
                        </div>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                @for ($i = 1; $i <= $total_pages; $i++)
                                    <li class="page-item {{ $i == $current_page ? 'active' : '' }}">
                                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            </ul>
                        </nav>

                        {{-- @include($sc_templatePath.'.includes.product_detail.card_info') --}}

                    </div> {{-- end row --}}
                @endsection
                {{-- block_main --}}

                @push('styles')
                    {{-- Your css style --}}
                @endpush

                @push('scripts')
                    {{-- lightSlider --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var main = new Splide('#main-carousel', {
                                type: 'slide',
                                rewind: true,
                                pagination: false,
                                arrows: false,
                            });

                            var thumbnails = new Splide('#thumbnail-carousel', {
                                fixedWidth: 80,
                                fixedHeight: 80,
                                gap: 6,
                                rewind: true,
                                pagination: false,
                                isNavigation: true,
                                arrows: false,
                                breakpoints: {
                                    768: {
                                        fixedWidth: 48,
                                        fixedHeight: 48,
                                    },
                                },
                            });

                            main.sync(thumbnails);
                            main.mount();
                            thumbnails.mount();
                        });
                    </script>
                    {{-- end lightSlider --}}

                    {{-- owl --}}
                    {{-- end owl --}}
                    <script type="text/javascript"></script>
                @endpush
