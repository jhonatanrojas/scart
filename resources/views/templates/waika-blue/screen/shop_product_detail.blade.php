@php
/*
$layout_page = shop_product_detail
**Variables:**
- $product: no paginate
- $productRelation: no paginate
*/
@endphp


<style>
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

  .modal .modal-body{
    /*background-image: url('https://images.pexels.com/photos/6958525/pexels-photo-6958525.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');

    background-repeat: no-repeat;
    background-size: cover;*/


    box-shadow: 0px 4px 50px 3px rgba(0, 0, 0, 0.25);
border-radius: 20px;
  }

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
    .modal .modal-dialog{
     margin-top: 5px; 

  }

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
    .modal .modal-dialog{
     margin-top: 5px; 

  }

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
@extends($sc_templatePath.'.layout')

{{-- block_main --}}
@section('block_main_content_center')
@php
    $countItem = 0
@endphp
      <!-- Single Product-->
      <section class="section section-sm section-first bg-default">
     
        <div class="container">
          
          <div class="row ">
           
            <div class="col-lg-6">
              <div class="slick-vertical slick-product">
                <!-- Slick Carousel-->
                <div class="slick-slider carousel-parent" id="carousel-parent" data-items="1" data-swipe="true" data-child="#child-carousel" data-for="#child-carousel">
                  <div class="item">
                    <div class="slick-product-figure"><img src="{{ sc_file($product->getImage()) }}" alt="" width="530" height="480"/>
                    </div>
                  </div>
                  @if ($product->images->count())
                  @php
                    $countItem = 1 + $product->images->count();
                  @endphp
                  @foreach ($product->images as $key=>$image)
                  <div class="item">
                    <div class="slick-product-figure"><img src="{{ sc_file($image->getImage()) }}" alt="" width="530" height="480"/>
                    </div>
                  </div>
                  @endforeach
                  @endif
                </div>

                @if ($countItem > 1)
                <div class="slick-slider child-carousel slick-nav-1" id="child-carousel" data-arrows="true" data-items="{{ $countItem }}" data-sm-items="{{ $countItem }}" data-md-items="{{ $countItem }}" data-lg-items="{{ $countItem }}" data-xl-items="{{ $countItem }}" data-xxl-items="{{ $countItem }}" data-md-vertical="true" data-for="#carousel-parent">
                    <div class="item">
                      <div class="slick-product-figure"><img src="{{ sc_file($product->getImage()) }}" alt="" width="600" height="480"/>
                      </div>
                    </div>
                    @foreach ($product->images as $key=>$image)
                    <div class="item">
                      <div class="slick-product-figure"><img src="{{ sc_file($image->getThumb()) }}" alt="" width="530" height="480"/>
                      </div>
                    </div>
                    @endforeach
                  </div>
                @endif

              </div>
            </div>
            <div class="col-lg-6">
            <form id="buy_block" class="product-information" action="{{ sc_route('cart.add') }}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
              <input type="hidden" name="storeId" id="product-detail-storeId" value="{{ $product->store_id }}" />
              <div class="single-product">
                <h4 class="text-transform-none font-weight-medium" id="product-detail-name">{{ $product->name }}</h4>
                
                {!! $product->displayVendor() !!}
                
                {{-- <p>
                  SKU: <span id="product-detail-model">{{ $product->sku }}</span>
                </p> --}}

                {{-- Show price --}}
                <div class="">
                  <div class="single-product-price" id="product-detail-price">
                    @php
                    $product->nro_coutas=      $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
                    $product->price_con_inicial=  $product->price-$product->monto_inicial;
               
               
                    @endphp
                    @if( $product->precio_de_cuota)
                    <div class="product-price-wrap">
                      <div class="sc-new-price">${!!  number_format($product->price_con_inicial/$product->nro_coutas,2) !!} </div>
                    </div>
              
                    @else
                    {!! $product->showPriceDetail() !!}
                    @endif
            
                    @php
                
                    $total_cuotas=0;
                    if($product->nro_coutas>0){
                    
                      $product->nro_coutas=      $product->nro_coutas == 0 ? 1 : $product->nro_coutas; 
                    $total_cuotas=  $product->price / $product->nro_coutas;  
                   

                  }
                  @endphp
                   
                  </div>
                  <div>
                    <h5>   @if( $product->monto_inicial > 0 )

                      Inicial de  ${!! number_format($product->monto_inicial,2)  !!} <br>
                       @endif</h5>
                    <small class=" text-info  " style="font-size:1rem"> {{ $product->description}}</small>
                  </div>
                </div>
                {{--// Show price --}}

                <hr class="hr-gray-100">
                
                 
                  <div class="d-flex justify-content-center">

                    @if (sc_config('customer_pagar_al_contado'))
                  <div  class="m-2">
                  
                    <button onclick="validachecke1()" id="descotado" class="btn btn-info btn-lg p-3"  type="button"  name="Des_contado"   ><small style="font-size: 12;">PAGAR AL CONTADO</small></button>
                        
                   

                   
                   
                  </div>
                  @endif
                  <div class="m-2 col-md-12">

                    <button id="finansiamiento" onclick="validachecke2() ,gen_table()"  data-toggle="modal" data-target="#myModal" type="button" class="pedido p-3  text-white " name="Financiamiento"  ><small  style="font-size: 15px;">CALCULAR SOLICITUD</small></button>

                  </div>

                  </div>
                  

               
                <div>
                  <p class="text-danger" id="msg"></p>
                </div>
                <hr class="hr-gray-100">

                {{-- Button add to cart --}}
                @if ($product->kind != SC_PRODUCT_GROUP && $product->allowSale() && !sc_config('product_cart_off'))
                <div id="group" class="group-xs group-middle" >
                    <div class="product-stepper" >
                      <input class="form-input" name="qty" type="number" data-zeros="true" value="1" min="1" max="100">
                    </div>
                    <div>
                        <button    id="buton"  class="button button-lg button-secondary button-zakaria" type="submit">{{ sc_language_render('action.add_to_cart') }}</button>
                    </div>
                </div>
                @endif
                {{--// Button add to cart --}}

                {{-- Show attribute --}}
                @if (sc_config('product_property'))
                <div id="product-detail-attr">
                    @if ($product->attributes())
                    {!! $product->renderAttributeDetails() !!}
                    @endif
                </div>
                @endif
                {{--// Show attribute --}}

                {{-- Stock info --}}
                @if (sc_config('product_stock'))
                <div>
                    {{ sc_language_render('product.stock_status') }}:
                    <span id="stock_status">
                        @if($product->stock <=0 && !sc_config('product_buy_out_of_stock'))
                            {{ sc_language_render('product.out_stock') }} 
                            @else 
                            {{ sc_language_render('product.in_stock') }} 
                            @endif 
                    </span> 
                </div>
                @endif
                {{--// Stock info --}}

                {{-- date available --}}
                @if (sc_config('product_available') && $product->date_available >= date('Y-m-d H:i:s'))
                    {{ sc_language_render('product.date_available') }}:
                    <span id="product-detail-available">
                        {{ $product->date_available }}
                    </span>
                @endif
                {{--// date available --}}

                {{-- Category info --}}
                <div>
                {{ sc_language_render('product.category') }}: 
                @foreach ($product->categories as $category)
                  <a href="{{ $category->getUrl() }}">{{ $category->getTitle() }}</a>,
                @endforeach
                </div>
                {{--// Category info --}}

                {{-- Brand info --}}
                @if (sc_config('product_brand') && !empty($product->brand->name))
                <div>
                    {{ sc_language_render('product.brand') }}:
                    <span id="product-detail-brand">
                        {!! empty($product->brand->name) ? 'None' : '<a href="'.$product->brand->getUrl().'">'.$product->brand->name.'</a>' !!}
                    </span>
                </div>
                @endif
                {{--// Brand info --}}

                {{-- Product kind --}}
                @if ($product->kind == SC_PRODUCT_GROUP)
                  <div class="products-group">
                      @php
                      $groups = $product->groups
                      @endphp
                      <b>{{ sc_language_render('product.kind_group') }}</b>:<br>
                      @foreach ($groups as $group)
                      <span class="sc-product-group">
                          <a target=_blank href="{{ $group->product->getUrl() }}">
                              {!! sc_image_render($group->product->image) !!}
                          </a>
                      </span>
                      @endforeach
                  </div>
                @endif

                @if ($product->kind == SC_PRODUCT_BUILD)
                  <div class="products-group">
                      @php
                      $builds = $product->builds
                      @endphp
                      <b>{{ sc_language_render('product.kind_bundle') }}</b>:<br>
                      <span class="sc-product-build">
                          {!! sc_image_render($product->image) !!} =
                      </span>
                      @foreach ($builds as $k => $build)
                      {!! ($k) ? '<i class="fa fa-plus" aria-hidden="true"></i>':'' !!}
                      <span class="sc-product-build">{{ $build->quantity }} x
                          <a target="_new" href="{{ $build->product->getUrl() }}">{!!
                              sc_image_render($build->product->image) !!}</a>
                      </span>
                      @endforeach
                  </div>
                @endif
              {{-- Product kind --}}

                <hr class="hr-gray-100">

                {{-- Social --}}
                <div class=" d-flex">
                 <div>
                  <span class="">Compartir</span>
                 </div>
                  <div>

                    <ul class="list-inline list-social list-inline-sm">
                      <li><a target="blank" class="icon mdi mdi-facebook" href="https://api.whatsapp.com/send?phone=584126354041"></a></li>
                      {{-- <li><a class="icon mdi mdi-twitter" href="#"></a></li> --}}
                      <li><a target="blank" class="icon mdi mdi-instagram" href="https://www.instagram.com/waikaimport/"></a></li>
                      {{-- <li><a class="icon mdi mdi-google-plus" href="#"></a></li> --}}
                    </ul>
                  </div>
                </div>
                {{--// Social --}}
                  <input type="hidden" name="Cuotas" value="{!!$product->nro_coutas!!}">
                  <input type="hidden" name="modalidad_pago" value="{!!$product->modalidad == "Mensual" ? 3: 2!!}">
              </div>
            </form>
            </div>
          </div>

          <!-- Bootstrap tabs-->
          <div class="tabs-custom tabs-horizontal tabs-line" id="tabs-1">
            <!-- Nav tabs-->
            <div class="nav-tabs-wrap">
              <ul class="nav nav-tabs nav-tabs-1">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" href="#tabs-1-1" data-toggle="tab">{{ sc_language_render('product.description') }}</a>
                </li>
              </ul>
            </div>

            {{-- Render connetnt --}}
            <div class="tab-content tab-content-1">
              <div class="tab-pane fade show active" id="tabs-1-1">
                {!! sc_html_render($product->content) !!}
              </div>
            </div>
            {{--// Render connetnt --}}

          </div>
        </div>
      </section>


      @if ($productRelation->count())
      <!-- Related Products-->
      <section class="section section-sm section-last bg-default">
        <div class="container">
          <h4 class="font-weight-sbold">{{ sc_language_render('front.products_recommend') }}</h4>
          <div class="row row-lg row-30 row-lg-50 justify-content-center">
            @foreach ($productRelation as $key => $productRel)
            <div class="col-sm-6 col-md-5 col-lg-3">
                  {{-- Render product single --}}
                  @include($sc_templatePath.'.common.product_single', ['product' => $productRel])
                  {{-- //Render product single --}}
            </div>
            @endforeach
          </div>
        </div>
      </section>
      @endif
      <div class="modal p-1  mt-5  animate__animated animate__slideInUp" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog   modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
             
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
                    <input disabled  onclick="alert('Esta opcion aun no disponible')" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="ENTREGA_INMEDIATA" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      {{sc_language_render('customer.title_ENTREGA INMEDIATA')}}
                    </label>



                  </div>

                   <div class="form-check">
                    <input checked class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="ENTREGA_PROGRAMADA">
                    <label class="form-check-label" for="exampleRadios2">
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
                         <input readonly class="form-control" type="text"  id="" value="{{$product->nro_coutas}}">
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





                        <input id="Cuotas" type="hidden" value="{{$product->nro_coutas}}" name="Cuotas" id="">
                        <input  readonly value="{{$product->price}}" class="form-control   " type="hidden" name="monto" id="monto" placeholder="monto" 
                       >

                        <input type="hidden" value="@php echo date('Y-m-d')  @endphp" name="fecha" id="fecha" placeholder="fecha">
                      </div>
                
                  </div>

                 
                </div>
              <input type="hidden" name="financiamineto" value="1" >
              
             
                    </div>
                    
                    <div class="modal-footer ">
                      <div class="text-center mb-2  p-2  w-100 " id="mensaje"></div>
                     
                      <button id="butto_modal"  type="submit" class="pedido text-white text-uppercase"> {{sc_language_render('customer.c_solicitud')}}</button>

                     

                    </div>
            </div>
                  
          </div>

        </div>
        </div>
        <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
              <input type="hidden" name="storeId" id="product-detail-storeId" value="{{ $product->store_id }}" />
              <input  name="qty" type="hidden"  value="1" min="1" max="100">
              <input  name="financiamiento" type="hidden"  value="1"  max="100">
      </form>




      <script type="text/javascript">

          const title_sin_inicia = {!! json_encode(sc_language_render('customer.title_sin_inicia')) !!};
          const title_con_inicia = {!! json_encode(sc_language_render('customer.title_con_inicia')) !!};


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
          let monto=Number(document.getElementById("monto").value);
          let n2=Number(document.getElementById("Cuotas").value);
          let inicial = iniciale;
   
         

          if(inicial>0){

              let precio_couta=  monto -(inicial* monto / 100 );
              let precio_monto_cuota = precio_couta / n2
              let tola_inicial = inicial * monto / 100
              let monto_cuotas = monto/n2;

              document.getElementById('monto_Inicial').value = tola_inicial.toFixed(2)
              document.getElementById('monto_de_la_cuota').value = precio_monto_cuota.toFixed(2)
              document.getElementById('mensaje').innerHTML= `<spa class="h5 text-primary w-100 ">${title_con_inicia}</spa>`



           
          }else{
              let monto_cuotass = monto/n2;
               document.getElementById('monto_de_la_cuota').value = monto_cuotass.toFixed(2)
                document.getElementById('monto_Inicial').value = 0.00
                document.getElementById('mensaje').innerHTML= `<spa class="h5 text-primary w-100 ">${title_sin_inicia}</spa>`


            
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
@endsection
{{-- block_main --}}

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')


    
@endpush
