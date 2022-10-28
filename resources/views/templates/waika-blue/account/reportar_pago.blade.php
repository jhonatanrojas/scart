@php
/*
$layout_page = shop_profile
** Variables:**
- $statusOrder
- $orders
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
<h class="title-store text-center"></h4>
    <div class="card">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="forma_pago">Forma de pago</label>
                    <select id="forma_pago" class="form-control">
                      <option selected>Transferencia</option>
                      <option>.pago Movil</option>
                    </select>  
                  </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Nro de referencia</label>
                  <input type="text" class="form-control"  name="referencia" id="referencia" placeholder="referencia">
                </div>
                
              </div>
    
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Fecha de pago</label>
                  <input type="date" class="form-control"  name="fecha" id="fecha" placeholder="referencia">
                </div>
                <div class="form-group col-md-6">
                  <label for="forma_pago">Monto</label>
                  <input type="monto" class="form-control"  name="monto" id="monto" placeholder="Monto">
                 
                </div>
              </div>

              <div class="form-row">
             
                <div class="form-group col-md-6">
                  <label for="forma_pago">Divisa</label>
                  <select id="forma_pago" class="form-control">
                    <option selected>Bs</option>
                    <option>USD</option>
                  </select>      
                 
                </div>

                <div class="form-group col-md-6">
               
                    <label for="forma_pago">Adjunta  referencia</label>
                    <input type="file" class="form-control-file" id="capture" name="capture" required="">
      
                      </div>
              </div>

            

           

          <a href="#" class="btn btn-primary">Reportar</a>
        </div>
      </div>

    

@endsection