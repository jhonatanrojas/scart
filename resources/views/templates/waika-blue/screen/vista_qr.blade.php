
@extends($sc_templatePath.'.layout')

@section('block_main')

<style>
	.baner{
		width: 100%;
		height: 100px;
		background-image: url('/images/historial.png');
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		
	}
</style>
	<div class="container mt-4 mb-4">

	<div class="card">
		<div class="car-body p-2">
		<div class="baner">
			

		</div>

			<div class="card-header">
				
			</div>
			<div class="row justify-content-center align-items-center">
				<div class="col-12 col-md-12">
	
			
		                         
					<div class="row">
						
						<div class="col-12 col-sm-12 col-md-6 animate__animated animate__backInLeft">
							
							<table class="table box table-bordered  table-striped table-hover" id="showTotal">
								<tbody>
									<tr>
									<th>Nombre:
									</th><td>{{$cliente}}
									</td>
								</tr>

								<tbody>
									<tr>
									<th>Vendedor Asignado:
									</th><td>{{$vendedor}}
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
						
		
						<div class="col-12 col-sm-12 col-md-6 animate__animated animate__fadeInUp">
															 
							
						
		
		
							<div class="row ">
								<div class="col-md-12 ">
									<table class="table box table-bordered" id="">
																																								<tbody><tr class="showTotal table-success">
													<th class="animate__animated animate__flipInX animate__delay-1s">Total Pagado:</th>
													<td style="text-align: right" id="subtotal">
														${{$total_monto_pagado}}
													</td>
												</tr>
																																																																																																																																		<tr class="showTotal table-danger" >
											<th class="animate__animated animate__flipInX animate__delay-2s" >Por Pagar:</th>
													<td style="text-align: right" id="total">
														${{round($totalPor_pagar)}}
													</td>
												</tr>


												<tr class="showTotal " style="background:#f5f3f3;font-weight: bold;">
											<th class="animate__animated animate__flipInX animate__delay-3s">Cuotas Pendientes</th>
													<td style="text-align: right" id="total">
														{{$Cuotas_Pendientes}}
													</td>
												</tr>


												<tr class="showTotal " style="background:#f5f3f3;font-weight: bold;">
													<th class="animate__animated animate__flipInX animate__delay-4s">Monto de la Proxima Cuota:</th>
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
