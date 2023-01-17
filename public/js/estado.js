

$(document).ready(function () {
    var i = 0;
  
    $("#cod_estado").change(function () {
      buscarMunicipios();
    });
    $("#cod_municipio").change(function () {
      buscarParroquia();
    });
  
    function buscarMunicipios() {
      var estado = $("#cod_estado").val();
  
      if (estado == "") {
        $("#cod_municipio").html(
          '<option value="">Debe seleccionar un Estado por favor</option>'
        );
      } else {
        $.ajax({
          dataType: "json",
          data: { codigoestado: estado },
          url: `/municipio/${estado}`,
          type: "get",
          beforeSend: function () {
            $("#cod_municipio").html("<option>cargando municipio...</option>");
            i++;
          },
  
          success: function (respuestas) {
            var datos = respuestas.respuesta;
            $("#cod_municipio").html("<option>Selecione un municipio</option>");
  
            i--;
            if (i <= 0) {
              const codigomunicipio = document.getElementById("cod_municipio");
              datos.map((element) => {
                const div = document.createElement("option");
                div.setAttribute("value", `${element.codigomunicipio}`);
                div.innerHTML += `${element.nombre}`;
                codigomunicipio.appendChild(div);
              });
            }
          },
          error: function (xhr, err) {
            alert(
              "readyState =" +
                xhr.readyState +
                " estado =" +
                xhr.status +
                "respuesta =" +
                xhr.responseText
            );
            //alert("ocurrio un error intente de nuevo");
          },
        });
      }
    }
  
    function buscarParroquia() {
      var municipio = $("#cod_municipio").val();
      var estado = $("#cod_estado").val();
  
      if (municipio == "") {
        $("#cod_parroquia").html(
          '<option value="">Debe seleccionar un Municipio por favor</option>'
        );
      } else {
        $.ajax({
          dataType: "json",
          data: { codigomunicipio: municipio, codigoestado: estado },
          url: `/parroquia/${municipio}/${estado}`,
          type: "get",
          beforeSend: function () {
            $("#cod_parroquia").html("<option>cargando parroquias...</option>");
            //$("#cod_parroquia").selectpicker('refresh');
          },
  
          success: function (respuestas) {
            var datos = respuestas.respuesta;
            $("#cod_parroquia").html("<option>Selecione una parroquia</option>");
  
            i--;
            if (i <= 0) {
              const codigomunicipio = document.getElementById("cod_parroquia");
              datos.map((element) => {
                const div = document.createElement("option");
                div.setAttribute("value", `${element.codigoparroquia}`);
                div.innerHTML += `${element.nombre}`;
                codigomunicipio.appendChild(div);
              });
            }
          },
          error: function (xhr, err) {
            alert(
              "readyState =" +
                xhr.readyState +
                " estado =" +
                xhr.status +
                "respuesta =" +
                xhr.responseText
            );
            //alert("ocurrio un error intente de nuevo");
          },
        });
      }
    }
  });




  //  const  nacionalidad = document.getElementById("nacionalidad")
  //  nacionalidad.addEventListener("change" , function(e){
   
    
  //   const  nacionalidad2 = document.getElementById("nacionalidad").value
  //   if( nacionalidad2 == "V" ){
  //     console.log(nacionalidad2)
  //     $("#cedula").val("V:")
  //   }else if(nacionalidad2 == "E"){
  //     $("#cedula").val("E:")
  //   }else{
  //     $("#cedula").val("")
  //   }
   

  //  })



