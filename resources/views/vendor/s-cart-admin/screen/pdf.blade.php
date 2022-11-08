<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->

    <title>Financiamiento</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;


        }
        .p{
            line-height: 10px;
        }
        .c19{
    
            text-align: center;
            display: flex;
            align-items: baseline;
            justify-content: space-evenly;
        }
       
        .container{
            /* padding: 30px; */
            width: 100%;
            /* border: solid red 1px; */
            margin: auto;

        }
        .c30{
            text-align: center;
            font-size: 20px;
            font-weight: 600;
        }
        .c2{
            font-weight: 600;
        }
        .c3{
            font-size: 15px;
            font-weight: 600;
            color: black
           
            
            
        }
        .c10{
            border-bottom: solid 1px rgb(2, 2, 2);
        }
        .c13,.c37{
            text-align: center;
            font-size: 20px;
            font-weight: 600;
        }
        .c5{
            

        }

        table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  color: #ffffff;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  /* padding: 8px; */
}

tr:nth-child(even) {
  background-color: #52749ea1;
}
        
    </style>
</head>
<body  >
    <div class="container">
        <div class="c19">
            <img src="" alt="logo">
            <p class="">
            <span class="c18 c36"> N° CONVENIO: </span>
        </p>
        </div>

        <p class="c30"><span class="c14">CONVENIO DE PAGO</span></p>
        <p class="c30"><span class="c10 c50">(</span><span class="c10 c58">Pagos Fraccionados para el Auto Financiamiento Colectivo)</span></p>
        <p class="c5 c24"><span class="c7 c18"></span></p>
        <p class="c5"><span class="c7">La Empresa </span><span class="c2">“WAIKA IMPORT C.A.”</span><span class="c7">, a través del presente Convenio acuerda establecer las condiciones del programa “</span><span class="c2 c10">Pagos Fraccionados para el Auto Financiamiento Colectivo”</span><span class="c7 c18">&nbsp;(P.F.A.F.C.), el cual será aplicado para la adquisición de electrodomésticos, maquinarias, consumibles, motocicletas y otros rubros. Dicho Convenio privado se regirá por las siguientes clausulas refrendadas por las partes suscritas en el presente documento:</span></p>  
        <p class="c5 c24"><span class="c7 c18"></span></p>
        <p class="c5"><span class="c2 c10">Clausula Primera:</span><span class="c7">&nbsp;En el presente documento se identifica a las partes como </span><span class="c2">“La Empresa”</span><span class="c7">&nbsp;a </span><span class="c2">WAIKA IMPORT C.A</span><span class="c7">. y </span><span class="c2">“Beneficiario”</span><span class="c7 c18">&nbsp;a la persona Natural ó Jurídica que establezca relación comercial con esta compañía en este Convenio. &nbsp;</span></p>
    
        <p class="c5"><span class="c2 c10">Clausula Segunda:</span><span class="c2">&nbsp;</span><span class="c7">Se entiende por Auto financiamiento las “Cuotas” en moneda de circulación legal que entrega quincenalmente </span><span class="c2">“EL BENEFICIARIO”</span><span class="c7">&nbsp;a </span><span class="c2">“LA EMPRESA”</span><span class="c7 c18">&nbsp;para la adquisición de electrodomésticos, maquinarias, consumibles, motocicletas y otros rubros ofertados según el catalogo disponible quincenalmente.</span></p>

        <p class="c5"><span class="c2 c10">Clausula Tercera:</span><span class="c7">&nbsp;</span><span class="c2">“El Beneficiario”</span><span class="c7">&nbsp;se compromete mediante el presente Convenio del programa de “</span><span class="c2">Pagos Fraccionados para el Auto Financiamiento Colectivo</span><span class="c7">”</span><span class="c2">&nbsp;</span><span class="c7">a pagar cuotas cada @if ($convenio->modalidad == "Mensual")
            treinta
            @else
            quinse
            @endif
            ({{$convenio->nro_coutas}}) días</span><span class="c2">&nbsp;</span><span class="c7">que representan mínimo el diez por ciento (10%) del monto total del precio del producto ofertado por </span><span class="c2">“WAIKA IMPORT C.A”</span><span class="c7">, en el transcurso de diez (10), quincenas continuas.</span></p>

        <p class="c5"><span class="c2 c10">Clausula Cuarta:</span><span class="c7">&nbsp;El presente acto entra en vigencia una vez que </span><span class="c2">“EL BENEFICIARIO”, </span><span class="c7">hace el pago correspondiente al 10% del valor del producto que auto financiara y firme las hojas del Convenio preestablecidas por </span><span class="c2">“LA EMPRESA”</span><span class="c7">.</span></p>

        <p class="c5"><span class="c2 c10">Clausula Quinta:</span><span class="c7">&nbsp;</span><span class="c2">“LA EMPRESA”</span><span class="c7 c18">&nbsp;mediante una serie de criterios internos establecerá la fecha de asignación del producto auto financiado. </span></p>


        <p class="c5"><span class="c2 c10">Clausula Sexta:</span><span class="c7">&nbsp;</span><span class="c2">“LA EMPRESA”</span><span class="c7">&nbsp;se compromete a entregar el producto a </span><span class="c2">“EL BENEFICIARIO”</span><span class="c7 c18">, luego del pago de la segunda cuota y antes de la séptima, teniendo hasta diez (10) días hábiles después de la fecha preestablecida en el Historial de Pago. </span></p>

        <p class="c5"><span class="c2 c10">Clausula Séptima:</span><span class="c7">&nbsp;En caso de que el producto acordado no se encuentre en existencia de </span><span class="c2">“La Empresa” </span><span class="c7">ni de sus proveedores, se procederá a informar a </span><span class="c2">“EL BENEFICIARIO”</span><span class="c7 c18">, dando a su elección dos opciones que permitan responder al requerimiento. </span></p>

        <p class="c5"><span class="c2">Parágrafo Único:</span><span class="c7">&nbsp;En primera opción: podrá elegir un producto de igual o superior capacidad y garantía en aras de cumplir con lo acordado. En segunda Opción: se realizará un adendum renovando los plazos de entrega del producto, ambas con el fin de garantizar un servicio óptimo a </span><span class="c2">“EL BENEFICIARIO”.</span></p>

        <p class="c5"><span class="c2 c10">Clausula Octava</span><span class="c2">&nbsp;“El Beneficiario”</span><span class="c7">&nbsp;deberá transferir la cuota establecida en moneda de curso legal según su equivalencia en dólares americanos, a la Cuenta Global Jurídica del Banco de Venezuela, </span><span class="c2">Nº 0102-0448-89-00-00149592 </span><span class="c7">a nombre de</span><span class="c2">&nbsp;“WAIKA IMPORT C.A”</span><span class="c7">, RIF. </span><span class="c2">J-50145053-6</span><span class="c7">.</span></p>

        <p class="c5"><span class="c2 c10">Clausula Novena:</span><span class="c2">&nbsp;“El Beneficiario”</span><span class="c7">&nbsp;deberá realizar el pago correspondiente en la fecha establecida en el presente convenio, sin embargo, dispondrá de cinco (05) días continuos para realizar el pago luego de la fecha establecida, siempre y cuando sea comprobado por “</span><span class="c2">LA EMPRESA”</span><span class="c7 c18">&nbsp;que el retardo fue por una causa de fuerza mayor, disponiendo de esta condición en solo dos (02) oportunidades durante el trascurso de las diez (10) quincenas.</span></p>

        <p class="c5"><span class="c2 c10">Clausula Decima:</span><span class="c7">&nbsp;Todos los productos de</span><span class="c2">&nbsp;“WAIKA IMPORT C.A” </span><span class="c7">poseen garantía, sin embargo</span><span class="c2">&nbsp;“El Beneficiario”</span><span class="c7">&nbsp;deberá revisar su producto antes de retirarlo, firmar conforme su nota de entrega en el lugar de recepción del artículo y permitiendo tomar fotografía durante este proceso la cual será publicada en redes sociales de la </span><span class="c2">“LA EMPRESA”</span><span class="c7">.</span></p>

        <p class="c5"><span class="c2 c10">Clausula Décima Primera:</span><span class="c7">&nbsp;En caso que el beneficiario, incumpla con el plazo máximo para el pago de una cuota deberá retornar el producto a </span><span class="c2">WAIKA IMPORT C.A</span><span class="c7">&nbsp;e inmediatamente y perderá el 40% de los pagos realizados a la fecha de mora y en caso de deterioro, robo u/o alguna otra desvalorización del producto, </span><span class="c2">“EL BENEFICIARIO”</span><span class="c7">&nbsp;perderá el total de las cuotas que haya pagado a la fecha, como forma de indemnización a los demás Beneficiarios, por lo que una vez cumplido el plazo establecido en la cláusula Novena del presente Convenio, se remitirá a Consultoría Jurídica de la Empresa para tomar las acciones legales pertinentes. </span></p>


        <p class="c5"><span class="c2 c10">Clausula Décima Segunda:</span><span class="c7">&nbsp;</span><span class="c2">“LA EMPRESA”</span><span class="c7">&nbsp;podrá exigir a </span><span class="c2">“EL BENEFICIARIO”</span><span class="c7 c18">&nbsp;que los artículos de altos costos (equipos de alta gama y vehículos), el pago aparte de la cuota correspondiente a la firma del Convenio, la adquisición de una póliza de seguro que permita prevenir la perdida material por siniestros o robos.</span></p>

        <p class="c5" id="h.gjdgxs"><span class="c2 c10">Clausula Décima Tercera:</span><span class="c2">&nbsp;</span><span class="c7">El articulo o vehículo se mantendrá a nombre de </span><span class="c2">WAIKA IMPORT C.A</span><span class="c7">&nbsp;hasta que “</span><span class="c2">El Beneficiario”</span><span class="c7 c18">&nbsp;cumpla el pago total del mismo. </span></p>

        <p class="c5"><span class="c2 c10">Clausula Décimo Cuarta:</span><span class="c7 c18">&nbsp;En caso de Litigio se escoge la ciudad de Caracas, Capital de la República Bolivariana de Venezuela y regulado por las leyes vigentes. </span></p>

        <img alt="" src="/images/image6.png" style="width: 41.87px; height: 29.07px; margin-left: 0.00px; margin-top: 0.00px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);" title="">


        

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p class="c40"><span class="c2">&nbsp;“WAIKA IMPORT C.A”</span><span class="c7">&nbsp;registro de información fiscal Nº </span><span class="c2">J-50145053-6</span><span class="c7">, &nbsp;según se evidencia en el documento debidamente registrado &nbsp;en la oficina del Registro Mercantil Segundo del circuito del Municipio Libertador y Distrito Capital de fecha </span><span class="c2">02 de Septiembre &nbsp;del 2021</span><span class="c7">, &nbsp;tomo: </span><span class="c2">138-A SDO</span><span class="c7">&nbsp; Numero: </span><span class="c2">25</span><span class="c7">, &nbsp;expediente: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span class="c2">221-92430</span><span class="c7">, protocolo de trascripción de ese mismo año, domicilio fiscal: Primera Avenida Sur de Altamira, edificio Santa Rita, Piso 5, parroquia Chacao, municipio Chacao, estado Miranda, representado por sus accionistas y junta directiva implementó la modalidad de </span><span class="c2">Pagos Fraccionados para el Auto Financiamiento Colectivo</span><span class="c7 c18">, con el fin de brindarle a sus clientes la posibilidad de adquirir los productos que deseen con garantías y facilidades de pago. </span></p>

        <p class="c13"><span class="c14">Datos del Beneficiario</span></p>
        <p class="c5"><span class="c2">Persona Natural </span></p>
        <table class="table table-bordered border-primary"><tbody><tr class="c4"><td class="c31" colspan="1" rowspan="1"><p class="c5"><span class="c3">Nombres: &nbsp;{{$dato_usuario['first_name']}}</span></p></td><td class="c26" colspan="2" rowspan="1"><p class="c5"><span class="c3">Nº</span>{{$convenio->nuro_combenio}}<span title=""></span></p></td></tr><tr class="c4"><td class="c15" colspan="1" rowspan="1"><p class="c5"><span class="c3">Apellidos: &nbsp; {{$dato_usuario['last_name']}}</span></p></td><td class="c9 c22" colspan="1" rowspan="1"><p class="c5"><span class="c3">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Tlf. Móvil:{{$dato_usuario['phone']}} &nbsp;</span></p></td><td class="c6" colspan="1" rowspan="1"><p class="c5"><span class="c3">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Tlf. Fijo:</span></p></td></tr><tr class="c4"><td class="c41" colspan="3" rowspan="1"><p class="c30"><span class="c2">&nbsp; &nbsp; Dirección de Habitación:{{$dato_usuario['address1']}}</span></p></td></tr><tr class="c4"><td class="c15" colspan="1" rowspan="1"><p class="c5"><span class="c3">Estado: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Municipio:</span></p></td><td class="c9 c22" colspan="1" rowspan="1"><p class="c5"><span class="c3">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Parroquia:</span></p></td><td class="c6" colspan="1" rowspan="1"><p class="c5"><span class="c3">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Ciudad: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span></p></td></tr><tr class="c4"><td class="c41" colspan="3" rowspan="1"><p class="c5"><span class="c3">Ubicación:</span></p></td></tr><tr class="c24"><td class="c15" colspan="1" rowspan="1"><p class="c5"><span class="c3">Correo Electrónico:{{$dato_usuario['email']}} </span></p></td><td class="c9 c22" colspan="1" rowspan="1"><p class="c5 c24"><span class="c8"></span></p></td><td class="c6" colspan="1" rowspan="1"><p class="c5 c24"><span class="c8"></span></p></td></tr></tbody></table>

        
        <br>
        <p class="c37"><span class="c14">Datos del Producto Auto Financiado</span></p>

        <table class="c12 table table-bordered border-primary"><tbody><tr class="c4"><td class="c43" colspan="2" rowspan="1"><p class="c5"><span class="c3">Cantidad: &nbsp; &nbsp; &nbsp; &nbsp; Descripción: &nbsp; &nbsp;</span></p></td><td class="c23" colspan="2" rowspan="1"><p class="c5"><span class="c3">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Marca:</span></p></td></tr><tr class="c4"><td class="c29 c22" colspan="1" rowspan="1"><p class="c5"><span class="c3">Tiempo de Garantía:{{$convenio->garantia}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p></td><td class="c29 c22" colspan="1" rowspan="1"><p class="c5 c24"><span class="c8"></span></p></td><td class="c29 c22" colspan="1" rowspan="1"><p class="c5"><span class="c3">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Precio:{{$convenio->total}}</span></p></td><td class="c17" colspan="1" rowspan="1"><p class="c5 c24"><span class="c7 c27"></span></p></td></tr><tr class="c4"><td class="c53" colspan="4" rowspan="1"><p class="c13 c24"><span class="c35 c18"></span></p><p class="c32"><span class="c14">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Cuotas del Convenio</span></p></td></tr><tr class="c4"><td class="c29 c22" colspan="1" rowspan="1"><p class="c5"><span class="c3">N° de Lote: </span></p></td><td class="c29 c22" colspan="1" rowspan="1"><p class="c5 c24"><span class="c7 c27"></span></p></td><td class="c29 c22" colspan="1" rowspan="1"><p class="c5"><span class="c3 c21">Monto Total a Pagar:{{$convenio->total}}</span></p></td><td class="c17" colspan="1" rowspan="1"><p class="c5 c24"><span class="c7 c27"></span></p></td></tr><tr class="c59"><td class="c53" colspan="4" rowspan="1"><p class="c19"><span class="c3">Monto de Inicial:{{$convenio->inicial}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Monto de Cuotas: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Nº de Cuotas:{{$convenio->nro_coutas}}</span></p></td></tr><tr class="c52"><td class="c43 c22" colspan="2" rowspan="1"><p class="c5"><span class="c3">Días de Pago: {{$convenio->fecha_pagos}}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span></p></td><td class="c23 c22" colspan="2" rowspan="1"><p class="c5 c24"><span class="c7 c27"></span></p></td></tr><tr class="c34"><td class="c43" colspan="2" rowspan="1"><p class="c5 c24"><span class="c7 c27"></span></p></td><td class="c29" colspan="1" rowspan="1"><p class="c5"><span class="c2 c57">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p></td><td class="c47" colspan="1" rowspan="1"><p class="c5 c24"><span class="c7 c27"></span></p></td></tr></tbody></table>
        <br>
        <br>

        <p class="c5"><span class="c14">Nota:</span><span class="c20">&nbsp;</span><span class="c7">El Beneficiario Declara que los datos suministrados son reales y acepta conforme el pago de las cuotas establecidas en el presente convenio</span><span class="c11">.</span></p>

        <span class="c11">________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ________________________________</span>

        <p class="c5"><span class="c46">&nbsp; &nbsp; </span><span class="c33">El Beneficiario</span><span class="c46">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><span class="c7">Representante de </span><span class="c2">WAIKA IMPORT C.A</span></p>

        <p class=""><span class="c33">Nombres y Apellidos</span><span class="">: {{$dato_usuario['first_name']}} {{$dato_usuario['last_name']}} &nbsp;</span></p>
        <p class=""><span class="c1">Cedula de Identidad: &nbsp;{{$dato_usuario['cedula']}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p>
        <p class=""><span class="c1">Fecha:{{$convenio->fecha_pagos}} &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span></p>
        <p class=""><span class="c1">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><span ></span></p>


        <div><p class="c30 c24 c39"><span class="c1"></span></p><p class="c30 c39"><span class="c33">Dirección: Primera Avenida Sur de Altamira, edificio Santa Rita, Piso 5, parroquia Chacao, municipio Chacao, estado Miranda, números telefónico 0412.635.40.41, 0412.635.40.38, correo electrónico: waika.atencioncliente@gmail.com, redes sociales: Instagram , Facebook Waika Importca</span></p></div>
    </div>

   
</body>
</html>