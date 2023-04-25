<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ sc_route('cart.add') }}" method="POST">
            {{ csrf_field() }}
            <div class="modal-header">
                <h3 class="modal-title fs-5">{{ sc_language_render('customer.title_caculadora') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-md-flex justify-content-between align-items-center">
                    <img class="" src="{{ sc_file(sc_store('logo', ($storeId ?? null))) }}" alt="logo" width="100" height="30"/>
                    <div class="form__checkbox">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_venta" id="tipo_venta" value="2">
                            <label class="form-check-label" for="tipo_venta">
                                {{sc_language_render('customer.title_ENTREGA INMEDIATA')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_venta" id="tipo_venta2" checked value="1">
                            <label class="form-check-label" for="tipo_venta2">
                                {{sc_language_render('customer.title_ENTREGA PROGRAMADA')}}
                            </label>
                        </div>
                    </div>
                </div>

                <div name="frmPrestamo" id="frmPrestamo">
                    <div class="p-0 mt-0 m-0"></div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label text-uppercase" for="inicial">CON INICIAL</label>
                            <select required class="form-select"  name="inicial" id="inicial">
                                <option value="">Seleccione una opcion</option>
                                <option value="30">SI</option>
                                <option value="0">NO</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label text-uppercase"  for="monto">Monto de la Inicial$:</label>
                            <input readonly id="monto_Inicial"  value="" class="form-control" type="text"  id="" placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label text-uppercase" for="inicial">Cuotas</label>
                            <input readonly class="form-control" type="text"  id="m_nro_cuotas" value="{{$product->nro_coutas}}">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label text-uppercase" for="monto_de_la_cuota">Monto de la Cuota$</label>
                            <input id="monto_de_la_cuota" readonly class="form-control" type="text" value="{!!number_format($product->price /$product->nro_coutas ,'2') !!}">
                        </div>

                        <div class="mb-3 col-md-12">
                            <div class="form-group">
                            <label class="form-label text-uppercase"  for="periodo">frecuancia de pago</label>
                                @foreach($modalida_pago as $key => $pagos)
                                @if($product->id_modalidad_pagos == $pagos->id)
                                    @if($product->id_modalidad_pagos == $pagos->id )
                                    <input data-valor={{$pagos->id}}  id="modalidad" readonly la value="{{$pagos->name ?? 'si modalidad de pago'}}" class="form-control  modalidad_pago" type="text" name="modalidad_pago"   >
                                    @endif
                                @endif
                                @endforeach
                            </div>
                            <input id="Cuotas" type="hidden" value="{{$product->nro_coutas}}" name="Cuotas" >
                            <input id="cuotas_inmediatas" type="hidden" value="{{$product->cuotas_inmediatas}}" name="cuotas_inmediatas" >
                            <input  readonly value="{{$product->price}}" class="form-control   " type="hidden" name="monto" id="monto" placeholder="monto">
                            <input type="hidden" value="@php echo date('Y-m-d')  @endphp" name="fecha" id="fecha" placeholder="fecha">
                        </div>                      
                    </div>
                </div>

                <div class="" id="mensaje"></div>

                <input  name="product_id" type="hidden" id="product-detail-id" value="{{ $product->id }}" />
                <input  name="storeId" type="hidden" id="product-detail-storeId" value="{{ $product->store_id }}" />
                <input  name="qty" type="hidden"  value="1" min="1" max="100">
                <input  name="financiamiento" type="hidden"  value="1" id="financiamiento" />
                <input type="hidden" name="financiamineto" value="1"  >
            </div>
            <div class="modal-footer">
                <button type="submit" id="butto_modal" class="btn btn-themes rounded-pill pedido">{{sc_language_render('customer.c_solicitud')}}</button>
            </div>
        </form>
      </div>
    </div>
</div>