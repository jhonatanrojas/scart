
// mostra campo del cliente si es persona juridica 
const rif_Cliente = document.getElementById("rif");
const razonSocial = document.getElementById("razon_social");
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
    document.querySelector(".title").innerHTML = "Persona Juridica";
    document.querySelector(".title2").innerHTML = "Persona Juridica";
    valor = "";
    ocutaInput(valor);
  } else if (e.target.value == "N") {
    document.querySelector(".title").innerHTML = "Persona Natural";
    document.querySelector(".title2").innerHTML = "Persona Natural";
    valor = "none";
    ocutaInput(valor);
  }
});

function ocutaInput(valor) {
  oculta_razon_social.style.display = valor;
  oculta_rif.style.display = valor;
}





