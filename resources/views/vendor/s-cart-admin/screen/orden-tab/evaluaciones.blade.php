<div class="card">
    <div class="card-body">
        {{-- evaluacion --}}
        <div class="col-sm-12">
            <div class="card">


                @if ($order->modalidad_de_compra >= 1)
                    <table class="table table-hover box-body text-wrap table-bordered">
                        <tr>
                            <td>Evaluación</td>
                            <td>Observación</td>
                            <td>Porcentaje</td>
                            <td>Confiabilidad</td>
                        </tr>
                        <tr>

                       
                            <td class="td-title"><span>Evaluación comercial</span></td>
                            <td>
                                <a href="#" class="updateInfo" data-name="nota_evaluacion_comercial "
                                    data-type="textarea" data-pk="{{ $order->id }}"
                                    data-url="{{ route('admin_order.update') }}" data-title="Nota">
                                    @if (!empty($order->nota_evaluacion_comercial))
                                        {{ $order->nota_evaluacion_comercial }}
                                    @endif
                                </a>
                            </td>
                             
                            <td>
                           

                                <a href="#" class="updateInfo" data-name="evaluacion_comercial "
                                    data-type="number" data-pk="{{ $order->id }}"
                                    data-url="{{ route('admin_order.update') }}" data-title="Nota">
                                    @if (!empty($order->evaluacion_comercial))
                                        {{ $order->evaluacion_comercial }}
                                    @endif
                                </a>

                            </td>
                            

                            <td>


                                <a href="#" class="updateInfo" data-name="confiabilidad " data-type="number"
                                    data-pk="{{ $order->id }}" data-url="{{ route('admin_order.update') }}"
                                    data-title="Confiabilidad">
                                    @if (!empty($order->confiabilidad))
                                        {{ $order->confiabilidad }}
                                    @endif
                                </a>

                            </td>
                             @endif
                        </tr>

                        {{-- Evaluacion_comercial --}}


                        {{-- nota_evaluacion_financiera --}}

                        <tr>

                       
                        
                            <td class="td-title"><span> Evaluación legal y financiera</span></td>
                            <td>
                                <a href="#" class="updateInfo" data-name="nota_evaluacion_financiera "
                                    data-type="textarea" data-pk="{{ $order->id }}"
                                    data-url="{{ route('admin_order.update') }}" data-title="Nota F">

                                    @if (!empty($order->nota_evaluacion_financiera))
                                        {{ $order->nota_evaluacion_financiera }}
                                    @endif
                                </a>
                            </td>
                            <td>

                                <a href="#" class="updateInfo" data-name="evaluacion_financiera "
                                    data-type="number" data-pk="{{ $order->id }}"
                                    data-url="{{ route('admin_order.update') }}" data-title="Nota">
                                    @if (!empty($order->evaluacion_financiera))
                                        {{ $order->evaluacion_financiera }}
                                    @endif
                                </a>

                            </td>
                            <td>



                                <a href="#" class="updateInfo" data-name="confiabilidad2 " data-type="number"
                                    data-pk="{{ $order->id }}" data-url="{{ route('admin_order.update') }}"
                                    data-title="Confiabilidad">
                                    @if (!empty($order->confiabilidad2))
                                        {{ $order->confiabilidad2 }}
                                    @endif
                                </a>
                            </td>

                          
                        </tr>
                        {{-- nota_evaluacion_financiera --}}

                       





                        <tr>
                            <td class="td-title"><span>Decisión final</span></td>
                            <td>
                                <a href="#" class="updateInfo" data-name="nota_decision_final "
                                    data-type="textarea" data-pk="{{ $order->id }}"
                                    data-url="{{ route('admin_order.update') }}" data-title="Nota">
                                    @if (!empty($order->nota_decision_final))
                                        {{ $order->nota_decision_final }}
                                    @endif
                                </a>
                            </td>
                            <td>


                                <select id="decision_final" onChange="selectProduct2($(this));"
                                    class="decision_final form-control select2 " name="decision_final">
                                    <option value="0" {{ $order['decision_final'] == 0 ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="1" {{ $order['decision_final'] == 1 ? 'selected' : '' }}>Negado
                                    </option>
                                    <option value="2" {{ $order['decision_final'] == 2 ? 'selected' : '' }}>
                                        Aprobado
                                    </option>
                                    <option value="3" {{ $order['decision_final'] == 3 ? 'selected' : '' }}>
                                        Diferido
                                    </option>
                                    <option value="3" {{ $order['decision_final'] > 3 ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                            </td>
                            
                        </tr>
                    </table>

                



            </div>



        </div>
        {{-- //End evaluacion --}}
    </div>

</div>
