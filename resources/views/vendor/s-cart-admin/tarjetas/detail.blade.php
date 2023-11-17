@extends($templatePathAdmin . 'layout')

@section('main')
    <div class="row" id="order-body">
        <div class="col-sm-6">
            <table class="table table-bordered">



                <tr>
                    <td> Numero de tarjeta</td>
                    <td>
                        {{ $order->nro_tarjeta }}

                    </td>
                </tr>
                
                <tr>
                    <td> Vence</td>
                    <td>
                        {{ $order->fecha_de_vencimiento }}

                    </td>
                </tr>
                <tr>
                    <td> Codigo de Seguridad</td>
                    <td>
                        {{ $order->codigo_seguridad }}

                    </td>
                </tr>
                <tr>
                    <td> Total limite $</td>
                    <td>
                        {{ $totalLimite}}

                    </td>
                </tr>
                <tr>
                    <td> Total Saldo $</td>
                    <td>
                        {{ $totalTransaccion }}

                    </td>
                </tr>



                <tr>
                    <td></i> {{ sc_language_render('admin.created_at') }}:</td>
                    <td>{{ $order->created_at }}</td>
                </tr>

            </table>
        </div>
        <div class="col-sm-6">
            <table class="table table-hover box-body text-wrap table-bordered">
                <tr>
                    <td class="td-title">{{ sc_language_render('order.first_name') }}:</td>
                    <td><a href="#" class="" data-name="first_name" data-type="text"
                            data-pk="{{ $order->id }}" data-url="{{ route('admin_order.update') }}"
                            data-title="{{ sc_language_render('order.first_name') }}">{!! $order->first_name !!}</a>
                    </td>
                </tr>

                @if (sc_config_admin('customer_lastname'))
                    <tr>
                        <td class="td-title">{{ sc_language_render('order.last_name') }}:</td>
                        <td><a href="#" class="" data-name="last_name" data-type="text"
                                data-pk="{{ $order->id }}" data-url="{{ route('admin_order.update') }}"
                                data-title="{{ sc_language_render('order.last_name') }}">{!! $order->last_name !!}</a>
                        </td>
                    </tr>
                @endif

                @if (sc_config_admin('customer_phone'))
                    <tr>
                        <td class="td-title">{{ sc_language_render('order.phone') }}:</td>
                        <td><a href="#" class="" data-name="phone" data-type="text"
                                data-pk="{{ $order->id }}" data-url="{{ route('admin_order.update') }}"
                                data-title="{{ sc_language_render('order.phone') }}">{!! $order->phone !!}</a>
                        </td>
                    </tr>
                @endif

                <tr>
                    <td class="td-title">{{ sc_language_render('order.email') }}:</td>
                    <td>{!! empty($order->email) ? 'N/A' : $order->email !!}</td>
                </tr>

                @if (sc_config_admin('customer_company'))
                    <tr>
                        <td class="td-title">{{ sc_language_render('order.company') }}:</td>
                        <td><a href="#" class="updateInfoRequired" data-name="company" data-type="text"
                                data-pk="{{ $order->id }}" data-url="{{ route('admin_order.update') }}"
                                data-title="{{ sc_language_render('order.company') }}">{!! $order->company !!}</a>
                        </td>
                    </tr>
                @endif









                <tr>
                    <td class="td-title">Ver documentos:</td>
                    <td>

                        @if (empty($documento))
                            El cliente no ha adjuntado Documentos <br>
                        @endif
                        <a target="_blank"
                            href="{{ sc_route_admin('admin_customer.document', ['id' => $order->customer_id ? $order->customer_id : 'not-found-id']) }}"
                            class="" data-name="address2">Ir a Documentos</a>
                    </td>


                </tr>
                <tr>

                    <td class="td-title">datos del cliente</td>
                    <td>

                        <a href="{{ sc_route_admin('admin_customer.edit', ['id' => $order->customer_id ? $order->customer_id : 'not-found-id']) }}"
                            class="" data-name="address2">Ver perfil del cliente</a>
                    </td>


                </tr>




                <tr>
                    <td class="td-title">Clasificación del cliente:</td>
                    <td>
                        @if (!empty($clasificacion))
                            {!! getBadgeHtml($clasificacion) !!}
                        @else
                            <span class="text-info">No ha
                                realizado el primer pago</span>
                        @endif
                    </td>


                </tr>
            </table>
        </div>



    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Limites</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Transacciones</button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ sc_route('tarjetas.pdf',[$id])}}">Descargar Tarjeta</a>
                  </li>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Monto</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>200</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>2023-11-15</td>
                            <td>100</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>2023-11-15</td>
                            <td>100</td>
                          </tr>
                        </tbody>
                      </table>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Monto</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>200</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>2023-11-15</td>
                            <td>100</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>2023-11-15</td>
                            <td>100</td>
                          </tr>
                        </tbody>
                      </table>
                </div>

              </div>
        </div>
    </div>
@endsection
