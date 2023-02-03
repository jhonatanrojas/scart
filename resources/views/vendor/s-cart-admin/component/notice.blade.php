
@php
$orderNew = \App\Models\AdminOrder::getCountOrderNew()

@endphp

<li class="nav-item dropdown">
  <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge">{{ $orderNew['total_ordenes'] }}</span>
  </a>
  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-item dropdown-header">{{ sc_language_render('admin.notice_new_order',['total'=> $orderNew['total_ordenes']]) }}</span>
    <div class="dropdown-divider"></div>
      <a href="{{ sc_route_admin('admin_order.index') }}?order_status=1" class="dropdown-item dropdown-footer">{{ sc_language_render('action.view_more') }}</a>
  </div>
  </li>
  
  {{-- @if (!$orderNew['total_pagados'] == 0)
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell "></i>
      <span class="badge badge-warning navbar-badge">{!! $orderNew['total_pagados']  ??  '0' !!}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">Tienes {!! $orderNew['total_pagados']  ??  '0' !!}  pago nuevo pendiente </span>
      <div class="dropdown-divider"></div>
        <a href="{{ sc_route_admin('historial_pagos.index') }}?sort_order=2" class="dropdown-item dropdown-footer">{{ sc_language_render('action.view_more') }}</a>
    </div>
    </li>
  @endif --}}

  {{-- @if (!$orderNew['Pago_relizado'] == 0)
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell "></i>
      <span class="badge badge-warning navbar-badge">{!! $orderNew['Pago_relizado']  ?? '0'!!}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">Tienes {!! $orderNew['Pago_relizado']  ?? '0'!!}  pago realizado hoy </span>
      <div class="dropdown-divider"></div>
        <a href="{{ sc_route_admin('historial_pagos.index') }}?sort_order=6" class="dropdown-item dropdown-footer">{{ sc_language_render('action.view_more') }}</a>
    </div>
    </li>
      
  @endif
   --}}
    
    @if (!$orderNew['fecha_vencimineto'] == 0)
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell "></i>
        <span class="badge badge-warning navbar-badge">{!!$orderNew['fecha_vencimineto'] ?? '0'!!}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">Tienes {!!$orderNew['fecha_vencimineto'] ?? '0'!!}  pago vencido </span>
        <div class="dropdown-divider"></div>
          <a href="{{ sc_route_admin('historial_pagos.index') }}?sort_order=4" class="dropdown-item dropdown-footer">{{ sc_language_render('action.view_more') }}</a>
      </div>
      </li>
    @endif
      


