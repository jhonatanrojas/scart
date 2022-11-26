@php
    if(!empty($convenio)){
        $inconoAlert = "block";
    }
 
@endphp
@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
{{-- <h6 class="title-store">{{ $title }}</h6>
      @if (count($orders) ==0)
      <div class="text-danger">
        {{ sc_language_render('front.data_notfound') }}
      </div>
      @else
      <table class="table box table-bordered" width="100%">
        <thead>
          <tr>
            <th style="width: 50px;">No.</th>
            <th style="width: 100px;">ID</th>
            <th>{{ sc_language_render('order.total') }}</th>
            <th>{{ sc_language_render('order.order_status') }}</th>
            <th>{{ sc_language_render('common.created_at') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          @php
          $n = (isset($n)?$n:0);
          $n++;

          @endphp
       
          <tr>

            <td><span class="item_21_id">{{ $n }}</span></td>
            <td><span class="item_21_sku">#{{ $order->id }}</span></td>
            <td align="right">
              {{ number_format($order->total) }}
            </td>
            <td>{{ $statusOrder[$order->status]}}</td>
            <td>{{ $order->created_at }}</td>
            <td>
              <a href="{{ sc_route('customer.order_detail', ['id' => $order->id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ sc_language_render('order.detail') }}</a><br>
             @if($order->modalidad_de_compra==0)
              <a href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
              @endif
              <br>
              @if ($order->status !== 3 && $order->modalidad_de_compra == 1)
              <a target="_blank" class="d-flex" href="{{route('borrador_pdf', ['id' => $order->id]) }}"><i style="display:{{$inconoAlert ?? "" }} ;"  class=""><img width="30px" class="img-fluid" src="/images/documento.gif" alt=""></i>Ver Convenio</a>
              @endif


            </td>
           
          </tr>
          @endforeach
        </tbody>
      </table>
       --}}


       <h6 class="title-store">{{ $title }}</h6>
      @if (count($orders) ==0)
      <div class="text-danger">
        {{ sc_language_render('front.data_notfound') }}
      </div>
      @else
      <table class="table box table-bordered" width="100%">
        <thead>
          <tr>
            <th style="width: 50px;">No.</th>
            <th style="width: 100px;">ID</th>
            <th>{{ sc_language_render('order.total') }}</th>
            <th>{{ sc_language_render('order.order_status') }}</th>
            <th>{{ sc_language_render('common.created_at') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          @php
          $n = (isset($n)?$n:0);
          $n++;

          @endphp
       
          <tr>

            <td><span class="item_21_id">{{ $n }}</span></td>
            <td><span class="item_21_sku">#{{ $order->id }}</span></td>
            <td align="right">
              {{ number_format($order->total) }}
            </td>
            <td>{{ $statusOrder[$order->status]}}</td>
            <td>{{ $order->created_at }}</td>
            <td>
              <a href="{{ sc_route('customer.order_detail', ['id' => $order->id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ sc_language_render('order.detail') }}</a><br>
             @if($order->modalidad_de_compra==0)
              <a href="{{ sc_route('customer.reportar_pago', ['id' => $order->id ]) }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Reportar pago</a>
              @endif

              <br>
              @if ($order->status == 3 )
              <a target="_blank" class="d-flex" href="{{route('borrador_cliente', ['id' => $order->id]) }}"><i style="display:{{$inconoAlert ?? "" }} ;"  class=""><img width="30px" class="img-fluid" src="/images/documento.gif" alt=""></i>Ver Convenio</a>
              @endif

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
@endsection