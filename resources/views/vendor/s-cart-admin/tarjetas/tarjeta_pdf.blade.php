<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tarjetas de Crédito</title>


<style>
 @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

  body {
    margin: 0cm;
    font-family: 'Poppins', sans-serif;
    font-weight:100;
  }
  .page-break {
    page-break-after: always;
}

  .card-container {
    position: relative;
    width: 100%;
    height: 100vh;

  }
  .card-image {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 1;
  }
  .card-info {
    font-weight: 200; 
    position: absolute;
    top: 70%; /* Ajusta estos valores según necesites */
    left: 30%;
    transform: translate(-40%, -50%);
    z-index: 2;
        color: white; /* Cambia el color del texto si es necesario */
    text-align: center;
  }

  .card-info2 {
    font-weight: 200;
    position: absolute;
    top: 55%; /* Ajusta estos valores según necesites */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
        color:#949191; /* Cambia el color del texto si es necesario */
    text-align: center;
  
    font-size: 3.5rem;
  }
  .nro-tarjeta{
    font-size: 5rem;
    text-align:center;

  }
  .vencimiento{

    font-size: 2.5rem;
    text-align:left;
    padding-left: 15%;
    padding-top:10%
  
  }
  .nombre-tarjeta{
    font-size: 2.8rem;
    font-weight:600; 
  }

  @media print {
    .no-print {
      display: none;
    }
    .card-container {
      page-break-after: always;
    }
  }
  .qr-imagen{
    z-index: 2;
    position: absolute;
    top: 5%; /* Ajusta estos valores según necesites */
    right: 40%;
    width: 300px;
    opacity: .8;
  } 
</style>
</head>
<body>



<div class="card-container">

  @if( $datosTarjeta->tipo_tarjeta_id==3)
  <img src="{{ asset('images/tarjeta-premiun.png') }}" alt="Tarjeta Premium" class="card-image">
  @endif

  @if( $datosTarjeta->tipo_tarjeta_id==2)
  <img src="{{ asset('images/tarjetaplata1.png') }}" alt="Tarjeta" class="card-image">
  @endif
  
  @if( $datosTarjeta->tipo_tarjeta_id==1)
  <img src="{{ asset('images/tarjetaoro.png') }}" alt="Tarjeta" class="card-image">
  @endif

  <div class="card-info">
    <p class="nro-tarjeta">{{ separarCadena($datosTarjeta->nro_tarjeta)}}</p>

    <p class="vencimiento">{!!   date('m-Y',strtotime($datosTarjeta->fecha_de_vencimiento)) !!}</p> 
    <p class="nombre-tarjeta">{{ substr($datosTarjeta->first_name." ".$datosTarjeta->last_name,0,30)}}</p>
  </div>
</div>

<div class="page-break"></div>
<div class="card-container">
  <img class="qr-imagen"   src="{{ asset('qrcodes/qr-code.png') }}" alt="Código QR"> 

  @if( $datosTarjeta->tipo_tarjeta_id==3)
  <img src="{{ asset('images/tarjeta-2.png') }}" alt="Tarjeta" class="card-image">
  @endif

  @if( $datosTarjeta->tipo_tarjeta_id==2)
  <img src="{{ asset('images/tarjeta-plata.png') }}" alt="Tarjeta" class="card-image">
  @endif
  
  @if( $datosTarjeta->tipo_tarjeta_id==1)
  <img src="{{ asset('images/tarjetaoro2.png') }}" alt="Tarjeta" class="card-image">
  @endif
  <div class="card-info2">
   
    <p>{{ $datosTarjeta->codigo_seguridad}}</p>
  </div>
</div>


</body>
</html>
