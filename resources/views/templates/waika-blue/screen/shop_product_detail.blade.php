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
              @php 
              $inicial_default=  30.00;
            @endphp
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
            @endif

          
   
        <input type="hidden" id="entrega_inmediata" value="1">
        <input type="hidden" id="inicial_producto" value="{!! $product->monto_inicial == 0 ? $inicial_default :$product->monto_inicial !!}">
      @include($sc_templatePath.'.includes.product_detail.form_modal')
      

      


@endsection
{{-- block_main --}}

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
    {{-- lightSlider --}}
      <script>
     
        
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

 var title_sin_inicia = {!! json_encode(sc_language_render('customer.title_sin_inicia')) !!};
  var title_con_inicia = {!! json_encode(sc_language_render('customer.title_con_inicia')) !!};

  if(document.getElementById("Cuotas").value == 12 || document.getElementById("Cuotas").value == 10){
  document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_sin_inicia}</div>`}

  var monto_cuota_entrega = {!! json_encode($product->monto_cuota_entrega) !!};
  var product_nro_coutas = {!! json_encode($product->nro_coutas) !!};
  const valor_product_inicial =  $("#inicial_producto").val()
  let montos=Number(document.getElementById("monto").value);
  var n2=Number(document.getElementById("cuotas_inmediatas").value);

var radios_tipo_venta = document.getElementsByName('tipo_venta');
var monto_Inicial = document.getElementById('monto_Inicial');





const select_inicial = document.getElementById("inicial");
const input_financamiento =document.getElementById("financiamiento");
var product_monto_inicial = {!! json_encode($product->monto_inicial) !!};
for (var i = 0; i < radios_tipo_venta.length; i++) {
radios_tipo_venta[i].onchange = function() {
var seleccionado = document.querySelector('input[name="tipo_venta"]:checked').value;
if(seleccionado==1){
  document.getElementById('monto_Inicial').value = 0.00
  document.getElementById("m_nro_cuotas").value = product_nro_coutas
  let monto_cuotass = montos/document.getElementById("Cuotas").value;
  document.getElementById('monto_de_la_cuota').value = monto_cuotass.toFixed(2)
  if(document.getElementById("Cuotas").value == 12 || document.getElementById("Cuotas").value == 10){
  document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_sin_inicia}</div>`}
input_financamiento.value=1;

select_inicial.innerHTML = `
    <option value="si" >SI</option>
    <option value="no" selected>NO</option>
  `;


}else if (seleccionado == 2) {
  select_inicial.innerHTML = `
    <option value="si" selected>SI</option>
  `;
  
  const n2 = Number(document.getElementById("cuotas_inmediatas").value);
  const monto = Number(document.getElementById("monto").value);
  
  if (n2 > 1) {
    document.getElementById("m_nro_cuotas").value = n2;
  }
  
  const product_monto_inicial = 0;
  
  const Valor = (monto - product_monto_inicial) / n2;
  
  document.getElementById('monto_de_la_cuota').value = Valor.toFixed(2);
  document.getElementById('monto_Inicial').value = product_monto_inicial;
  
  const CuotasValue = document.getElementById("Cuotas").value;
  const mensajeDiv = document.getElementById('mensaje');
  
  if (CuotasValue == 12) {
    mensajeDiv.innerHTML = `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_con_inicia}</div>`;
  }
  
  if (n2 == 8) {
    mensajeDiv.innerHTML = `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i>Entrega inmediata posterior a la firma del convenio y pago de la inicial </div>`;
  }
  
  if (product_monto_inicial == 0 && seleccionado == 2) {
    document.getElementById("butto_modal").disabled = false;
    
    const tipoVentaInput = document.querySelector('input[name="tipo_venta"]:checked');
    const tipoVentaValue = Number(tipoVentaInput.value);
    const newN2 = tipoVentaValue == 1 ? Number(document.getElementById("Cuotas").value) : Number(document.getElementById("cuotas_inmediatas").value);
    
    const montoTotal = monto; 
    const inicialPorcentaje = 0.30;
    const numeroCuotas = newN2; 
    const total_inicial = montoTotal * inicialPorcentaje;
    const montoFinanciado = montoTotal - total_inicial;  
    const montoCuota = montoFinanciado / numeroCuotas;
   
    document.getElementById('monto_Inicial').value = total_inicial.toFixed(2);
    document.getElementById('monto_de_la_cuota').value = montoCuota.toFixed(2);
    
    if (CuotasValue == 12) {
      mensajeDiv.innerHTML = `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_con_inicia}</div>`;
    }
    
    if (newN2 == 8) {
      mensajeDiv.innerHTML = `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i>Entrega inmediata posterior a la firma del convenio y pago de la inicial </div>`;
    }
  }
  
  input_financamiento.value = 2;
}
}}

if (monto_cuota_entrega > 0) {
  const n2 = document.getElementById("Cuotas").value;
  const monto = document.getElementById("monto").value;
  const cuota = (monto - product_monto_inicial - monto_cuota_entrega) / n2;
  console.log(`La cuota mensual es de $${cuota.toFixed(2)}.`);
  document.getElementById('monto_de_la_cuota').value = cuota.toFixed(2);
}

select_inicial.addEventListener('change', function(e) {

  if(product_monto_inicial == 0 && e.target.value == 'si'){
    document.getElementById("butto_modal").disabled = false;

      var seleccionado = document.querySelector('input[name="tipo_venta"]:checked').value;
      if(seleccionado==1){
        var n2=Number(document.getElementById("Cuotas").value);
      }else{
        var n2=Number(document.getElementById("cuotas_inmediatas").value);
        
      }
      

      let monto=Number(document.getElementById("monto").value);

      if(n2>1)
      document.getElementById("m_nro_cuotas").value=n2;
       
            const montoTotal = monto; 
            const inicialPorcentaje = 0.30;
            const numeroCuotas = n2; 
            const total_inicial = montoTotal * inicialPorcentaje;
            const montoFinanciado = montoTotal - total_inicial;  
            const montoCuota = montoFinanciado / numeroCuotas;
           
          document.getElementById('monto_Inicial').value = total_inicial.toFixed(2) 
          document.getElementById('monto_de_la_cuota').value = montoCuota.toFixed(2)

          if(document.getElementById("Cuotas").value == 12 || document.getElementById("Cuotas").value == 10 ){
            document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_con_inicia}</div>`

          }

          if(document.getElementById("m_nro_cuotas").value == 8  ){
              document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i>Entrega inmediata posterior a la firma del convenio y pago de la inicial </div>`

          }

        fechaInicio = new Date(document.getElementById('fecha').value)
        fechaInicio.setDate(fechaInicio.getDate() + 1) // fecha actual
      
        if(fechaInicio == "Invalid Date"){
        var fechaInicio  = new Date();
        var fechaInicio = fechaInicio.toLocaleDateString('en-US');
        // obtener la fecha de hoy en formato `MM/DD/YYYY`
        }

  }else if(product_monto_inicial > 0 && e.target.value == 'si'){
    Valor = (monto.value - product_monto_inicial)/document.getElementById("Cuotas").value
    document.getElementById('monto_de_la_cuota').value = Valor.toFixed(2)
    document.getElementById('monto_Inicial').value = product_monto_inicial

  }else{
    let monto_cuotass = monto.value/document.getElementById("Cuotas").value;
            document.getElementById('monto_de_la_cuota').value = monto_cuotass.toFixed(2)
              document.getElementById('monto_Inicial').value = 0.00
              if(document.getElementById("Cuotas").value == 12 || document.getElementById("Cuotas").value == 10){
                document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_sin_inicia}</div>`

              }
  }
  
 
   if(e.target.value == 'no'){
          let monto_cuotass = monto.value/document.getElementById("Cuotas").value;
            document.getElementById('monto_de_la_cuota').value = monto_cuotass.toFixed(2)
              document.getElementById('monto_Inicial').value = 0.00
              if(document.getElementById("Cuotas").value == 12 || document.getElementById("Cuotas").value == 10){
                document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_sin_inicia}</div>`

              }
        }
 

});






if(n2 > 0 &&  product_nro_coutas == 1){
  const input = document.querySelector('input[name="tipo_venta"][value="2"]');
  input.checked = true;
 
      select_inicial.innerHTML = `
    <option value="si" selected>SI</option>`;

    var n2=Number(document.getElementById("cuotas_inmediatas").value);
    let monto=Number(document.getElementById("monto").value);
      if(n2>1)
      document.getElementById("m_nro_cuotas").value=n2;
  
      const montoTotal = monto;
      const inicial = product_monto_inicial;
      const numeroCuotas = n2;
      const montoRestante = montoTotal - inicial;
      const valorCuota = montoRestante / numeroCuotas;

      console.log("El valor de cada cuota a pagar es: $" + valorCuota.toFixed(2));

      document.getElementById('monto_de_la_cuota').value = valorCuota.toFixed(2)
      document.getElementById('monto_Inicial').value = product_monto_inicial
      document.getElementById('entrega_inmediata').value = 1

      

          if(document.getElementById("Cuotas").value == 12){
            document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i> ${title_con_inicia}</div>`

          }

          if(document.getElementById("m_nro_cuotas").value == 8  ){
              document.getElementById('mensaje').innerHTML= `<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-info"></i>Entrega inmediata posterior a la firma del convenio y pago de la inicial </div>`

          }


    }

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