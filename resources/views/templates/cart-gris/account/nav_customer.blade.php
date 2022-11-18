

<ul class="list-group list-group-flush member-nav ">
    <li class="list-group-item ">
        <a style="color: black;" href="{{ sc_route('customer.order_list') }}"><i class="fa fa-cart-arrow-down text-black" style="color: black;" aria-hidden="true"></i> {{ sc_language_render('customer.order_history') }}</a>
    </li>

    
 

    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.address_list') }}"><i class="fa fa-id-card-o" aria-hidden="true"></i> {{ sc_language_render('customer.address_list') }}</a>
    </li>
    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.historial_pagos') }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Historial de pagos</a>
    </li>
  
    <li class="list-group-item">
        <a style="color: black;" href="{{route('adjuntar_document')}}"><i class="fa fa-file" aria-hidden="true"></i> Adjuntar documentos </a>
    </li>
    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.change_infomation') }}"><i class="fa fa-list" aria-hidden="true"></i> 
            Actulizar mis datos
        </a>
    </li>
    <li class="list-group-item">
        <a data-toggle="modal" data-target="#myModal" style="color: black;" href="#"><i class="fa fa-list" aria-hidden="true"></i> 
             referencia
        </a>
    </li>
    <li class="list-group-item">
        <a  style="color: black;"href="{{ sc_route('customer.change_password') }}"><i class="fa fa-key" aria-hidden="true"></i> {{ sc_language_render('customer.change_password') }}</a></li>
</ul>


<div class="container">
    <form method="POST">
    <div class="modal  mt-5" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog  " role="document">
          <div class="modal-content">
            <div class="modal-header">
                
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
             
            </div>
            <h5 class="text-center">Referencia personal</h5>
            <div class="modal-body p-0">

               <div class="container">
                    <div class="row justify-content-center  ">
                        <div class="mt-4 col-12">
                            <div class="col-12 col mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input name="nombre_ref" type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="addon-wrapping">
                                  </div></div>
                            <div class="col-12 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input name="apellido_ref" type="text" class="form-control" placeholder="Apellido" aria-label="Apellido" aria-describedby="addon-wrapping">
                                  </div></div>
                            <div class="col-12 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input name="telefono_ref" type="text" class="form-control" placeholder="Telefono" aria-label="Telefono" aria-describedby="addon-wrapping">
                                  </div></div>
                            <div class="col-12 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"></span>
                                    <input name="parentesco" type="text" class="form-control" placeholder="Parentesco" aria-label="Parentesco" aria-describedby="addon-wrapping">
                                  </div></div>
                        </div>
                        <input type="hidden" name="">
                       </div>
                        

                       
                       <div class="modal-footer mb-4">
                        <button  type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="butto_modal" disabled="true" type="submit" class="btn btn-primary">continuar</button>
                      </div>
                         
                    </div>

               </div>
              
              
            </div>
            
          </div>
          
          
          <!-- /.modal-content -->
        </div>
        
      </form>
      </div>
{{-- {{ sc_route('customer.agregar referencia') }} --}}