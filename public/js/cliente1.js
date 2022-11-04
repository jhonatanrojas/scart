
// mostra campo del cliente si es persona juridica 
const natural_Jurídica = document.getElementById("natural_jurídica");
const oculta_razon_social = document.querySelector(".oculta_razon_social");
const oculta_rif = document.querySelector(".oculta_rif");
let valor = "none";

oculta_razon_social.style.display = valor;
oculta_rif.style.display = valor;
natural_Jurídica.addEventListener("change", function (e) {
  if (e.target.value == "J") {
    document.getElementById("razon_social").disabled = false;
    document.getElementById("rif").disabled = false;
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

function ocutaInput(valor) {
  oculta_razon_social.style.display = valor;
  oculta_rif.style.display = valor;
}


