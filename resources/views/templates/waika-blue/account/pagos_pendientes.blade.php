@php
/*
$layout_page = shop_profile
** Variables:**
- $statusOrder
- $statusShipping
- $order
- $countries
- $attributesGroup
*/ 



@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
<section class="mb-5">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
          <b class="title-store">{{ $title }}</b>
     
        </div>
      </div>
      <div class="col-12">
        @if (!$order)
          <div class="text-danger text-center">
            {{ sc_language_render('front.data_notfound') }}
          </div>
        @else
          <div class="row" id="order-body"> 
     

      

          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-end">
                @if($order->modalidad_de_compra==0)
                  <div class="align-self-end ">
                    <a  class="btn btn-info" href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
                  </div>
                @endif
              </div>
              <h3 class="text-center">Pagos pendientes</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="">
                    <tr>
                      <th>No.</th>
                      <th>Monto</th>
                           <th>Divisa</th>
                      <th class="text-center">Fecha de Vencimiento</th>
                      <th class="text-center">Estatus del pago</th>
                      @if($order->modalidad_de_compra==0)
                      <th>
                        {{ sc_language_render('common.created_at') }}
                      </th>
                       @endif
                   
                      <th>Acciones</th>
                      
                    </tr>
                  </thead>
            
                  @php
                    $monedaBs ='';
foreach (sc_currency_all()  as $moneda) {
    if ($moneda->code === "Bs") {
        $monedaBs = $moneda;
        break;
    }
}
                  @endphp

                   

                  <tbody>
                    @foreach($historial_pagos as $historial)
                      <tr>
                          @php


                          
                          $n = (isset($n)?$n:0);
                          $n++;
                            if($order->modalidad_de_compra==0)
                              $n=$historial->nro_coutas;
                          @endphp
                        <td>
                          <span class="item_21_id">
                            {{ $historial->nro_coutas; }}
                          </span>
                        </td>
                        <td>
                          <span class="badge text-bg-{{ $mapStyleStatus[$historial->payment_status]??'' }} item_21_sku z">${{ $historial->importe_couta}}</span>
                        </td>
                     
                        <td>{{'USD' }}</td>
                        <td>
                          <span class="item_21_sku">{!! $historial->fecha_venciento !!}
                          </span>
                        </td> 
                        <td>
                          <span class="item_21_sku badge text-bg-{{ $mapStyleStatus[$historial->payment_status]??'' }}">
                              {{ $historial->estatus->name }}
                          </span>
                        </td>
                     
                        
                        @if($order->modalidad_de_compra>=1 &&  $historial->payment_status != 2  && $historial->payment_status !=5)
                          <td>   
                            <button onclick="pagar('{{$historial->id}}')" value="{{$historial->id}}" id="pagar" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" >
                              PAGAR
                            </button>
                           
                          </td>
                        @endif
                      </tr>
                      <!-- Button trigger modal -->
                      <div class="modal" id="myModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5>Seleccione la forma de pago</h5>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                  
                            @if($order->modalidad_de_compra>=1)
                              <div class="modal-body m-auto ">


                                  <div class="row mb-5">
                                    <div class="col-md-12">
                                
                                        <button type="button"  href="{{ route('biopago',['id' => $order->id ,'id_pago'=>$historial->id])}}"  id="bioPago" class="btn btn-danger btn-block btn-lg">
                                          <span class="d-flex">
                                            <img width="15px" class="img-fluid" src="/images/BiopagoBDV-logo.png" alt="Biopago">
                                            Biopago BDV
                                          </span>
                                        </button>
                              
                           
                                    </div>
                                  </div>
                                  <div class="row  mb-5">
                                    <div class="col-12">
                                      <div class="puntoDeventa">
                                        <button class="btn btn-danger btn-block btn-lg" id="py-client" onclick="puntoYabioPago('{{$historial->importe_couta}}')">
                                          <span class="d-flex">
                                            <img width="15px" class="img-fluid" src="/images/BiopagoBDV-logo.png" alt="Biopago">
                                            PuntoYaBDV
                                          </span>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                
                              
                                  <div class="row mb-5 ">
                                    <div class="col-12">
                                      <div class="btn__pagomovil">
                                        <button type="button" id="pagoMovil" onclick="pagoMovil({{$historial->id}})"  class="btn btn-warning btn-block btn-lg">
                                          <span class="d-flex">
                                            <img width="20px" class="img-fluid" src="/images/pagomovil.png" alt="Biopago">
                                            Pago movil
                                          </span>
                      
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                               

                                
                              
                                                       
                                
                                  
                           
                                 
                              </div>
                            @endif  
                              <div class="modal-footer mb-4">
                                <button  type="button" class="btn btn-ligh " data-dismiss="modal" id="cerrarmodal">
                                  Cancelar
                                </button>
                              </div>
                          </div>
                        </div><!-- /.modal-content -->
                      </div>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
      </div> <!-- .col -->
    </div> <!-- .row -->
  </div> <!-- .container -->
  <input type="hidden" id="pagos_id" value="0">
</section>
    
@endsection


@push('scripts')
<script src="https://puntoyapos.com.ve/pos/assets/scripts/py-script.js"></script>
<script type="text/javascript">
    const callback = (responseData) => {
      console.log(responseData)
      Swal.fire({
          title: responseData.responseMessage,
          html:
            '<b>Monto:</b> ' + responseData.amount + '<br>' +
            '<b>ID de transacción:</b> ' + responseData.transactionId + '<br>' +
            '<b>Referencia:</b> ' + responseData.reference + '<br>' +
            '<b>Fecha de pago:</b> ' + responseData.paymentDate,
          icon: 'success'
        });
      // Los valores de la respuesta son: 
      // ok: boolean, (true en caso de ser exitosa, false en caso de ser fallida)
      // description: string, (descripción de la transacción)
      // transactionId: string, (referencia bancaria de la transacción)
      // Ejemplo: { ok: true, description: 'Pago exitoso', transactionId: '1858749961512' }
    };
  function puntoYabioPago(monto){
    $("#cerrarmodal").click()
    console.log(monto)
    var tasa_cambio = '{{$monedaBs->exchange_rate }}';
    console.log()
    monto= parseFloat(tasa_cambio)*parseFloat(monto);
    console.log(monto)
    payWithPuntoYa(monto, callback);
 
  }
        function transferencia (id){
           number = id
            location.href=`{{ sc_route('customer.reportar_pago',['id' => $order->id ,'id_pago'])}}=${id}&Transferencia=Transferencia`
        }

        function pagoMovil (id_pago){
          let id_pago = ${"#pagos_id"}.val()

          location.href="/es/customer/reportar-pago/{{$order->id}}?id_pago=" + id_pago
        }

        function bioPago (id){
          let id_pago = ${"#pagos_id"}.val()

          location.href="{{ route('biopago',['id' => $order->id ,'id'=>"+id_pago+"])}}" 
        }


        function pagar (id_pago){
          ${"#pagos_id"}.val(id_pago)
        }
</script>

@endpush