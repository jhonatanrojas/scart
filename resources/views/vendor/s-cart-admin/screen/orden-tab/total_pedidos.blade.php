<div class="card">
    <div class="card-body">
        {{-- Total --}}
        <div class="col-sm-12">
          <div class="card collapsed-card">
              <table   class="table table-bordered">
                @foreach ($dataTotal as $element)
                  @if ($element['code'] =='subtotal')
                    <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif
                  @if ($element['code'] =='tax')
                  <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif
  
                  @if ($element['code'] =='shipping')
                    <tr><td>{!! $element['title'] !!}:</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}"  data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.shipping') }}">{{$element['value'] }}</a></td></tr>
                  @endif
                  @if ($element['code'] =='discount')
                    <tr><td>{!! $element['title'] !!}(-):</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.discount') }}">{{$element['value'] }}</a></td></tr>
                  @endif
                  @if ($element['code'] =='other_fee')
                    <tr><td>Otra tarifa:</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ config('cart.process.other_fee.title') }}">{{$element['value'] }}</a></td></tr>
                  @endif
                   @if ($element['code'] =='total')
                    <tr style="background:#f5f3f3;font-weight: bold;"><td>Total:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                  @endif
  
                  @if ($element['code'] =='received')
                    <tr><td>{!! $element['title'] !!}(-):</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.received') }}">{{$element['value'] }}</a></td></tr>
                  @endif
  
                @endforeach
  
                  <tr  {!! $style !!}  class="data-balance"><td>{{ sc_language_render('order.totals.balance') }}:</td><td style="text-align:right">{{($order->balance === NULL)?sc_currency_format($order->total):sc_currency_format($order->balance) }}</td></tr>
            </table>
          </div>
  
  
          
    
        </div>
        {{-- //End total --}}
  
        </div>
</div>