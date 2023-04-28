@php
//  dd($customer);
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
<section class="my-5">

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 imagen_svg">
                <p class="text-center animate__animated animate__backInRight h4 mb-3">Bienvenido  <span> {{ $customer['first_name'] }} {{ $customer['last_name'] }}</span>!</p>
                @if (count($cart) >0)
                <p class="text-center"> <a href="{{sc_route('cart')}}" class="btn btn-primary btn-lg">Continuar Pedido </a> </p>
                @endif
            </div>
        
        </div>
    
    </div>
</section>

@endsection