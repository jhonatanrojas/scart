<!-- Font Awesome -->
<link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{ sc_file('admin/LTE/dist/css/adminlte.min.css')}}">
<style>
    body {
        color:#000;
    }
    </style>

<div class="page-content container">
    <div class="page-header text-blue-d2">
      <img src="{{ sc_file(sc_store('logo')) }}" style="max-height:100px;">
        <div class="page-tools">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95 dont-print" onclick="order_print()" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Imprimir
                </a>
            
               
            </div>
        </div>
    </div>

    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center h4">
                            <span class="text-dark">{{ sc_store('title') }}</span>
                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row mx-n1 mb-4" />

                <div class="row">
                    <div class="col-sm-8">
                        <div>
                            <span class="text-md  align-middle">Cliente:{{ $name }}</span> <br>
                            <span class="text-md  align-middle">Cedula:{{ $cedula }}</span>
                        </div>
                        <div class="">
                            <div class="my-1">
                              <i class="fas fa-map-marker-alt"></i> {{  $datos_cliente->estado  }},{{  $datos_cliente->municipio  }}, {{  $datos_cliente->parroquia  }}.  {{ $datos_cliente->address1 }}.
                            </div>
                            <div class="my-1">
                                <i class="fas fa-map-marker-alt"></i> {{ $address2}}
                              </div>
                            <div class="my-1"><i class="fas fa-phone-alt"></i> {{ $phone }}</div>
                            <div class="my-1"><i class="fas fa-phone-alt"></i> {{ $phone2 }}</div>
                            <div class="my-1"><i class="far fa-envelope"></i> {{ $email }}</div>
                            <div class="my-1"><i class=" fas fa-users"></i>Nos conocio: {{ $Nosconocio }}</div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 col-sm-4 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="">
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">Numero de solicitud:</span> #{{ $id }}</div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">{{ sc_language_render('order.date') }}:</span> {{ sc_datetime_to_date($created_at, 'Y-m-d') }}</div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">Numero de convenio:</span> #{{ $nro_convenio }}</div>

                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                 
                <div class="row d-flex justify-content-center " style="margin-left: 10%">
                    <div class="col-12 mt-5 align-self-center  order-sm-last ">
                   
                        <table class="table table-responsive text-grey-m2">
                            <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Producto</th>
                                  <th>Cant</th>
                                  <th>Numero de cuotas</th>
                                  <th>Monto Cuota</th>
                                  <th>Monto Inicial </th>
                                  <th>Total</th>
                          
                                </tr>
                              </thead>
                              
                          
                        
                          
                            <tbody>        
                                @foreach ($details as $detail)
                                <tr> 
                                @php 

