<!-- Font Awesome -->
<link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{ sc_file('admin/LTE/dist/css/adminlte.min.css')}}">
@php
    
    $storeId =1;
@endphp

<div class="page-content  ">
    <div class="page-header text-blue-d2">
      
        <div class="page-tools text-center m-auto">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px  dont-print" onclick="order_print()" data-title="Print">
                    <i class=" fa fa-print text-primary-m1 text-120 w-2"></i>
                    Imprimir
                </a>
            
               
            </div>
        </div>
    </div>

    <div style="font-weight: bold;" class="container px-0">
        <div class="row ">
 
           <div class="col-12">
            <div class="row  align-items-center">
                <div class="col-3"> 
                    <img style=";" width="200" class="  img-fluid" src="https://www.waika.com.ve/data/logo/waika-logo.png" >
                           
                     

                    
                </div>

                <div class="col-6 ">
                 
             
                   
                    <p class="text-secundary fw-light">
                  
                        {{ sc_language_render('store.address') }}: {{ sc_store('address', ($storeId ?? null)) }}
                        TELÉF:                       0412-6354041/0412-6354039
                       </p> 
                </div>
    
                <div  class="col-3 text-center">
                    <img class="img-fluid " alt="Código QR" id="codigo">
    
                   
                
                </div>
            </div>

           </div>
            <div class="col-12 ">
                
                <div class="row">
                  
                      
              
                    <div class="col-12"> 
                        <h5 class="text-center">
                            <span style="font-weight: bold;"  >
                                HISTORIAL DE PAGO
                                </span>
                            </h5>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />

                <div class="d-flex align-items-center justify-content-center " style="font-weight: bold;">
                    <div class="col-md-5">
                        
                        <div class="my-1">
                            <i class="fas fa-user-tie"></i>Cliente: {{$cliente}}
                          </div>
                        
                        <div class="">
                            <div class="my-1">
                              <i class="fas fa-map-marker-alt"></i> Dirección: {{$direccion}}
                            </div>
                            <div class="my-1"><i class="fas fa-address-book"></i> RIF / CI: {{$cedula}}</div>
                            <div class="my-1"><i class="fas fa-user-tie"></i> VENDEDOR: {{$vendedor}}</div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-50 col-md-6  d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="">
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">Emitido por: {{$emitido_por}}</span> </div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">Fecha Emisión:{{$fecha_pago}}</span> </div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">sección:{{$lote}}</span></div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">N° de Convenio:{{$nro_convenio}}</span> </div>
        
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                 
                <div  class="row   ">
                    <div class="col-12 mt-4 align-self-center  order-sm-last ">

                        <div class="table-responsive">

                            <table class="table table-hover box-body text-wrap table-bordered" id="tabla-producto">
                                <thead>
                              
                                    <tr>
                                        
                                        <td>Descripción</td>
                                        <td>Serial</td>
                                        <td>Cant</td>
                                        <td>Precio</td>
                   
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                
                
                                <tbody>
                                    @foreach ( $order->details as $product)
                                    <tr>
                                        <td> {{  $product->name}}</td>
                                        <td> {{  $product->serial}}</td>
                                        <td> {{  $product->qty}}</td>
                                
                                        <td> {{  $product->price}}</td>
                                    <td>{{  $product->total_price}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>     <td colspan="3"></td> 
                                        <td >Sub total</td>
                                        <td>{{ $order->subtotal}}</td>
                                    </tr>
                                    <tr>     <td colspan="3"></td> 
                                        <td >Descuento</td>
                                        <td>{{ $order->discount}}</td>
                                    </tr>
                                   
                                    <tr>     <td colspan="3"></td> 
                                        <td  style="font-weight: bold;" > Total Ref $ </td>
                                        <td  style="font-weight: bold;">{{ $order->total}}</td>
                                    </tr>
                                    <br>
                                <td class="text-center text-uppercase" colspan="6"> <p  class="p-0 m-0">
                                        Fecha máxima de Entrega:
                                        {{$fecha_maxima_entrega}}
                                </p>
                                    <span>La fecha de entrega puede ser modificada si el Beneficiario no realiza los pagos puntualmente (fecha de pago o día siguiente).</span></
                                </td>
                                       
                                </tbody>
                
                            </table>
                            <br>
                            <table id="tabla-pago" style=" text-align: center;" class="table   text-wrap table-bordered">
                              <thead>
                                <tr>
                                  @if (!empty($removeList))
                                  <th></th>
                                  @endif
                                  @foreach ($listTh as $key => $th)
                                    <th>{!! $th !!}</th>
                                  @endforeach
                                 </tr>
                              </thead>
                              <tbody>
                                @foreach ($dataTr as $keyRow => $tr)
                    
                                <tr>
                                    @if (!empty($removeList))
                                    <td>
                                      <input class="checkbox grid-row-checkbox" type="checkbox" data-id="{{ $keyRow }}">
                                    </td>
                                    @endif
                                    @foreach ($tr as $key => $trtd)
                                        <td>{!! $trtd !!}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                              </tbody>

                              <tr>
                    
                                <td colspan="4"></td> 
                                <td colspan="2">Total Bs: {!!number_format($total_bs ,2)!!}   BS</td>
                         
                                                               <td colspan="2">Total Ref $: {{$total_monto_pagado}} $</td>
                              </tr>
                              <tr>
                                <td   class="h5 text-center" colspan="10">RESUMEN</td>
                              </tr>
                    
                              
                            </table>

                            <div class="d-flex align-items-center mb-4">

                                <div class="col-md-6 ">
                                    
                                    
                                    
                                    <ul class="" style="list-style: none">
                                        <li class="">Numero de cuotas pendientes:  {{$Cuotas_Pendientes}}</li>
                                        <li>Monto de próxima cuota (Ref. $):    {{$cuota_pendiente}}
                                        </li>
                                        <!--<li>Fecha Proxima Cuota:{{$formatted_dates ?? 'N/A'}}</li>
                                        <li></li>-->
                                    </ul>

                                </div>

                                <div class="col-md-6 aling-items-center">
                                       
                                    
                                    <ul class="" style="list-style: none">
                                        <li class="">Total Convenio : {{$totales}}$</li>
                                        <li>Total Pagado para la Fecha :{{$total_monto_pagado}}$</li>
                                        <li>Total Monto Adeudado : {{number_format($totalPor_pagar ,2,',','.')}}$</li>
                                        <li></li>
                                    </ul>

                                   
                                </div>
                            </div>
                    
                                
                            </div>
                   
                   


                          {{-- <table class=" table table-hover box-body text-wrap table-bordered" style="width: 50%; margin-left: 50%">
                            <thead>
                              <tr>
                                <th>Divisa</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($totaleudsBS as $forma_pago => $monedas): ?>
                                <?php foreach ($monedas as $moneda => $total): ?>
                                  <tr>
                                    <td><?php echo $moneda; ?></td>
                                    <td><?php echo $total; ?></td>
                                  </tr>
                                <?php endforeach; ?>
                              <?php endforeach; ?>
                            </tbody>
                          </table> --}}
                    
                    
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


<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
            
            
<script>
        new QRious({
    element: document.querySelector("#codigo"),
    value: "{{route('view_QR',['id' =>$id_solicitud])}}", // La URL o el texto
    size: 140,
    backgroundAlpha: 0, // 0 para fondo transparente
    foreground: "#000", // Color del QR
    level: "H", // Puede ser L,M,Q y H (L es el de menor nivel, H el mayor)
    });

</script>
<style>
  body{
    margin-top:20px;
    color: #484b51;
    
}

#tabla-producto   td,#tabla-pago   td {
   padding:  0.30rem;

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
    color: #757984;
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
    font-size: 1.5rem;
} 
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
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