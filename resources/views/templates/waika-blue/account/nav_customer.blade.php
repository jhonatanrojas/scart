@php 
$customer = auth()->user();
$nr= 1;
$nro = 1;
$order_id = '';
$results = DB::select('select * from sc_shop_order');
foreach ($results as $key => $value) {
  if($value->customer_id === $customer->id){
    $results=$nr++;
    $order_id = $value->id;
  }else $results = 0;
}

$historial = DB::select('select * from sc_historial_pagos');
foreach ($historial as $key => $value) {
  if($value->order_id == $order_id && $value->payment_status == 5){
    $historial=$nro++;
  }else if(!$value->order_id == $order_id || !$value->payment_status == 5) $historial = 0;
}
@endphp

<ul class="list-group list-group-flush member-nav ">
    <li class="list-group-item  ">
        <span style="display:{{$inconoAlert ?? "" }} ;"  class="iconoAlert"><img width="30px" class="img-fluid" src="/images/documento.gif" alt=""></span>
        <a style="color: black;" href="{{ sc_route('customer.order_list') }}"><i class="fa fa-cart-arrow-down text-black" style="color: black;" aria-hidden="true"></i> {{ sc_language_render('customer.order_history') }}
        </a>
       
      
      <a style="color: rgba(248, 19, 19, 0.726); font-size: 15px" class="rd-navbar-basket far fa-bell " href="#">
        <span style="color: rgba(248, 19, 19, 0.596)" class="count " >{{$results}}</span>
       
      </a>
    </li>

    <li class="list-group-item ">
      <a style="color: black;" href="{{ sc_route('customer.historial_pagos') }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Historial de pagos</a>
     
      <a style="color: rgba(248, 19, 19, 0.726); font-size: 15px" class="rd-navbar-basket far fa-bell " href="#">
        <span style="color: rgba(248, 19, 19, 0.596)" class="count " >
          {{$historial}}
            
        
      </span>
       
      </a>
     
  </li>
  <li class="list-group-item">
    <a style="color: black;" href="{{route('adjuntar_document')}}"><i class="fa fa-file" aria-hidden="true"></i> Adjuntar documentos </a>
</li>

<li class="menu list-group-item" id="menu">
  <i class="fa fa-file" aria-hidden="true"></i>
  referencias personales
  <nav id="navega" class="nav2">
    <ul>
      
      <li><a href="{{sc_route('customer.lista_referencia')}}">Lista de Referencia personal</a></li>
     
      
    </ul>
    
  </nav>
</li>

    
 

    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.address_list') }}"><i class="fa fa-id-card-o" aria-hidden="true"></i> {{ sc_language_render('customer.address_list') }}</a>
    </li>
   
  
   
    <li class="list-group-item">
        <a style="color: black;" href="{{ sc_route('customer.change_infomation') }}"><i class="fa fa-list" aria-hidden="true"></i> 
            Actulizar mis datos
        </a>
    </li>
    
    
    
   


    
    
 

    <li class="list-group-item">
        <a  style="color: black;"href="{{ sc_route('customer.change_password') }}"><i class="fa fa-key" aria-hidden="true"></i> {{ sc_language_render('customer.change_password') }}</a></li>
</ul>




    


<script type="text/javascript">
    const susMenu_ul = document.getElementById("susMenu_ul");
    const susMenu = document.getElementById("susMenu");
   
    document.getElementById("menu").addEventListener("click",function(){
  
  document.getElementById("navega").classList.toggle("mostrar");
});

</script>