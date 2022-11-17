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




  .modal .modal-dialog{
    width: 100%;
    margin-top: 20px;
    padding: 5px;

  }

  table{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  
}
.table-1{
  width: 707px;
  margin: auto;
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
  padding: 30px 40px;
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
                    {!! $product->showPriceDetail() !!}
                    @php
                
                    $total_cuotas=0;
                    if($product->nro_coutas>0){
                    $total_cuotas=  $product->price / $product->nro_coutas;  
                   

                  }
                  @endphp
                   
                  </div>
                  <div>
                    <small class=" text-info ">adquiera el producto y pagalo en {!! $product->nro_coutas !!} cuotas  {!! $product->modalidad !!} de {!!  round($total_cuotas)!!}$ </small>
                  </div>
                </div>
                {{--// Show price --}}

                <hr class="hr-gray-100">
                <div class="row  text-center align-items-center">
                 
                  

                  <div  class="form-check  radioContenedor2 col-12 col-md-6 

                  ">
                  
                    <input  data-toggle="modal" data-target="#myModal" type="radio" class="btn-check" name="Financiamiento" id="danger_outlined" autocomplete="off">
                    <label id="finansiamiento" class="btn btn-primary" for="danger_outlined"><small style="font-size: 11px">Adquiéralo Financiado</small></label>
                   
                   
                  </div>
                  <div class="form-check  radioContenedor2 col-12 col-md-6">
                     <input checked  value="active" type="checkbox" class="btn-check" name="Des_contado" id="flexRadioDefault2" autocomplete="off" >
                    <label id="descotado" class="  btn btn-primary" for="flexRadioDefault2"><small style="font-size: 12px" >De contado</small></label>
                     
       
                   
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
      <div class="modal  mt-5" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog   modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
             
            </div>
            <div class="modal-body p-0">
              <form action="{{ sc_route('cart.add') }}" method="POST">
                <div id="w-100">
                   {{ csrf_field() }}
                  <div class="header">
                    <h5 class="text-center p-0">Calcular financiamiento</h5>
                  </div>
                  <div name="frmPrestamo" id="frmPrestamo">
                
                    <div class="p-0 mt-0 m-0">
                      <label for="monto">Monto: </label>
                      <input  readonly value="{{$product->price}}" class="form-control   " type="text" name="monto" id="monto" placeholder="monto" 
                       >
                    </div>
                    <div class="mt-2 mb-2">
                      <label  for="periodo">forma de pago:
                        
                      </label>
                      <select id="modalidad" class="form-control w-100 modalidad_pago select2"
                      name="modalidad_pago">
                      <?php
                          if(isset($modalida_pago)){
                              foreach ($modalida_pago as $key => $pagos) {
                                  if(isset($product->id_modalidad_pago) and $product->id_modalidad_pago == $pagos->id){
                                      echo "<option selected value='".$pagos->id."'  data-latitud=".$pagos->latitud."  data-longitud=".$pagos->longitud." >".$pagos->name."</option>";     
                                  }else{
                                      echo "<option value='".$pagos->id."' data-latitud=".$pagos->latitud."  data-longitud=".$pagos->longitud." >".$pagos->name."</option>";
                                  }
                              }
                          }
                      ?>   
             
                      
                  </select>
                    </div>
                    <div class="mt-2 mb-2">
                      <label for="plazo">Cuotas:
                      </label>
                            <select class="form-control w-100 select2" name="Cuotas" id="Cuotas">
                              @foreach ($cuotas as $cuotas )
                              @if ($cuotas)
                              <option value="{{$cuotas->numero_cuotas}}">{{$cuotas->numero_cuotas}}</option>
                              @endif
                              @endforeach
                            </select>
                     
                    </div>

                    <div class="control">
                      <label for="fecha">Fecha del primer pago:   </label>
                        <input type="date" value="@php echo date('Y-m-d')  @endphp" name="fecha" id="fecha" placeholder="fecha">
                      
                    
                    </div>

                   
                    <div class="mt-0">
                      <label for="inicial">Inicial  </label>
                     
                         <select class="form-control w-100 select2"  name="inicial" id="inicial">
                          <option value="0">sin inicial(0%)</option>
                          <option value="30">con inicial(30%)</option>
                         
                         </select>
                    </div>

                    <div class="p-0 mt-0 mt-2">
                      <label for="monto">Inicial $:</label>
                      <input  readonly value="0" class="form-control   " type="text"  id="monto_Inicial" placeholder="" 
                       >
                    </div>
                
                    <button type="button" id="simular" onclick="gen_table()"> CALCULAR</button>
                  </div>

                  <div style="overflow-x:auto;" class="table-1">
                    <table class=" table"  >
                    
                      <tbody id="tab">
                        <thead>
                          <tr>
                            <td>NRO</td>
                            <td id="cuotass">CUOTAS</td>
                            <td>DEUDA</td>
                            <td>FECHA</td>
                        </tr>
                          
                      </thead>
                      </tbody>
                      {{-- <tfoot>
                          <tr>
                              <td>TOTAL</td>
                              <td id="t1"></td>
                              <td id="t3"></td>
                              <td id="t4"></td>
                              
                          </tr>
                      </tfoot> --}}
                  </table>
                 
                  </div>
                </div>
             
              
             
                    </div>
                    
                    <div class="modal-footer mb-4">
                      <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button id="butto_modal" disabled="true" type="submit" class="btn btn-primary">continuar</button>
                    </div>
            </div>
            
          </div><!-- /.modal-content -->
        </div>
        <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
              <input type="hidden" name="storeId" id="product-detail-storeId" value="{{ $product->store_id }}" />
              <input  name="qty" type="hidden"  value="1" min="1" max="100">
              <input  name="financiamiento" type="hidden"  value="1"  max="100">
      </form>

  

<h4 id="error"></h4>




      <script type="text/javascript">
 
        // simulador de creditos 
        function gen_table(){
          document.getElementById("tab").innerHTML="";
          let monto_Inicial = document.getElementById("monto_Inicial");
          document.getElementById("butto_modal").disabled = false;
          let monto=Number(document.getElementById("monto").value);
          let n2=Number(document.getElementById("Cuotas").value);
          var n3=Number(document.getElementById("inicial").value);
          let inicial = parseInt(n3);
          const plazoMensual = document.getElementById('modalidad')
          var selected = plazoMensual.options[plazoMensual.selectedIndex].value;
          var selectd2 = plazoMensual.options[plazoMensual.selectedIndex].text;

          if(inicial>0){
            totalinicial=(inicial*monto)/100;
            monto = monto -totalinicial;

            monto_Inicial.value = totalinicial.toFixed(2)
          }
       
      
          fechaInicio = new Date(document.getElementById('fecha').value)
          fechaInicio.setDate(fechaInicio.getDate() + 1) // fecha actual

          if(fechaInicio == "Invalid Date"){
            var fechaInicio  = new Date();
            var fechaInicio = fechaInicio.toLocaleDateString('en-US');
            // obtener la fecha de hoy en formato `MM/DD/YYYY`
          }
         

          let periodo = selected;
          let totalPagos ,  plazo ,fechaPago;
          var primerFechaPago = true

          if(monto>0){ 
            document.getElementById("cuotass").innerHTML= `CUOTAS/${selectd2}`;
            
            if ( true ) {
              plazo = n2
            } else {
              alert('No seleccionaste ningún tipo de plazo')
            }
            switch ( periodo ) {
              case 'Semanal':
                let fechaFin = new Date(fechaInicio)
                fechaFin.setMonth(fechaFin.getMonth() + parseInt(plazo))
                let tiempo = fechaFin.getTime() - fechaInicio.getTime()
                let dias = Math.floor(tiempo / (1000 * 60 * 60 * 24))
                totalPagos = Math.ceil(dias / 7)
                break
              case '2':
                totalPagos = plazo * 2
                break
              case '3':
                totalPagos = plazo
                
                break
              default:
                alert('No seleccionaste ningún periodo de pagos')
                break
            }
            var cuotaTotal = monto / n2
            let  montoTotal = monto
            let Inicial = inicial * monto / 100
            Inicial == Infinity ? Inicial = 0 : Inicial

             
            let texto = 0;
            for(i=1;i<=n2;i++){  
              texto = (i + 1)

              if ( primerFechaPago === true ) {
                  fechaPago = new Date(fechaInicio)
                  primerFechaPago = false
                } else {
                  if ( periodo === 'semanal' ) {
                    fechaPago.setDate(fechaPago.getDate() + 7)
                  } else if ( periodo === '2' ) {
                    fechaPago.setDate(fechaPago.getDate() + 15)
                  } else if ( periodo === '3' ) {
                    fechaPago.setMonth(fechaPago.getMonth() + 1)
                  }
                }
                texto = fechaPago.toLocaleDateString()
                monto -= cuotaTotal
                  ca=monto;
                  d1=ca.toFixed(2) ;
                  i2= Inicial.toFixed(2);
                  d2=cuotaTotal.toFixed(2);
                  r=ca;
                  deudas = ((n2 + i2 - ca ) ) ;
                  d3=r.toFixed(2);
                  deuda=deudas.toFixed(1);
                  document.getElementById("tab").innerHTML=document.getElementById("tab").innerHTML+
                          `
                          
                          
                          
                          <tr>
                              <td>${i}</td>
                              <td>${d2}$</td>
                              <td>${d3}$</td>
                              <td>${texto}</td>
                          </tr>`;
              }
              n1= monto/n2;
              t_i=i2*n2;
              d4=t_i.toFixed(2);
              t_p=r*n2;
              d5=t_p.toFixed(2);
              document.getElementById("t1").innerHTML=i3;
              document.getElementById("t3").innerHTML= "$"+montoTotal ;        
              document.getElementById("t4").innerHTML= texto ;       
                
              
              

          }else{
              alert("Falta ingresar un Número");
          }

        

      }

          var msg = document.getElementById('msg');
          const  Buyblock = document.getElementById("buy_block");
          const ye = document.getElementById("flexRadioDefault2");
          const no = document.getElementById("danger_outlined");
          
          var stylies = document.getElementById("descotado")
          stylies.style.backgroundColor= "#007bff";
          stylies.style.color = "#fff" ;
          ye.addEventListener("click" ,validachecke1);
          no.addEventListener("click" ,validachecke2);
          function validachecke1(){
            if(ye.checked) { 
              let msg = document.getElementById('msg').style.display = "none";
              const group = document.getElementById("group").style.display = "block"
              var stylies = document.getElementById("descotado")
              stylies.style.backgroundColor= "#4169e0e6";
              stylies.style.color = "#fff" ;
              
          
              let finansiamiento = document.getElementById("finansiamiento");
              finansiamiento.style.backgroundColor= "";
              finansiamiento.style.color = "#fff";
          
          }
          };
          function validachecke2(){
            if(no.checked) { 
              let msg = document.getElementById('msg').style.display = "none";
              const group = document.getElementById("group").style.display = "none";
              let finansiamiento = document.getElementById("finansiamiento");
              finansiamiento.style.color = "#fff";
              finansiamiento.style.backgroundColor= "#4169e0e6";
              var stylies = document.getElementById("descotado")
              stylies.style.backgroundColor= "#014085";
              stylies.style.color = "white" ;
            
          
          }
          };



      Buyblock.addEventListener("submit" ,function(e){
        e.preventDefault()
        const no = document.getElementById("danger_outlined")
        const ye = document.getElementById("flexRadioDefault2")
        console.log(ye.checked)
        if(ye.checked) {
          Buyblock.submit()
        }
          else msg.innerText = 'Deve seleccionar una opcion para validar el pedido';

          
      });


      </script>
@endsection
{{-- block_main --}}

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')


    
@endpush
