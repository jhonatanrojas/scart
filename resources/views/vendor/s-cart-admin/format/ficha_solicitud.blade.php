<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    
    <head>
        <title>Solicitud</title>
    </head>
<style>

    
    body {
        color: #2e323c;
        background: #f5f6fa;
        position: relative;
        height: 100%;
         margin:0;
        padding:0;
    }


@media print {
   @page {
     margin-left: 0.8in;
     margin-right: 0.8in;
     margin-top: 0;
     margin-bottom: 0;
    
   }
}

@media print {
      body {
        margin-bottom: 20px;
        margin:0;
        padding:0;
       
      }
    }

    body table{
        margin-top: 0px;
        margin-bottom: 0px;
       
    }
 
.texto {
	text-align: justify;
  	text-justify: inter-word;
}

    .invoice-container {
        padding: 1em;
    }

    .invoice-container .invoice-header .invoice-logo {
        margin: 0.2rem 0 0 0;
        display: inline-block;
        font-size: 1.6rem;
        font-weight: 700;
        color: #010205;
          margin:0;
            padding:0;
    }

    .invoice-container .invoice-header .invoice-logo img {
        max-width: 130px;
    }

    address, .text-50 {
  text-transform: uppercase;
  font-weight:800;
  margin:0;
  padding:0;
}


    

    .invoice-container .invoice-header address {
        font-size: 1rem;
        color: #010508;
        margin: 0;
        padding:0;
    }

    .invoice-container .invoice-details {
        margin: 0;
        margin:0;
        line-height: 180%;
        background: #f5f6fa;
    }

    .invoice-container .invoice-details .invoice-num {
        text-align: right;
        font-size: 1rem;
    }

    .invoice-container .invoice-body {
        padding: 1rem 0 0 0;
    }

    .invoice-container .invoice-footer {
        text-align: center;
        font-size: 0.7rem;
        margin: 5px 0 0 0;
    }

    .invoice-status {
        text-align: center;
        padding: 1rem;
        background: #ffffff;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        margin-bottom: 1rem;
    }

    .invoice-status h2.status {
        margin: 0 0 0.8rem 0;
    }

    .invoice-status h5.status-title {
        margin: 0 0 0.8rem 0;
        color: #010307;
    }

    .invoice-status p.status-type {
        margin: 0.5rem 0 0 0;
        padding: 0;
        line-height: 150%;
    }

    .invoice-status i {
        font-size: 1.5rem;
        margin: 0 0 1rem 0;
        display: inline-block;
        padding: 1rem;
        background: #f5f6fa;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
    }

    .invoice-status .badge {
        text-transform: uppercase;
    }


    @media (max-width: 767px) {
        .invoice-container {
            padding: 1rem;
        }
    }


    .custom-table {
        border: 1px solid #000000;
    }

    .custom-table thead {
        background: #007ae1;
    }

    .custom-table thead th {
        border: 0;
        color: #000000;
    }

    .custom-table>tbody tr:hover {
        background: #fafafa;
    }

    .custom-table>tbody tr:nth-of-type(even) {
        background-color: #ffffff;
    }

    .custom-table>tbody td {
        border: 1px solid #202020;
        font-size: 18px;
        padding-top:5px;
        margin:0;
    }


    .card {
        background: #ffffff;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }

    .text-success {
        color: #00bb42 !important;
    }

    .text-muted {
        color: #01040a !important;
    }

    .custom-actions-btns {
        margin: auto;
        display: flex;
        justify-content: flex-end;
    }

    .custom-actions-btns .btn {
        
        
    }

    table td{
        color: #01060a;
        font-weight:800;
         margin:0;
        padding:0;

    }

    #address2 {
        font-size: 0.8rem;
        color: #01060a;
    }
    li{
        font-size: 15px;
    }
    table thead tr th{
        font-size: 15px;
    }
    table tbody tr th{
        font-size: 15px;
        margin:0;
        padding:0;
    }

    @media print {
  div.nueva-pagina {
    page-break-before: always;
  }
}

   
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="container contenedor-html">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="custom-actions-btns m">
                                        <div class="page-header text-blue-d2 mr-auto">
                                            <img class="mt-4" src="{{ sc_file(sc_store('logo')) }}" style="max-height:80px;">
                                            <div class="page-tools">
                                                <div class="action-buttons">
                                                   <!-- <a class=" btn btn-primary mx-1px text-95 dont-print"
                                                        onclick="order_print_pdf()" data-title="Print">
                                                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                                                        PDF
                                                    </a>-->
                                                    <a class=" btn btn-info mx-1px text-95 dont-print"
                                                    onclick="order_print('Solicitud#{{$order->id}}')" data-title="Print">
                                                    <i class="mr-1 fas fa-print text-primary-m1 text-120 w-2"></i>
                                                    IMPRIMIR
                                                </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 m-0 p-0">
                                    <a href="index.html" class="invoice-logo">
                                        Waika Import
                                    </a>
                                </div>
                                <div  class="col-lg-6 col-md-6 col-sm-6">
                                    <address style="font-weight: 800; font-size: 15px;" class="text-right  " id="address2">
                                        {{ sc_store('address') }}
                                        
                                                <span> Fecha:{{ sc_datetime_to_date($created_at, 'd-m-y') }}</span>
                                                <br>

                                                <span>Solicitud #{{ $order->id }}</span>
                                    </address>
                                   
                                </div>

                               <div class="col-12">
                                <h2 style="font-weight: 800; font-size: 20px;" class="p-0 m-0  "> <i class="fas fa-envelope">Cliente: {{ $name }}  Cedula: {{ $cedula }}</h2>
                               </div>

                               
                            </div>
                            <!-- Row end -->
                            <!-- Row start -->
                            <div  class="row gutters">
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">

                                       
                                        <address class=" text-uppercase">
                                            <ul  class="address">
                                               
                                              <li><i class="fas fa-map-marker-alt text-dark"></i>ubicacion:{{ strtoupper($datos_cliente->estado) }} {{ strtoupper($datos_cliente->municipio) }}, {{ strtoupper($datos_cliente->parroquia) }}. {{ strtoupper($datos_cliente->address1) }}.  Codigo Postal:{{$datos_cliente->postcode}}.</li>
                                              <li><i class="fas fa-phone"></i> Telefono:{{ $phone }} /{{$phone2 }}</li>
                                              
                                              <li><i class="fas fa-envelope"></i> Correo:{{ strtoupper($email) }}</li>
                                              <li><i class="fas fa-envelope"></i> nos conocio:{{ strtoupper($conocio) }}</li>

                                               <li><i class="fas fa-envelope"></i> Vendedor Asignado:{{ strtoupper($vendedor) }}</li>

                                               @if ($comment)

                                               <li><i class="fas fa-envelope"></i>{!!nl2br( $comment)?? '' !!}</li>
                                                   
                                               @endif
                                             

                                              
                                            </ul>
                                          </address>
                                          
                                    </div>
                                </div>
                                
                               
                            </div>
                            
                            <!-- Row end -->
                        </div>
                        <div class="invoice-body">
                            <!-- Row start -->
                            <div class="row gutters p-0 m-0">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="">
                                        <table  class="table custom-table m-0 p-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Producto</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Cant</th>
                                                    <th>Nro cuotas</th>
                                                    <th>Inicial </th>
                                                    <th>Cuota </th>
                                                    <th>Cuota de entrega $ </th>
                                                    <th>Total</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                               @php $monto_total=0;
                                               $monto_cuota_total=0;
                                               $inicial = 0;

                                              
                                               @endphp
                                               
                                                @foreach ($details as $detail)
                                                    <tr>
                                                        @php

                                                       

                                                     
                                                                       
                                                    
                                                                
                                                $AlContado = "Quincenal" ;
                                                if($detail['id_modalidad_pago'] == 3){
                                                $AlContado = "Mensual";
                                                }
                                                if ($detail['nro_coutas'] > 0) {
                                                            $precio = $detail['price'];
                                                            $monto_cuota = number_format(($detail['total_price'] -$detail['monto_cuota_entrega']) / $detail['nro_coutas'],2);   }

                                                            if ($detail['nro_coutas'] == 1 && $detail['monto_inicial'] > 0) {
                                                            $precio = $detail['price'];
                                                            $monto_cuota = number_format(($detail['total_price'] - $detail['monto_inicial']) / 6,2);   

                                                            $detail['nro_coutas'] = 6;
                                                        
                                                        
                                                        }

                                                            if ($detail['abono_inicial'] > 0 && $detail['nro_coutas'] > 0) {
                                                                $inicial = ($detail['abono_inicial'] * $detail['total_price']) / 100;
                                                                $total_price = ($detail['total_price'] - $inicial) -$detail['monto_cuota_entrega'];
                                                                $monto_cuota = number_format($total_price / $detail['nro_coutas'],2);

                                                                 
                                                            }

                                                           

                                                              if ($detail['abono_inicial'] > 0 && $detail['monto_cuota_entrega'] > 0 && $detail['nro_coutas'] > 1) {
                                                                $monto_cuota = number_format(($detail['total_price'] - $detail['monto_inicial'] - $detail['monto_cuota_entrega']) / $detail['nro_coutas'],2 ) ;

                                                               

                                                                 
                                                            }
                                                         
                            

                                                         

                                                            

                                                          
                                                            
                                                        @endphp
                                                        <td>{{ $detail['no'] }}</td>
                                                        <td>{{ $detail['name'] }}</td>
                                                        <td>{{ $detail['marca'] }}</td>
                                                        <td>{{ $detail['modelo'] }}</td>
                                                        <td>{{ $detail['qty'] }}</td>
                                                        <td>{{ $detail['nro_coutas'] }}</td>
                                                        <td>${{ floor($inicial) }}</td>
                                               
                                                        <td>${{ $monto_cuota }}   {{ $AlContado  }}</td>
                                                        <td>${{  $detail['monto_cuota_entrega']  }}</td>
                                                        <td>${{ $detail['total_price'] }}</td>

                                                        @php $monto_total+=$detail['total_price'] ;
                                                             $monto_cuota_total+=$monto_cuota;
                                                        
                                                        @endphp


                                                    </tr>
                                                @endforeach
                                                <tr>
                                                  <td colspan="3" style="text-align:right "> Totales</td>
                                                <td  colspan="2">
                                                        
                                                    <p> <strong>Subtotal: ${{ $order->subtotal}}</strong></strong></p>

                                                </td>
                                                <td>
                                                    <p> <strong>Descuento: </strong> <strong>${{ $order->discount}}</strong></p>
                                                </td>
                                                <td colspan="2">
                                                    <p> <strong>Inicial:${{ number_format($inicial,2)}}</strong> </p>
                                                </td>
                                                <td >
                                                    <p> <strong>Total: ${{ number_format($order->total,2) }}</p>
                                                </td>
                                                        
                                                 
                                                  
                                                      
                                                </tr>
                                                
                                               


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                        </div>
                       

                        <div  class="">
                          
                        
                            <div class="invoice-body " >
                                <h5  style="font-weight:800; font-size: 18px ; margin: 0;  padding: 0; " class="text-center"> Evaluación de la solicitud</h5>
                         
                            <div class="row gutters">

                              
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table custom-table m-0">

                                            <thead>                               
  <tr>
                                                 <th>Evaluación</th>
                                                 <th>Observación</th>
                                                 <th>% Evaluacion de la gerencia </th>
                                                 <th>% Confiabilidad</th>
                                                </tr>
                                            </thead>
                                                 <tr>
                                                   <td  class="td-title"><span >Evaluación comercial</span></td>
                                                   <td class="td-titulo">
                                                         @if (!empty($order->nota_evaluacion_comercial ))
                                                             {{$order->nota_evaluacion_comercial }} 
                                                         @endif
                                                  
                                                 </td>
                                                   <td class="td-titulo"> 
                                                     
                                                       @if (!empty($order->evaluacion_comercial ))
                                                           {{$order->evaluacion_comercial }} 
                                                       @endif
                                               
                                                  
                                                 </td>
                                   
                                                 <td class="td-titulo">
                                                     
                                                    
                                                     @if (!empty($order->confiabilidad ))
                                                         {{$order->confiabilidad }} 
                                                     @endif
                                              
                                              
                                               </td>
                                                 </tr>
                                   
                                                 {{-- Evaluacion_comercial --}}
                                   
                                   
                                                 {{-- nota_evaluacion_financiera --}}
                                   
                                                 <tr >
                                                   <td style="font-weight: 800;"  class="td-title"><span > Evaluación legal y Financiera</span></td>
                                                   <td >
                                                     
                                                       @if (!empty($order->nota_evaluacion_financiera ))
                                                        
                                                             {{$order->nota_evaluacion_financiera }} 
                                                         @endif
                                                    
                                                 </td>

                                                 
                                                   <td >
                                                     
                                                       @if (!empty($order->evaluacion_comercial ))
                                                           {!!$order->evaluacion_financiera == 0 ? $notas = '' : $notas = $order->evaluacion_financiera !!}
                                                       @endif
                                               
                                                   
                                                 </td>
                                                 <td >
                                                     
                                                    
                                                                 
                                                     @if (!empty($order->confiabilidad2 ))
                                                         {{$order->confiabilidad2 }} 
                                                     @endif
                                              
                                               </td>
                                                 </tr>
                                                 {{-- nota_evaluacion_financiera --}}
                                   
                                                 
                                   
                                   
                                                 
                                   
                                  
                                                 <tr >
                                                   <td style="padding: 35px;" class="td-title"><span >Decisión final</span></td>
                                                   <td >
                                                       @if (!empty($order->nota_decision_final ))
                                                       {{$order->nota_decision_final }} 
                                                   @endif
                                                    
                                                 </td>
                                                   <td>
                                                     
                                            
                                                        <!--<span value="0"  >  {{ $order['decision_final'] == 0 ? 'Pendiente':'' }}  </span>
                                                       <span value="1"   > {{ $order['decision_final'] == 1 ? 'Negado ':'' }}</span>
                                                       <span value="2"   > {{ $order['decision_final'] ==2  ? 'Aprobado':'' }}</span>
                                                       <span value="3"   >  {{ $order['decision_final'] ==3  ? 'Diferido':'' }}</span>
                                                       <span value="3"   > {{ $order['decision_final'] >3  ? 'Otro':'' }}</span> -->
                                             
                                                 </td>
                                                 </tr>
                                               </table>
                                        </div>
                                    </div>




                                    <div class=" col-lg-12 col-md-12 col-sm-12  mb-3">

                                       
                                        <div class="d-flex justify-content-end align-items-center">
                                            

                                                  <table class="table custom-table">
                                                    <thead>
                                                      <tr>
                                                       
                                                        <th scope="col">APROBADO</th>
                                                        <th scope="col">NEGADO</th>
                                                        <th scope="col">DIFERIDO</th>
                                                        <th >OTRO</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                      
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                      </tr>
                                                      
                                                     

                                                    
                                                    </tbody>
                                                  </table>

                                       
        
                                        </div>
                                       
                                    </div>


                                    </div>
                                </div>

                                 <div class="mt-5" style="text-align: center; ">
                                           <span style="width: 100%; font-weight: bold; "> __________________________________________________________________________________________________</span>
                                            <h5 style="padding: 0; margin: 0; font-weight: bold;">DECISOR</h5>
                                </div>
                            </div>

                     
                            @if (!empty($referencias[0])) 
                            <div class="invoice-body p-0 m-0 nueva-pagina mt-5">
                                <h5  style="font-weight: bold ; padding: 0;  margin: 0; font-size: 25px;" class="text-center">Referencias Personales</h5>
                               <div class="row gutters">
                                   <div class="col-lg-12 col-md-12 col-sm-12">
                                       <div class="table-responsive">
                                           <table  class="table custom-table m-0">
                                               <thead>
                                                   <tr>
                                                       <th>Nombre</th>
                                                       <th>Apellido</th>
                                                       <th>Cedula</th>
                                                       <th>Telefono</th>
                                                       <th>Parentesco</th>
                                                       <th>Nota</th>
   
                                                   </tr>
                                               </thead>
   
                                               @foreach ($referencias as $ref)
                                                   <tbody >
   
   
   
                                                       <td>{{ $ref->nombre_ref }}</td>
                                                       <td>{{ $ref->apellido_ref }}</td>
                                                       <td>{{ $ref->cedula_ref }}</td>
                                                       <td>{{ $ref->telefono }}</td>
                                                       <td>{{ $ref->parentesco }}</td>
                                                       <td>{{ $ref->nota }}</td>
   
   
   
   
   
                                                   </tbody>
                                               @endforeach
   
   
   
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                         @endif

                    </div>

                   
                     
                    <div style="font-weight:bold; font-size: 15px;" class="invoice-footer text-center">
                        Documento generado a través del sistema de Waika Import
                    </div>
                    <h5 class="text-center"  style="page-break-after:always"> </h5>

                    <div class="col-12"  style="page-break-after:always">

                        <div class="view view-first " >  
                            <div class="nueva-pagina">
                            <img  style=" max-width: 500px; height: auto;" class="img-fluid" src="/{!! $doc_cedula!!}" />  
                            </div>
                            <div class="nueva-pagina" style="page-break-after:always">
                            <img  style=" max-width: 500px; height: auto;" class="img-fluid" src="/{!! $rif !!}"/>  
                        </div>
                        <div class="nueva-pagina" style="page-break-after:always">
                            <img  style=" max-width: 500px; height: auto;"class="img-fluid" src="/{!! $constacia_trabajo !!}" />   
                        </div>
                        </div>
                    </div>
                   
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ sc_file('admin/LTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ sc_file('admin/LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        function order_print_pdf() {
            $('.dont-print').hide();


            // Iterar a través de cada etiqueta <fieldset> y agregar su contenido a la variable
            var contenidoPDF = $('.contenedor-html').html();


            var opt = {
                margin: 0.1,
                filename: '{{ $id }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation:'portrait' //'portrait'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(contenidoPDF).save();
            $('.dont-print').show();
        }

        function order_print(name){
    $('.dont-print').hide();
    var titleElement = document.getElementsByTagName("title")[0];
    var documentTitle = (titleElement !== undefined && titleElement !== null) ? titleElement.innerHTML : "Nombre Personalizado";
    if(titleElement !== undefined && titleElement !== null) {
        titleElement.innerHTML = name;
    }
    window.print(documentTitle);
    if(titleElement !== undefined && titleElement !== null) {
        titleElement.innerHTML = documentTitle;
    }
    $('.dont-print').show();
}
    </script>
