@php
    if(!empty($convenio)){
        $inconoAlert = "block";
    }


 
@endphp
@extends($sc_templatePath.'.account.layout')


@section('block_main_profile')
      @if(count($orders) ==0)
      <div class="text-danger">
        {{sc_language_render('front.data_notfound') }}
      </div>
      @else

      <div class="panel-heading animate__animated animate__backInRight">
        <h5 class="panel-title">{{ $title }}</h5>

    </div>

   <div class="table-responsive ">
    <table class="table    table-fixed" width="100%">
      <thead class="table-dark">
        <tr>
          <th style="width: 50px;">No.</th>
          <th style="width: 100px;">Convenio</th>
          <th style="width: 100px;">Solicitud</th>
          <th style="width: 100px;">Articulo</th>
          <th>{{ sc_language_render('order.order_status') }}</th>
          <th>Fecha de reporte</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
        @php
        $n = (isset($n)?$n:0);
        $n++;

       
        @endphp
     
        <tr class=" table-striped">

          <td><span class="item_21_id">{{ $n }}</span></td>
          <td><span class="item_21_sku">
            {{$order->nro_convenio ?? 'xxxxx'}}

            
        </span>
      </td>

          <td><span class="item_21_id">{{ $order->id }}</span></td>
         
            
             <td >
              {{$order->name_product}}
            </td>
            
        
          <td>
            
            <span class="badge badge-{{ $mapStyleStatus[$order->status]??'' }}">{{$statusOrder[$order->status]}}
            </span>
          </td>
          <td>
            
            {{ $order->created_at }}</td>
          <td>
            <a href="{{ sc_route('customer.order_detail', ['id' => $order->id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ sc_language_render('order.detail') }}</a><br>
           @if($order->modalidad_de_compra==0)
            <a href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
            @endif

            <br>
            @if ($order->status == 5 )
            <a target="_blank" class="d-flex" href="{{route('borrador_cliente', ['id' => $order->id]) }}"><i style="display:{{$inconoAlert ?? "" }} ;"  class=""><img width="30px" class="img-fluid" src="/images/documento.gif" alt=""></i>Convenio</a>
            @endif

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

   </div>
      
      @endif


 
@endsection