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
        background-size: 600px;
        height: 350px;
    }
</style>

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')

   <div class="container">
    <div class="row">
        <div class="col-12 col-md-12 imagen_svg">
            <p class="text-center  h4">Bienvenido  <span> {{ $customer['first_name'] }} {{ $customer['last_name'] }}</span>!</p>
        </div>
    </div>
   
   <br>
   {{-- <p class="text-center text-info h5"> <a href="es/cart.html">Ir al carrito de compras</a>  </p> --}}

   </div>
   
@endsection