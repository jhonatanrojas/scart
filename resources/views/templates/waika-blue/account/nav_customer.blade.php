<ul class="list-group list-group-flush member-nav">
    <li class="list-group-item">
        <a href="{{ sc_route('customer.change_password') }}"><i class="fa fa-key" aria-hidden="true"></i> {{ sc_language_render('customer.change_password') }}</a></li>
    <li class="list-group-item">
        <a href="{{ sc_route('customer.change_infomation') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> {{ sc_language_render('customer.change_infomation') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ sc_route('customer.address_list') }}"><i class="fa fa-id-card-o" aria-hidden="true"></i> {{ sc_language_render('customer.address_list') }}</a>
    </li>
    <li class="list-group-item">
        <a href="{{ sc_route('customer.historial_pagos') }}"><i class="fa fa-credit-card" aria-hidden="true"></i> Historial de pagos</a>
    </li>
    <li class="list-group-item">
        <a href="{{ sc_route('customer.order_list') }}"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> {{ sc_language_render('customer.order_history') }}</a>
    </li>
    <li class="list-group-item">
        <a href="{{route('adjuntar_document')}}"><i class="fa fa-list-alt" aria-hidden="true"></i>Adjuntar documentos </a>
    </li>
</ul>