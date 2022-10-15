@php

// $layout_page = shop_profile
// ** Variables:**
// - $customer


// dd($customer)
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
    <div class="container">

        <div class="row m-auto text-center align-self-center justify-content-around">
           <div class="col-12 ">
            <p class="text-su">Biemvenido <span> {{ $customer['first_name'] }} {{ $customer['last_name'] }}</span>!</p>

            <h3>Datos  Del Cliente </h3>

           </div>
            
            <div class="col-12 col-md-12 ">
                
                <ul class="list-group">
                    <li class="list-group-item text-info">Nombre: {{ $customer['first_name'] }}</li>
                    <li class="list-group-item"> apellido:{{ $customer['last_name'] }}</li>
                    <li class="list-group-item">Telefono:{{ $customer['phone'] }}</li>
                    <li class="list-group-item">Correo:{{ $customer['email'] }}</li>
                    <li class="list-group-item">Dereccion:{{ $customer['address1'] }}</li>
                  </ul>
                 

            </div>
         
        </div>
    </div>
    </div>
@endsection