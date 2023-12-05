<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rifa</title>


<style>
 @page {
         
            font-family: Arial;
        }

  body {
    font-family: 'Poppins', sans-serif;
    font-weight:100;
    margin: 100px;
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
    top: 50%; /* Ajusta estos valores según necesites */
    left: 30%;
    transform: translate(-40%, -50%);
    z-index: 2;
        color: white; /* Cambia el color del texto si es necesario */
    text-align: center;
  }


  .nro-tarjeta{
    font-size: 5rem;
    text-align:center;

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
    top: 40%; /* Ajusta estos valores según necesites */
    left:  4%;
    width: 200px;
    
  } 
  .nombre-cliente{
    padding-left:400px;

    text-align: center;
  }
  .numero-rifa{
    padding-left:400px;

text-align: center;
font-size: 2.8rem;


  }
  .solteo-rifa{
    font-size: 1.4rem;

    padding-left:50px;
    margin-left: 20px;
  }
  .premio{
    width: 300px;
    padding-left:250px;
    text-align:left;
    padding-top: -100px;
  }
  .solteo-premio{
  
    margin-top: -5px;
    font-size: 1.4rem;
  }
</style>
</head>
<body> 



<div class="card-container">
    <img class="qr-imagen"   src="{{ asset('qrcodes/qr-code.png') }}" alt="Código QR"> 
  <img src="{{ asset($dataRifa->imagen_rifa) }}" alt="Tarjeta Premium" class="card-image">




  <div class="card-info">
    <h1 class="nombre-cliente"> {{ strtoupper($rifaCliente->nombre_cliente)}} </h1>
    <h1 class="nombre-cliente"> C.I:{{ strtoupper($rifaCliente->cedula)}} </h1>
    <?php
  $relleno = "0";
    $numero =str_pad($rifaCliente->numero_rifa, 3, $relleno, STR_PAD_LEFT);
    ?>
    <h1 class="numero-rifa">NUMERO {{ strtoupper( $numero )}} </h1>

    <h3 class="solteo-rifa">SORTEO {{ strtoupper( $dataRifa->lugar_solteo )}} </h3>
    <h3 class="solteo-rifa">FECHA {{  date('d/m/Y', strtotime($dataRifa->fecha_solteo)) }} </h3>
    <div class="premio"> 
        <h3 class="solteo-premio" >PREMIO {{ strtoupper($dataRifa->premio)}}  </h3>

    </div>

  </div>
</div>



</body>
</html>
