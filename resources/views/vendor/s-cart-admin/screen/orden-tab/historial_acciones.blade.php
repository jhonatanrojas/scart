<div class="card">
    <div class="card-body">
        <!-- /.card-header -->
        <h3 class="card-title">{{ sc_language_render('order.admin.order_history') }}</h3>
        <div class="order-info">
            <span><b>IP:</b> {{ $order->ip }}</span>
        </div>
        <div class="card-body p-0 out">
          <div class="table-responsive">
            @if (count($order->history))
            <table  class="table m-0" id="history">
              <tr>
                <th>{{ sc_language_render('order.admin.history_staff') }}</th>
                <th>{{ sc_language_render('order.admin.history_content') }}</th>
                <th>{{ sc_language_render('order.admin.history_time') }}</th>
              </tr>
            @foreach ($order->history->sortKeysDesc()->all() as $history)
              <tr>
                <td>{{ \SCart\Core\Admin\Models\AdminUser::find($history['admin_id'])->name??'' }}</td>
                <td><div class="history">{!! $history['content'] !!}</div></td>
                <td>{{ $history['add_date'] }}</td>
              </tr>
            @endforeach
            </table>
          @endif
          </div>
          <!-- /.table-responsive -->
        </div>
        </div>
</div>