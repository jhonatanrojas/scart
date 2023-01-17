const natural_Jurídica = document.getElementById("natural_jurídica");
const oculta_razon_social = document.querySelector(".oculta_razon_social");
const rif = document.querySelector(".oculta_rif");

oculta_razon_social.style.display = "none";
rif.style.display = "none";




natural_Jurídica.addEventListener("change", function (e) {

  if (e.target.value == "J") {
    document.getElementById("razon_social").disabled = false;
    if(!document.getElementById("rif") == "null")document.getElementById("rif").disabled = false;
    document.querySelector('.title') ?document.querySelector('.title').style.display='block' : "";
    valor = "";
    ocutaInput(valor);
  } else if (e.target.value == "N") {

    valor = "none";
    ocutaInput(valor);
  }else{
    valor = "none";
    ocutaInput(valor);
  }
 
});


if(natural_Jurídica.value == "J"){
  document.getElementById("razon_social").disabled = false;
  if(!document.getElementById("rif") == "null")document.getElementById("rif").disabled = false;
    valor = "";
    ocutaInput(valor);
}

function ocutaInput(valor) {
  oculta_razon_social.style.display = valor;
  rif.style.display = valor;
}P