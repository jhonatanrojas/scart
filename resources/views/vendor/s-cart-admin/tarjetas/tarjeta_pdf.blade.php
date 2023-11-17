<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tarjetas de Crédito</title>


<style>
  @font-face {
    font-family: 'Poppins';
    src: url({{asset('/fonts/Poppins-Regular.ttf')}}) format('truetype');
    font-weight: normal;
    font-style: normal;
}

  body {
    font-family: 'Poppins', sans-serif;
    font-weight:100;
  }
  .card-container {
    position: relative;
    width: 100%;
    height: 100vh;
    page-break-after: always;
  }
  .card-image {
    position: absolute;
    width: 100%;

    z-index: 1;
  }
  .card-info {
    font-weight: 200; 
    position: absolute;
    top: 60%; /* Ajusta estos valores según necesites */
    left: 30%;
    transform: translate(-50%, -50%);
    z-index: 2;
        color: white; /* Cambia el color del texto si es necesario */
    text-align: center;
  }

  .card-info2 {
    font-weight: 200;
    position: absolute;
    top: 50%; /* Ajusta estos valores según necesites */
    left: 60%;
    transform: translate(-50%, -50%);
    z-index: 2;
        color:#949191; /* Cambia el color del texto si es necesario */
    text-align: center;
  
    font-size: 3rem;
  }
  .nro-tarjeta{
    font-size: 3rem;
  }
  .vencimiento{

    font-size: 2rem;
  
  }
  .nombre-tarjeta{
    font-size: 1.5rem;
  }
  @media print {
    .no-print {
      display: none;
    }
    .card-container {
      page-break-after: always;
    }
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
    <br>
    <p class="vencimiento">{!!   date('m-Y',strtotime($datosTarjeta->fecha_de_vencimiento)) !!}</p>
    <p class="nombre-tarjeta">{{ $datosTarjeta->first_name}}  {{ $datosTarjeta->last_name}}</p>
  </div>
</div>


<div class="card-container">
  <img src="{{ public_path('qrcodes/qr-code.png') }}" alt="Código QR">

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

<script>
  // Aquí puedes agregar cualquier script de JavaScript que necesites
</script>

</body>
</html>
