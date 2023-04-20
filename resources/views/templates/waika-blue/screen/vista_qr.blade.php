
@extends($sc_templatePath.'.layout')

@section('block_main')

	<div class="container mt-4 mb-4">

	<div class="card">
		<div class="car-body">

			<h3 class="control-label"><i class="fa fa-truck" aria-hidden="true"></i>
				Historial del pago:<br></h3>
			<div class="row justify-content-center align-items-center">
				<div class="col-12 col-md-12">
	
			
		                         
					<div class="row">
						
						<div class="col-12 col-sm-12 col-md-6">
							
							<table class="table box table-bordered" id="showTotal">
								<tbody><tr>
									<th>Nombre:
									</th><td>{{$cliente}}
									</td>
								</tr>
								
																			<tr>
										<th>Fecha de emisión:
										</th><td>{{$fecha_pago}}</td>
									</tr>
																		<tr>
									<th>Número de convenio:
									</th><td>{{$nro_convenio}}</td>
								</tr>
								<tr>
									<th>Número Solicitud:
									</th><td>
										{{$id_solicitud}}
									</td>
								</tr>
							</tbody></table>
						</div>
						
		
						<div class="col-12 col-sm-12 col-md-6 ">
															 
							
						
		
		
							<div class="row ">
								<div class="col-md-12">
									<table class="table box table-bordered" id="">
																																					<tbody><tr class="showTotal">
													<th>Monto Pagado</th>
													<td style="text-align: right" id="subtotal">
														${{$total_monto_pagado}}
													</td>
												</tr>
																																																																																																																																		<tr class="showTotal " style="background:#f5f3f3;font-weight: bold;">
											<th>Monto Pendiente</th>
													<td style="text-align: right" id="total">
														${{$totalPor_pagar}}
													</td>
												</tr>


												<tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
											<th>Cuotas Pendientes</th>
													<td style="text-align: right" id="total">
														{{$Cuotas_Pendientes}}
													</td>
												</tr>


												<tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
													<th>Monto de la Proxima Cuota</th>
															<td style="text-align: right" id="total">
																${{$order}}
															</td>
														</tr>

												
																																				</tbody></table>
		
									
								</div>
							</div>
							
																
							
							
		
						</div>
					</div>
		
			</div>
			</div>
		</div>
	</div>

	</div>

@endsection

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush
