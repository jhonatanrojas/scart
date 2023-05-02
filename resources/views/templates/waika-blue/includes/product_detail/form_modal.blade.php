<!-- Modal -->

<style>
    #overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  background-color: transparent;
  pointer-events: none;
}



    </style>
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ sc_route('cart.add') }}" method="POST">
            {{ csrf_field() }}
            <div class="modal-header ">
                <h3 class="modal-title fs-5">{{ sc_language_render('customer.title_caculadora') }}</h3>

                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-md-flex justify-content-between align-items-center">
                    <img class="" src="{{ sc_file(sc_store('logo', ($storeId ?? null))) }}" alt="logo" width="100" height="100"/>

                    <span class="  text-uppercase fs-6 ">{{$product->name}}</span>
                    <div class="form__checkbox">

                        @if ( $product->cuotas_inmediatas > 0)
                         <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_venta" id="tipo_venta" value="2">
                            <label class="form-check-label" for="tipo_venta">
                                {{sc_language_render('customer.title_ENTREGA INMEDIATA')}}
                            </label>
                        </div>
                            
                        @endif
                       
                       
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
                            <div id="overlay"></div>

                            <select required class="form-select"  name="inicial" id="inicial">
                               
                                <option value="{!! $product->monto_inicial == 0 ? $inicial_default :$product->monto_inicial !!}" {!! $product->monto_inicial>0 ? 'selected':0   !!}>SI</option>
                              @if( $product->monto_inicial ==0)
                                <option value="0" selected>NO</option>
                                @endif
                            </select>

                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label text-uppercase"  for="monto">Monto de la Inicial $:</label>
                            <input readonly id="monto_Inicial"  value="{!! $product->monto_inicial !!}" class="form-control" type="text"  placeholder="">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label text-uppercase" for="inicial"> Nro de Cuotas</label>
                            <input readonly class="form-control" type="text"  id="m_nro_cuotas" value="{{$product->nro_coutas}}">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label text-uppercase" for="monto_de_la_cuota">Monto de la cuota$</label>
                            @php
                            $product->price=$product->price- $product->monto_cuota_entrega;
                            @endphp
                            <input id="monto_de_la_cuota" disabled class="form-control" type="text" value="{!!number_format($product->price /$product->nro_coutas ,'2') !!}">
                        </div>

                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                            <label class="form-label text-uppercase"  for="periodo">frecuencia de pago</label>
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
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="text-uppercase" for="">Monto cuota de entrega $</label>
                                <input class="form-control" type="text" value="{{$product->monto_cuota_entrega}}" disabled >
                            </div>
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