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
  
  
    .fecha h5{
      font-size: 2em;
    }
  
    .pedido{
  
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
  
        width: 100%;
        height: 51px;
        background-color: rgb(19.922, 95.751, 139.45);
        border-radius: 10px;
  
        border:none;
  
        /* Inside auto layout */
        flex: none;
        order: 2;
        align-self: stretch;
        flex-grow: 0;
        transition: 0.20s;
    }
  
    .pedido:hover{
  
      background:#208bff;
  
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
  
      table{
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
      
    }
  
    .financiando{
      flex-direction: row-reverse;
      display: flex;
      
    }
      @media screen and (max-width: 375px) {
        /* .modal .modal-dialog{
          margin-top: 5px; 
        } */
  
        .table-1{
          width: 80%;
        
        }
  
          table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 90%;
        }
  
        .financiando{
          flex-direction: column;
          text-align: center;
        }
      }
      @media screen and (max-width: 360px) {
        /* .modal .modal-dialog{
         margin-top: 5px; 
  
        } */
  
          .table-1{
            width: 100%;
        
        }
  
        table {
          border-collapse: collapse;
          border-spacing: 0;
          width: 100%;
        }
  
        .financiando{
          flex-direction: column;
          text-align: center;
        }
      }
        @media screen and (min-width: 314px) {
              .table-1{
                width:90%;
            
            }  
        }
        .radioContenedor2 #descotado:hover{
          color : white;
        }

      #contenedor, #contenedorTabla {
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
    
      .header, thead {
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
    
      #frmPrestamo .control, #amortizaciones .control, .radios {
        margin-bottom: 10px;
        padding-bottom: 20px;
        position: relative;
      }
    
      #frmPrestamo .control label {
        margin-bottom: 5px;
      }
    
      #frmPrestamo .control input, #frmPrestamo .control select {
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
    
      table thead, td {
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
    
    
      .radioContenedor input:checked + .circle {
        background-color: royalblue;
      }
    
      .radioContenedor input:checked + .circle:after {
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



@extends($sc_templatePath.'.layout')
{{-- block_main --}}

@section('block_main_content_center')
  @php
      $countItem = 0
  @endphp
      <!-- Single Product-->
      <section class="card mb-4">
        <div class="card-body">
            
            <div class="row justify-content-between">
             
              <div class="col-lg-7">
                  {{-- main carousel --}}
                  <section id="main-carousel" class="splide pb-2" aria-label="Beautiful Images">
                      <div class="splide__track">
                        <ul class="splide__list">
                          <li class="splide__slide">
                            <img src="{{ sc_file($product->getImage()) }}" />
                          </li>
                          @foreach ($product->images as $key=>$image)
                            <li class="splide__slide">
                              <img src="{{ sc_file($image->getImage()) }}" />
                            </li>
                          @endforeach
                        </ul>
                      </div>
                  </section>
                  {{-- slider thumbnail carousel --}}
                  <section id="thumbnail-carousel" class="splide mb-4">
                    <div class="splide__track">
                      <ul class="splide__list">
                        <li class="splide__slide">
                          <img src="{{ sc_file($product->getImage()) }}" />
                        </li>
                        @foreach ($product->images as $key=>$image)
                          <li class="splide__slide">
                            <img src="{{ sc_file($image->getImage()) }}" />
                          </li>
                        @endforeach
                      </ul>
                    </div>
                </section>

              </div>
              
              <div class="col-lg-4">
                @include($sc_templatePath.'.includes.product_detail.card_info')
              </div>
            </div> {{--end row --}}
          
            <div class="row">
              <div class="col-12 col-lg-7 py-2">
              
                <h3>{{ sc_language_render('product.description') }}</h3>
    
                {{-- Render connetnt --}}
                <div class="description-product">
                  {!! sc_html_render($product->content) !!}
                </div>
                {{--// Render connetnt --}}
              </div>
            </div>

          @if ($productRelation->count())
          <!-- Related Products-->
            <div class="row">
              <div class="col-12">
                <h3>{{ sc_language_render('front.products_recommend') }}</h3>
              </div>
              <div class="col-12 col-lg-7">
                <div class="row row-cols-1 row-cols-lg-3">
                  @foreach ($productRelation as $key => $productRel)
                  <div class="col mb-3">
                        {{-- Render product single --}}
                        @include($sc_templatePath.'.common.product_single', ['product' => $productRel])
                        {{-- //Render product single --}}
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="modal-body p-4">
              <form action="{{ sc_route('cart.add') }}" method="POST">
                <div id="w-100">
                   {{ csrf_field() }}
                  <div class=" d-sm-flex justify-content-around align-items-center">

                    <img class="brand-logo-dark" src="{{ sc_file(sc_store('logo', ($storeId ?? null))) }}" alt="logo" width="100" height="30"/>
                    <h4 class="text-center text-dark text-capitalize animate__animated animate__flipInX animate__delay-1s p-0 text-uppercase">{{ sc_language_render('customer.title_caculadora') }}</h4>

                    <div>
                        <div class="form-check">
                    <input    class="form-check-input" type="radio" name="tipo_venta" id="tipo_venta" value="2" >
                    <label class="form-check-label" for="tipo_venta">
                      {{sc_language_render('customer.title_ENTREGA INMEDIATA')}}
                    </label>



                  </div>

                   <div class="form-check">
                    <input checked class="form-check-input" type="radio" name="tipo_venta" id="tipo_venta2" value="1">
                    <label class="form-check-label" for="tipo_venta">
                      {{sc_language_render('customer.title_ENTREGA PROGRAMADA')}}
                    </label>
                  </div>
                    </div>

                  </div>
                  <div name="frmPrestamo" id="frmPrestamo">
                
                    <div class="p-0 mt-0 m-0">
       
                    </div>

                    <div class="row">

                        <div class="mt-0 col-md-6">
                      <label class="text-dark text-uppercase" for="inicial">CON Inicial  </label>
                         <select required class="form-control w-100 "  name="inicial" id="inicial">
                           <option value="">Seleccione una opcion</option>
                          <option value="30">SI</option>
                          <option value="0">NO</option>
                         
                         </select>
                      </div>



                      <div class=" col-md-6">
                      <label class="text-dark text-uppercase"  for="monto">Monto de la Inicial$:</label>
                      <input readonly id="monto_Inicial"  value="" class="form-control   " type="text"  id="" placeholder="" 
                       >
                    </div>



                       <div class="mt-0 col-md-6">
                      <label class="text-dark text-uppercase" for="inicial">Cuotas</label>
                         <input readonly class="form-control" type="text"  id="m_nro_cuotas" value="{{$product->nro_coutas}}">
                      </div>

 

                  

                     <div class="mt-0 col-md-6">

                      <label class="text-dark text-uppercase" for="monto_de_la_cuota">
                      Monto de la Cuota$
                      </label>
                         
                         <input
                         id="monto_de_la_cuota" 
                         readonly class="form-control" 
                         type="text"
                         value="{!!number_format($product->price /$product->nro_coutas ,'2') !!}"
                         >
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                          <label class="text-dark text-uppercase"  for="periodo">frecuancia de pago 
                            
                          </label>

                            @foreach($modalida_pago as $key => $pagos)

                             @if($product->id_modalidad_pagos == $pagos->id)
                             
                              @if($product->id_modalidad_pagos == $pagos->id )
                               <input data-valor={{$pagos->id}}  id="modalidad" readonly la value="{{$pagos->name ?? 'si modalidad de pago'}}" class="form-control  modalidad_pago" type="text" name="modalidad_pago"   >

                              @endif
                              
                            @endif
                            @endforeach
 
                        </div>





                        <input id="Cuotas" type="hidden" value="{{$product->nro_coutas}}" name="Cuotas" >
                        <input id="cuotas_inmediatas" type="hidden" value="{{$product->cuotas_inmediatas}}" name="cuotas_inmediatas" >

                        
                        <input  readonly value="{{$product->price}}" class="form-control   " type="hidden" name="monto" id="monto" placeholder="monto" 
                       >

                        <input type="hidden" value="@php echo date('Y-m-d')  @endphp" name="fecha" id="fecha" placeholder="fecha">
                      </div>
                
                  </div>


      
      @include($sc_templatePath.'.includes.product_detail.form_modal')
      



                     

                    </div>
            </div>
                  
          </div>

        </div>
        </div>
        <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
              <input type="hidden" name="storeId" id="product-detail-storeId" value="{{ $product->store_id }}" />
              <input  name="qty" type="hidden"  value="1" min="1" max="100">
              <input  name="financiamiento" type="hidden"  value="1" id="financiamiento" >
      </form>




@endsection
{{-- block_main --}}

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
    {{-- lightSlider --}}
      <script>
        // $(document).ready(function() {
        //   $('#imageGallery').lightSlider({
        //       gallery:true,
        //       item:1,
        //       adaptiveHeight:true,
        //       loop:true,
        //       thumbItem:2,
        //       thumbMargin: 6,
        //       slideMargin:0,
        //       enableDrag: true,
        //       currentPagerPosition:'left',
        //       onSliderLoad: function(el) {
        //           el.lightGallery({
        //               selector: '#imageGallery .lslide'
        //           });
        //       }   
        //   });  
        // });
        
        document.addEventListener( 'DOMContentLoaded', function () {
          var main = new Splide( '#main-carousel', {
            type      : 'slide',
            rewind    : true,
            pagination: false,
            arrows    : false,
          } );

          var thumbnails = new Splide( '#thumbnail-carousel', {
            fixedWidth  : 80,
            fixedHeight : 80,
            gap         : 6,
            rewind      : true,
            pagination  : false,
            isNavigation: true,
            arrows    : false,
            breakpoints : {
              768: {
                fixedWidth : 48,
                fixedHeight: 48,
              },
            },
          } );

          main.sync( thumbnails );
          main.mount();
          thumbnails.mount();
        } );
        
      </script>
    {{-- end lightSlider --}}

    {{-- owl --}}
    {{-- end owl --}}
  <script type="text/javascript">

    const title_sin_inicia = {!! json_encode(sc_language_render('customer.title_sin_inicia')) !!};
    const title_con_inicia = {!! json_encode(sc_language_render('customer.title_con_inicia')) !!};



    var radios_tipo_venta = document.getElementsByName('tipo_venta');
    const input_financamiento =document.getElementById("financiamiento");
    var select_inicial = document.getElementById("inicial");
    // Agregar un evento onchange a cada botón de radio
    for (var i = 0; i < radios_tipo_venta.length; i++) {
    radios_tipo_venta[i].onchange = function() {
    // Obtener el valor del botón de radio seleccionado


    var seleccionado = document.querySelector('input[name="tipo_venta"]:checked').value;

    if(seleccionado==1){
      input_financamiento.value=1;
      select_inicial.querySelector('option[value="30"]').removeAttribute("selected");
      select_inicial.removeAttribute("readonly");
      document.getElementById('monto_Inicial').value =0;

    
            document.getElementById('monto_Inicial').value = 0.00
            gen_table(0)


    }else{


        var option = select_inicial.querySelector('option[value="30"]');
        select_inicial.querySelector('option[value="0"]').removeAttribute("selected");
    if (option) {
    option.setAttribute("selected", "selected");
    select_inicial.setAttribute("readonly", "readonly");
    gen_table(30)

    }
    input_financamiento.value=2;
    }
    // Hacer algo con el valor seleccionado
    console.log('El botón de radio seleccionado es: ' + seleccionado);
    }
    }

      let  inicial = document.getElementById("inicial")
      inicial.addEventListener('click' , function(e){
      var iniciale = e.target.value

      if(iniciale == '0' || iniciale == '30'){
          gen_table(iniciale)
      }else if(!iniciale == '0' || !iniciale == '30'){
          alert('el campo inicial es obligatorio')
      }

      
      
    })

    function gen_table(iniciale){
      document.getElementById("butto_modal").disabled = false;
      var seleccionado = document.querySelector('input[name="tipo_venta"]:checked').value;
      if(seleccionado==1)
      var n2=Number(document.getElementById("Cuotas").value);
      else
      var n2=Number(document.getElementById("cuotas_inmediatas").value);

      let monto=Number(document.getElementById("monto").value);

      let inicial = iniciale;
      if(n2>1)
      document.getElementById("m_nro_cuotas").value=n2;
      

    

      if(inicial>0){

          let precio_couta=  monto -(inicial* monto / 100 );
          
          let precio_monto_cuota = precio_couta / n2
          let tola_inicial = inicial * monto / 100
          let monto_cuotas = monto/n2;

          document.getElementById('monto_Inicial').value = tola_inicial.toFixed(2)
          document.getElementById('monto_de_la_cuota').value = precio_monto_cuota.toFixed(2)
          document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_con_inicia}</div>`



      
      }else{
          let monto_cuotass = monto/n2;
          document.getElementById('monto_de_la_cuota').value = monto_cuotass.toFixed(2)
            document.getElementById('monto_Inicial').value = 0.00
            document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_sin_inicia}</div>`


        
      }


        fechaInicio = new Date(document.getElementById('fecha').value)
        fechaInicio.setDate(fechaInicio.getDate() + 1) // fecha actual
      
        if(fechaInicio == "Invalid Date"){
        var fechaInicio  = new Date();
        var fechaInicio = fechaInicio.toLocaleDateString('en-US');
        // obtener la fecha de hoy en formato `MM/DD/YYYY`
        }


    }

      var msg = document.getElementById('msg');
      const  Buyblock = document.getElementById("buy_block");
      function validachecke1(){
        
          let msg = document.getElementById('msg').style.display = "none";
          const group = document.getElementById("group").style.display = "block"
          
          var stylies = document.getElementById("descotado")
          
          stylies.classList.replace("btn-primary", "btn-success")

          var finansiamiento = document.getElementById("finansiamiento");

          finansiamiento.classList.replace("btn-success", "btn-primary")
          
      
      
      };
            
        document.getElementById('msg').style.display = "none";
        document.getElementById("group").style.display = "none";
      function validachecke2(){
          let msg = document.getElementById('msg').style.display = "none";
          const group = document.getElementById("group").style.display = "none";
          let finansiamiento = document.getElementById("finansiamiento");
          finansiamiento.classList.replace("btn-primary", "btn-success")

          var stylies = document.getElementById("descotado")
          
          stylies.classList.replace("btn-success", "btn-primary")
        
        

      };



    Buyblock.addEventListener("submit" ,function(e){
    e.preventDefault()
    if(true) {Buyblock.submit()} });





</script>
    
@endpush