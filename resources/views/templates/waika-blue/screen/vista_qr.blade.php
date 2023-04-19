<!doctype html>

<html lang="es" class="h-100">

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700%7CLato%7CKalam:300,400,700">
    <link rel="canonical" href="{{ request()->url() }}" />
    <meta name="description" content="{{ $description??sc_store('description') }}">
    <meta name="keyword" content="{{ $keyword??sc_store('keyword') }}">
    <title>{{$title??sc_store('title')}}</title>
    <link rel="icon" href="{{ sc_file(sc_store('icon', null, 'images/icon.png')) }}" type="image/png" sizes="16x16">
    <meta property="og:image" content="{{ !empty($og_image)?sc_file($og_image):sc_file('images/org.jpg') }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title??sc_store('title') }}" />
    <meta property="og:description" content="{{ $description??sc_store('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-21RHXF116X"></script>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-21RHXF116X');
</script>

<link rel="shortcut icon" type="image/x-icon" href="{{ sc_file($sc_templateFile.'/images/leaf.svg')}}">



 <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/bootstrap.css')}}"> 
 <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/main.css')}}"> 
  <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/main3.css')}}">
  <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/main5.css')}}">
  <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/switch.css')}}">  
  <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/animate.css')}}"> 
  <link rel="stylesheet" href="{{ sc_file($sc_templateFile.'/css/all.min.css')}}">  
  <style type="text/css" id="operaUserStyle"></style>

<style>
	.teal{
		color: #00b5ad !important;
		font-size: 48px;
	}

	.olive {
    color: #b5cc18 !important;
}


</style>


   
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
    @stack('styles')


</head>

