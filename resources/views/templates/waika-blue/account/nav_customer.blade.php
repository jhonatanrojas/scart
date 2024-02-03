

<ul class="list-group mb-3">
        {{-- <span style="display:{{$inconoAlert ?? "" }} ;"  class="iconoAlert">
          <img width="30px" class="img-fluid" src="/images/documento.gif" alt="">
        </span> --}}
        <a class="list-group-item list-group-item-action {{ (Route::currentRouteName() == 'customer.order_list' ? 'active' : '')}}" href="{{ sc_route('customer.order_list') }}">
          <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> {{ sc_language_render('customer.order_history') }}
        </a>

        <a class="list-group-item list-group-item-action {{ (Route::currentRouteName() == 'customer.historial_pagos' ? 'active' : '')}}" href="{{ sc_route('customer.historial_pagos') }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Historial de pagos</a>

        <a class="list-group-item list-group-item-action {{ (Route::currentRouteName() == 'adjuntar_document' ? 'active' : '')}}" href="{{route('adjuntar_document')}}"><i class="fa fa-file" aria-hidden="true"></i> Adjuntar documentos </a>

        <a class="list-group-item list-group-item-action {{ (Route::currentRouteName() == 'customer.lista_referencia' ? 'active' : '')}}" href="{{sc_route('customer.lista_referencia')}}"><i class="fa fa-file" aria-hidden="true"></i> Referencias personales</a>

        <a class="list-group-item list-group-item-action {{ (Route::currentRouteName() == 'customer.address_list' ? 'active' : '')}}" href="{{ sc_route('customer.address_list') }}"><i class="fa-regular fa-rectangle-list"></i> {{ sc_language_render('customer.address_list') }}</a>
    
        <a class="list-group-item list-group-item-action {{ (Route::currentRouteName() == 'customer.change_infomation' ? 'active' : '')}}" href="{{ sc_route('customer.change_infomation') }}"><i class="fa-solid fa-address-book"></i> Actualizar mis datos</a>

        <a class="list-group-item list-group-item-action {{ (Route::currentRouteName() == 'customer.change_password' ? 'active' : '')}}" href="{{ sc_route('customer.change_password') }}"><i class="fa fa-key" aria-hidden="true"></i> {{ sc_language_render('customer.change_password') }}</a>
</ul>




    


<script type="text/javascript">
    const susMenu_ul = document.getElementById("susMenu_ul");
    const susMenu = document.getElementById("susMenu");
   
    document.getElementById("menu").addEventListener("click",function(){
  
  document.getElementById("navega").classList.toggle("mostrar");
});

</script>