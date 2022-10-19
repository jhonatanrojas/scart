@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')

   <div class="container">
    <div class="row">
        <div class="col-12 col-md-12">
           
        </div>
    </div>
    <p class="text-center text-success h4">Bienvenido <span> {{ $customer['first_name'] }} {{ $customer['last_name'] }}</span>!</p>
   
   </div>
   
@endsection