<body class="d-flex flex-column h-100">
	<div id="page">

		<div class="wrapper">

			


			<div id="bodywrapper" class="container-fluid showhidetoggle">




				<div class="content">
					<div class="container-fluid">
						<div class="content" id="tableContent">
							<div class="head mt-5 text-center">
								<h2 class="mb-0">Historial de pagos</h2>
								
							</div>
							<div class="canvas-wrapper">
								<table class="table no-margin" id="finTable">
									<thead class="success">
										<tr>
											<th>N° de Convenio</th>
											<th>Fecha Emision</th>
											<th>Actual</th>
											<th>Variance</th>
											
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Jacob Jensen</td>
											<td>85%</td>
											<td>32,435</td>
											<td>40,234</td>
											
										</tr>
										
									
									</tbody>
								</table>
							</div>
						</div>


						<div class="row mb-4 ">
							
							<div class="col-sm-6 col-md-6 col-lg-3">
								<div class="card card-rounded">
									<div class="content">
										<div class="row">
											<div class="col-sm-4">
												<div class="icon-big text-center">
													<i class="teal data-feather-big" stroke-width="3"
														data-feather="shopping-cart"></i>
												</div>
											</div>
											<div class="col-sm-8">
												<div class="detail">
													<p class="detail-subtitle">Producto</p>
													
												</div>
											</div>
										</div>
										<div class="footer">
											<hr />
											<div class=" text-center box-font-small">
												<span class="detail-subtitle  ">nombre producto</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-3">
								<div class="card card-rounded">
									<div class="content">
										<div class="row">
											<div class="col-sm-4">
												<div class="icon-big text-center">
													<i class="olive data-feather-big" stroke-width="3"
														data-feather="dollar-sign"></i>
												</div>
											</div>
											<div class="col-sm-8">
												<div class="detail">
													<p class="detail-subtitle">Total pagado</p>
													
												</div>
											</div>
										</div>
										<div class="footer">
											<hr />
											<div class="text-center box-font-small">
												<span class="number">$880,900</span>
											</div>
										</div>
									</div>
								</div>
							</div>
					
							

						</div>


						<div class="row">
							
							<div class="col-sm-6 col-md-6 col-lg-3">
								<div class="card card-rounded">
									<div class="content">
										<div class="row">
											<div class="col-sm-4">
												<div class="icon-big text-center">
													<i class="olive data-feather-big" stroke-width="3"
														data-feather="dollar-sign"></i>
												</div>
											</div>
											<div class="col-sm-8">
												<div class="detail">
													<p class="detail-subtitle">Total adeudado</p>
													
												</div>
											</div>
										</div>
										<div class="footer">
											<hr />
											<div class="text-center box-font-small">
												<span class="number">$880,900</span>
											</div>
										</div>
									</div>
								</div>
							</div>
					
							<div class="col-sm-6 col-md-6 col-lg-3">
								<div class="card card-rounded">
									<div class="content">
										<div class="row">
											<div class="col-sm-4">
												<div class="icon-big text-center">
													<i class="olive data-feather-big" stroke-width="3"
														data-feather="dollar-sign"></i>
												</div>
											</div>
											<div class="col-sm-8">
												<div class="detail">
													<p class="detail-subtitle">Cuotas Pendientes</p>
													
												</div>
											</div>
										</div>
										<div class="footer">
											<hr />
											<div class="text-center box-font-small">
												<span class="number">$880,900</span>
											</div>
										</div>
									</div>
								</div>
							</div>
					
							

						</div>

						

						


					</div>

				</div>

				<table  class="table table-hover box-body text-wrap table-bordered">
				
					<tr><td class="text-center text-uppercase" colspan="6"> <h4 >
							Fecha máxima de Entrega <hr>
							Miércoles 19 de Abril del 2023
						</h4>
						<span>La fecha de entrega puede ser modificada si el Beneficiario no realiza los pagos puntualmente (fecha de pago o día siguiente).</span>
						   
					</td></tr></tbody>
	
				</table>

			</div>

		</div>
	</div>
	<footer class="footer container mt-auto py-1">
		<div>
			
		</div>
	</footer>
	

	<button class="btn btn-sm btn-primary rounded-circle"
		onclick="scrollToTopFunction()" id="scrollToTop" title="Scroll to top">
		<i data-feather="arrow-up-circle"></i>
	</button>
	<script src="{{ asset('assets/js/feather.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/js/Chart.min.js') }}"></script>
	<script src="{{ asset('assets/js/script.js') }}"></script>


	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function(event) {
			feather.replace();
		});
	</script>
	<script type="text/javascript">
		var trafficchart = document.getElementById("trafficflow");
		var saleschart = document.getElementById("sales");

		var myChart1 = new Chart(trafficchart, {
			type : 'line',
			data : {
				labels : [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
						'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
				datasets : [ {
					backgroundColor : "rgba(48, 164, 255, 0.5)",
					borderColor : "rgba(48, 164, 255, 0.8)",
					data : [ '1135', '1135', '1140', '1168', '1150', '1145',
							'1155', '1155', '1150', '1160', '1185', '1190' ],
					label : '',
					fill : true
				} ]
			},
			options : {
				responsive : true,
				title : {
					display : false,
					text : 'Chart'
				},
				legend : {
					position : 'top',
					display : false,
				},
				tooltips : {
					mode : 'index',
					intersect : false,
				},
				hover : {
					mode : 'nearest',
					intersect : true
				},
				scales : {
					xAxes : [ {
						display : true,
						scaleLabel : {
							display : true,
							labelString : 'Months'
						}
					} ],
					yAxes : [ {
						display : true,
						scaleLabel : {
							display : true,
							labelString : 'Number of Visitors'
						}
					} ]
				}
			}
		});

		var myChart2 = new Chart(saleschart, {
			type : 'bar',
			data : {
				labels : [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
						'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
				datasets : [ {
					label : 'Income',
					backgroundColor : "rgba(76, 175, 80, 0.5)",
					borderColor : "#6da252",
					borderWidth : 1,
					data : [ "280", "300", "400", "600", "450", "400", "500",
							"550", "450", "650", "950", "1000" ],
				} ]
			},
			options : {
				responsive : true,
				title : {
					display : false,
					text : 'Chart'
				},
				legend : {
					position : 'top',
					display : false,
				},
				tooltips : {
					mode : 'index',
					intersect : false,
				},
				hover : {
					mode : 'nearest',
					intersect : true
				},
				scales : {
					xAxes : [ {
						display : true,
						scaleLabel : {
							display : true,
							labelString : 'Months'
						}
					} ],
					yAxes : [ {
						display : true,
						scaleLabel : {
							display : true,
							labelString : 'Number of Users'
						}
					} ]
				}
			}
		});
	</script>
	<!-- jQuery -->


<script src="{{ asset('assets/js/jspdf.min.js') }}"></script>

	

	<script>
		function showTableData() {
			var oTable = document.getElementById('finTable');
			var rowLength = oTable.rows.length;
			for (i = 0; i < rowLength; i++) {
				var oCells = oTable.rows.item(i).cells;
				var cellLength = oCells.length;
				for (var j = 0; j < cellLength; j++) {
					var cellVal = oCells.item(j).innerHTML;
					//alert(cellVal);
				}
			}
		}
	</script>

	
</body>

</html>