$AlContado = "Financiamiento" ;
                                if($detail->id_modalidad_pago == 0){
                                    $AlContado = "Al contado";
                                }else if($detail->id_modalidad_pago ==2){
                                    $AlContado = "Financiamiento/Entrega Inmediata" ;
                                }
                                $inicial=0;
                                $precio=$detail['price'];
                                if($detail['abono_inicial']>0){
                                    $inicial= $detail['abono_inicial']* $detail['price']/100;
                                }
                                $precio= $precio-$inicial;
                                $monto_cuota=number_format( ( $precio *$detail['qty'] ) / $detail['nro_coutas'],2 );
                                    
                         
                                    
                                    @endphp
                                <td>{{$detail['no']}}</td>
                                <td>{{$detail['name']}}</td>
                                <td>{{$detail['qty'] }}</td>
                                <td>{{$detail['nro_coutas'] }}</td>      
                                <td>${{ $monto_cuota }}</td>  
                                <td>${{ number_format( $inicial) }}</td>    
                                <td>${{ number_format($detail['total_price']) }}</td>   
                                
                            
                                        
                                 
                            </tr>
                                @endforeach
            
                            </tbody>
                
            
                       
                    </table>
                    
                    
                </div>
            </div>
          
                <div class="mt-4">
                

                    <hr>
                    <div class="row border-b-2 "></div>

                    <div class="col-12 text-grey-m2 "  style="margin-left: 10%">
               
                        <h3 class="text-grey-m2">Refencias personales</h3>
                        <table class="table table-responsive text-grey-m2">
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
                          
                            <tbody>
    
                                   
    
                                <td>{{$ref->nombre_ref}}</td>
                                <td>{{$ref->apellido_ref}}</td>
                                <td>{{$ref->cedula_ref}}</td>
                                <td>{{$ref->telefono}}</td>      
                                <td>{{$ref->parentesco}}</td>      
                                <td>{{$ref->nota}}</td>      
                            
                                        
                                 
                                    
    
                            </tbody>
                            @endforeach
            
            
                       
                    </table>
                    
                    
                </div>
    

                </div>

                <hr>
                <br>
                
               <h5 class="text-center"> Evaluación del solicitud</h5>

                <table class="table table-hover box-body text-wrap table-bordered text-grey-m2"   style="margin-left: 5%">
                    <tr>
                     <td>Evaluación</td>
                     <td>Observación</td>
                     <td>% Interes Comercial</td>
                     <td>% Confiabilidad</td>
                    </tr>
                     <tr>
                       <td  class="td-title"><span >Evaluación comercial</span></td>
                       <td>
                             @if (!empty($order->nota_evaluacion_comercial ))
                                 {{$order->nota_evaluacion_comercial }} 
                             @endif
                      
                     </td>
                       <td>
                         
                           @if (!empty($order->evaluacion_comercial ))
                               {{$order->evaluacion_comercial }} 
                           @endif
                   
                      
                     </td>
       
                     <td>
                         
                        
                         @if (!empty($order->confiabilidad ))
                             {{$order->confiabilidad }} 
                         @endif
                  
                  
                   </td>
                     </tr>
       
                     {{-- Evaluacion_comercial --}}
       
       
                     {{-- nota_evaluacion_financiera --}}
       
                     <tr>
                       <td  class="td-title"><span >Evaluación financiera</span></td>
                       <td>
                         
                           @if (!empty($order->nota_evaluacion_financiera ))
                            
                                 {{$order->nota_evaluacion_financiera }} 
                             @endif
                        
                     </td>
                       <td>
                         
                           @if (!empty($order->evaluacion_comercial ))
                               {{$order->evaluacion_comercial }} 
                           @endif
                   
                       
                     </td>
                     <td>
                         
                        
                                     
                         @if (!empty($order->confiabilidad2 ))
                             {{$order->confiabilidad2 }} 
                         @endif
                  
                   </td>
                     </tr>
                     {{-- nota_evaluacion_financiera --}}
       
                     <tr>
                       <td  class="td-title"><span >Evaluación legal</span></td>
                       <td>
                           
                           @if (!empty($order->nota_evaluacion_legal ))
                                
                                 {{$order->nota_evaluacion_legal }} 
                             @endif
                       
                     </td>
                       <td>
                         
                        
                           @if (!empty($order->evaluacion_comercial ))
                               {{$order->evaluacion_comercial }} 
                           @endif
                    
                       
                     </td>
                     <td>
                         
                        
                         @if (!empty($order->confiabilidad3 ))
                             {{$order->confiabilidad3 }} 
                         @endif
                    
                   </td>
                     </tr>
       
       
                     
       
       
                     <tr>
                       <td  class="td-title"><span >Decisión final</span></td>
                       <td>
                           @if (!empty($order->nota_decision_final ))
                           {{$order->nota_decision_final }} 
                       @endif
                        
                     </td>
                       <td>
                         
                
                            <span value="0"  >  {{ $order['decision_final'] == 0 ? 'Pendiente':'' }}  </span>
                           <span value="1"   > {{ $order['decision_final'] == 1 ? 'Negado ':'' }}</span>
                           <span value="2"   > {{ $order['decision_final'] ==2  ? 'Aprobado':'' }}</span>
                           <span value="3"   >  {{ $order['decision_final'] ==3  ? 'Diferido':'' }}</span>
                           <span value="3"   > {{ $order['decision_final'] >3  ? 'Otro':'' }}</span>
                 
                     </td>
                     </tr>
                   </table>
            </div>
        </div>

        <div class="row align-content-center m-auto">
<div class="col-8">

    <div class="text-grey-m2">
        <p>Notas:</p>
        <i class="text-grey-m2">{!! $comment !!}</i>
    </div>

     
</div>


<div class="col-6">

    <div class="view view-first ">  
        <div style="page-break-after:always">
        <img  width="100%" class="img-fluid" src="/{!! $doc_cedula!!}" />  
        </div>
        <div style="page-break-after:always">
        <img  width="100%" class="img-fluid" src="/{!! $rif !!}"/>  
    </div>
    <div style="page-break-after:always">
        <img  width="100%" class="img-fluid" src="/{!! $constacia_trabajo !!}" />   
    </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ sc_file('admin/LTE/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ sc_file('admin/LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script>
  function order_print(){
    $('.dont-print').hide();
    window.print();
    $('.dont-print').show();
  }
</script>
<style>
  body{
    margin-top:20px;
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}



.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #000103;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #000103!important;
}
.align-bottom {
    vertical-align: bottom!important;
}
.high-light {
  background: #eaedef;
    font-weight: bold;
    color: #000;
}
</style>