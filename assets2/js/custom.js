// json/TRAYECTOS_DATA_TABLE.json
// file = new File("json/TRAYECTOS_DATA_TABLE.json");
// let reader = new FileReader();
// reader.readAsDataURL(file);
// console.log(reader.result);
url = "json/TRAYECTOS_DATA_TABLE.json";
fetch(url,{mode:"cors"})
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], 'TRAYECTOS_DATA_TABLE.json', {type:'text/json'});
                        console.log(file);
                    });


function validate() {
  var name = document.getElementById("name").value;
  var destinoList = document.getElementById("destino");
  var selDestino = destinoList.options[destinoList.selectedIndex].text;
  var fecha = document.getElementById("date").value;
  var costo = document.getElementById("costo").value;
  var vehiculo = document.getElementById("vehiculo").value;
  var duracion = document.getElementById("duracion").value;
  var distancia = document.getElementById("distancia").value;
  var reserva = document.getElementById("booking");

  reserva.innerHTML =
    "<form><h2 class='major'>Datos de la reserva</h2><div class='fields'>" +
    "<div class='field half'><label>Nombre: </label>" +
    name +
    "</div>" +
    "<div class='field half'><label>Destino: </label>" +
    selDestino +
    "</div>" +
    "<div class='field half'><label>Fecha: </label>" +
    fecha +
    "</div>" +
    "<div class='field half'><label>Costo: </label>" +
    costo +
    "</div>" +
    "<div class='field half'><label>Vehículo: </label>" +
    vehiculo +
    "</div>" +
    "<div class='field half'><label>Duración: </label>" +
    duracion +
    "</div>" +
    "<div class='field half'><label>Distancia: </label>" +
    distancia +
    "</div>" +
    "</div><div><button onClick='window.location.reload();'>Volver</button></div></form>";
}
