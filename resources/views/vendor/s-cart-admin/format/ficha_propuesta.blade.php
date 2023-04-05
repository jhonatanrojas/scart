<!-- Font Awesome -->
<link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{ sc_file('admin/LTE/dist/css/adminlte.min.css')}}">

<div style="color: black" class="page-content container">
    <div class="row justify-content-around ">
      <img src="{{ sc_file(sc_store('logo')) }}" style="max-height:80px;">
        <div class="page-tools">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95 dont-print" onclick="order_print()" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Imprimir
                </a>
            
               
            </div>
        </div>
    </div>

    <div class="container px-0 ">
        <div class="row mt-4 justify-content-center ">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center ">
                            <span class="page-title">{{ sc_store('title') }}</span>
                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />

                <div class="row justify-content-center align-content-center">
                    <div class="col-sm-4">
                        <div>
                            <span class=" text-dark">Cliente:{{ $name }}</span> <br>
                            <span class=" text-dark align-middle">Cedula:{{ $cedula }}</span>
                        </div>
                        <div class="text-dark">
                            <div class="my-1">
                              <i class="fas fa-map-marker-alt "></i> {{ $address }}, {{ $country }}
                            </div>
                            <div class="my-1">
                                <i class="fas fa-map-marker-alt "></i> {{ $address2 }}, {{ $country }}
                              </div>
                            <div class="my-1"><i class="fas fa-phone-alt"></i> {{ $phone }}</div>
                            <div class="my-1"><i class="fas fa-phone-alt"></i> {{ $phone2 }}</div>
                            <div class="my-1"><i class="far fa-envelope"></i> {{ $email }}</div>
                            <div class="my-1"><i class=" fas fa-users"></i>Nos conocio: {{ $Nosconocio }}</div>
                           
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class=" col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-dark">
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">Numero del la Solicitud:</span> #{{ $id }}</div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">{{ sc_language_render('order.date') }}:</span> {{ sc_datetime_to_date($created_at, 'Y-m-d') }}</div>
                           

                        </div>
                    </div>

                  
                    <!-- /.col -->
                </div>

                 
                <div class=" mt-5 " >

                  
                    <div class="  col-lg-10 offset-lg-1">

                        <table   class="table table-responsive p-2">
                            <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Producto</th>
                                  <th>Cantida De Producto</th>
                                  <th>Numero de cuotas</th>
                                  <th>Monto Cuotas</th>
                                  <th>Inicial</th>
                          
                                </tr>
                              </thead>
                       
                              @foreach ($details as $detail)
                          
                            <tbody>
    
                               
                                <td>{{$detail['no']}}</td>
                                <td>{{$detail['name']}}</td>
                                <td>{{$detail['qty'] }}</td>
                                <td>{{$detail['nro_coutas'] }}</td>      
                                <td> ${{number_format( $detail['monto_cuotas'] ,2)}}</td> 
                                     
                                <td>{{number_format( $detail['total_price'],2)}}$</td>      
                            
                                        
                                 
                                    
    
                            </tbody>
                            @endforeach
            
            
                       
                    </table>
                    
                    
                </div>

               
            </div>

            <div  class="col-lg-9 m-auto">
                <h3 class="">NOTA</h3>
                <hr>
                <div class="text-dark page-title">
                   <p> {{$comment}}</p>
                </div>
                <hr>
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
    font-weight: 400;
    color:#000;
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

.text-dark {
    color: #000103!important;
    font-size: 18.4px;
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
.text-dark-m1 {
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