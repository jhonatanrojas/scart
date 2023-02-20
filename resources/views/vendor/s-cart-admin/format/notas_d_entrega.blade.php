<!-- Font Awesome -->
<link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{ sc_file('admin/LTE/dist/css/adminlte.min.css')}}">

<div class="page-content container">
    <div class="page-header text-blue-d2">
      
        <div class="page-tools text-center m-auto">
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
                    
                    <div class="col-12 mb-4">
                        
                        <span class="h4">WAIKA IMPORT C.A</span>
                        <img width="100" class="text-center img-fluid" src="{{ sc_file(sc_store('logo')) }}" style="margin-left: 30%">
                        <p>
                            RIF. J-50145053-6
                            A.V CUARTA TRANSVERSAL CALLE MIRAIMA EDIF: G.M.S.Y.T , BOLEITA NORTE, CARACAS MIRANDA ZONA POSTAL 1073
                            0412.635.40.41 / 0412.635.40.38</p>
                    </div>
                    <div class="col-12">
                        <div class="text-center text-150">
                            <span class="text-default-d3">
                                NOTA DE ENTREGA N°:
                                </span>
                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />

                <div class="d-flex align-items-center justify-content-center">
                    <div class="col-md-5">
                        <div class="my-1"><i class="fas fa-user-tie"></i> Cliente:{{$cliente}}</div>
                        
                        <div class="text-grey-m2">
                            <div class="my-1">
                              <i class="fas fa-map-marker-alt"></i> direccion: {{$direccion}}
                            </div>
                            <div class="my-1"><i class="fas fa-address-book"></i> RIF / CI: {{$cedula}}</div>
                            <div class="my-1"><i class="fas fa-user-tie"></i> VENDEDOR: {{$vendedor}}</div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-50 col-md-4  d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">Fecha Emision:{{$fecha_pago}}</span> </div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">N° de Lote:{{$lote}}</span></div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">N° de Convenio:{{$nro_convenio}}</span> </div>
        
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                 
                <div class="row   ">
                    <div class="col-12 mt-4 align-self-center  order-sm-last ">

                        <div class="table-responsive">

                            <table class="table table-hover box-body text-wrap table-bordered">
                                <thead>
                                    <td class="text-center" colspan="7"><h4>PRODUCTO</h4></td>
                                    <tr>
                                       
                                        <td>DESCRIPCION</td>
                                        <td>CANT</td>
                                        <td>PRECIO</td>
                                        <td>TASA DE CAMBIO</td>
                                        <td>Dcto</td>
                                        <td>Total</td>
                                        <td>Referencia ($)</td>
                                    </tr>
                                </thead>
                
                                <tbody>
                                    <tr>
                                        
                                        <td>{{$nombre_product}}</td>
                                        <td>{{$cantidad}}</td>
                                        <td>{{$tota_product}}</td>
                                        <td>{{$tasa_cambio}}</td>
                                        <td></td>
                                        <td>{{$tota_product}}</td>
                                        <td>{{$tota_productusd}} </td>
                                        
                                    </tr>
                                    <br>
                                <td class="text-center" colspan="7"> <h4>
                                    MONTO ADEUDADO PARA LA FECHA 
                                    
                                </td>
                                <br>
                                <tr>
                                    <td class="text-center" colspan="7"> <h4>
                                        <span>REFERENCIA: {{$referencia}}$</span>
                                        
                                    </td>
                                </tr>
                               
                                       
                                </tbody>
                
                            </table>


                            <br>
                           

                            <div class="d-flex align-items-center mb-4">

                                <div class="col-md-6 ">
                                    
                                    
                                    
                                    <ul class="" style="list-style: none">
                                        <li class="">TERMINOS DE GARANTIA:</li>
                                        <li>Monto de 1.- 360 DIAS DE GARANTIA POR SERVICIO TECNICO
                                        </li>
                                        <li>2.- NO CUBRE DAÑO POR MAL USO NI FALLAS ELECTRICAS</li>
                                        <li>SE ENTREGA NUEVO Y EN PERFECTO ESTADO.</li>
                                    </ul>

                                    <div style="margin-left: 35px">
                                        RECIBE CONFORME:__________________
                                    </div>
                                </div>

                                <div class="col-md-6 aling-items-center">
                                       
                                    
                                    <ul class="" style="list-style: none">
                                        <li class="">Total Nota de Entrega:</li>
                                        <li>Total Descuento:</li>
                                        <li>Total Operación:</li>
                                        <li></li>
                                    </ul>
                                    <br>
                                    <br>
                                    <br>

                                    <div style="margin-left: 35px">
                                        Cantidad de Productos:             {{$cantidad}}
                                    </div>
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

.text-grey-m2 {
    color: #888a8d!important;
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