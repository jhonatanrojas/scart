<!-- Font Awesome -->


<div class="page-content ">


    <div style="font-weight: bold;" class=" px-0">
        <div class="row ">

            <div class="col-12">
                
            
                <!-- .row -->

    
                 
                <div  class="row   ">
                    <div class="col-12 mt-4 align-self-center  order-sm-last ">

                        <div class="table-responsive">

                            <table style="font-weight: bold;" class="table table-hover box-body text-wrap table-bordered">
                                <thead>
                                    <td class="text-center" colspan="6"><h5 style="font-weight: bold;" >PRODUCTO</h5></td>
                                    <tr>
                                       
                                        <td>Descripción</td>
                               
                                        <td>Cant</td>
                                        <td>Precio</td>
                   
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                
                                
                
                                <tbody>
                                    @foreach ( $order->details as $product)
                                    <tr>
                                        <td> {{  $product->name}}</td>
                    
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
                               {{-- <td class="text-center text-uppercase" colspan="6"> <h4 style="font-weight: bold;"  class="p-0 m-0">
                                        Fecha máxima de Entrega <hr>
                                        {{$fecha_maxima_entrega}}
                                    </h4>
                                    <span>La fecha de entrega puede ser modificada si el Beneficiario no realiza los pagos puntualmente (fecha de pago o día siguiente).</span></
                                </td> --}}
                                       
                                </tbody>
                
                            </table>
                            <br>
                            <table style="font-size: 1em; text-align: center;" class="table   text-wrap table-bordered">
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
                                <td style="font-weight: bold;"  class="h5 text-center" colspan="10">RESUMEN</td>
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
                   
                   

                    
                </div>
            </div>

            </div>
        </div>
        <div class="page-tools text-center m-auto">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px  dont-print" href="{{sc_route('reportePagos',['keyword'=> $order->id])}}" data-title="Print">
                    <i class=" fa fa-print text-primary-m1 text-120 w-2"></i>
                    Descargar reporte
                </a>
            
                <a class="btn  btn-primary mx-1px  " href="{{sc_route('customer.pagosPendientes',[$order->id])}}" data-title="Print">
                 
                  Pagos pendientes / Pagar
                    <i class=" fas fa-credit-card  text-120 w-2"></i> 
                </a>
            
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->

<script>
  function order_print(){
    $('.dont-print').hide();
    window.print();
    $('.dont-print').show();
  }
</script>



            
            
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


table tr td {
    font-weight: bold;
    font-size: 15px;

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
    font-size: 150%!important;
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