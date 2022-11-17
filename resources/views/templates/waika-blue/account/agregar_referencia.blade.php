@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp
<style>
    .imagen_svg{
        background-image: url('/images/asset 0.svg');
        background-origin: border-box;
        background-repeat: no-repeat;
        background-position: center;
        /* background-size: contain; */
        background-size: 600px;
        height: 350px;
    }
</style>

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')

   <div class="container">
    <div class="row">
        <div class="col-12 col-md-12 imagen_svg">
            
            
            <div class="m-auto w-50">
                <div class="mb-4 mt-4  ">
                    <h4 class="text-center">Referencia personal</h4>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">@</span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                      </div>
                </div>
                <div class="mb-4  ">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">@</span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                      </div>
                </div>
                <div class="mb-4  ">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">@</span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                      </div>
                </div>
                <div class="mb-4  ">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">@</span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                      </div>
                </div>
            </div>

            <div class=" col-6 mt-3 p-2 text-center m-auto">
                <button id="guarda"  class="btn btn-primary w-100">guardar</button>

            </div>
           
             
        </div>

        
    </div>

   </div>
   
@endsection