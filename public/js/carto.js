
var lat = 45.1386;
var lon = 1.338196;
var dateDernierePosition;
var macarte = null;
var idInt = 0;
var idString = "";
var metronome = setInterval(actualisePosition, 3000);
var metronomeParcour = setInterval(actualiseDernierParcour, 5000);
var marker;


function changeLaTailleDeLaCarte() {
    let carte = document.getElementById("laCarte");
    let hauteurCarte = Math.round(window.innerHeight * .7);
    carte.style.height = hauteurCarte  + "px";

}
function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"

    macarte = L.map('laCarte').setView([lat, lon], 15);

    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(macarte);
    marker = L.marker([lat, lon]).addTo(macarte);
    marker.bindTooltip("Je cherche la dernière position").openTooltip();

}
function actualisePosition() {

    if (idInt ===0) {
        return;}

    let url = "http://api.xav/api/parcours/" + idInt + "/positions?order%5BdatePosition%5D=desc&page=1&itemsPerPage=1";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let maReponse = JSON.parse(xmlhttp.responseText);
            let laPosition = maReponse["hydra:member"][0];
            lat = laPosition["latitude"];
            lon = laPosition["longitude"];
            dateDernierePosition = laPosition["datePosition"];
            macarte.setView([lat, lon]);
            marker.setLatLng([lat, lon]);
            marker.bindTooltip(dateDernierePosition).openTooltip();
           // marker = L.marker([lat, lon]).addTo(macarte).bindPopup(dateDernierePosition);
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send(null);
}

function actualiseDernierParcour() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let maReponse = JSON.parse(xmlhttp.responseText);
            let leParcour = maReponse["hydra:member"][0];
            if (leParcour.hasOwnProperty("fin")) {
                idInt = 0;
                idString = "";
                marker.bindTooltip("Pas de parcour en cours ...").openTooltip();

            } else {
                idInt = leParcour["id"];
                idString = leParcour["@id"];
            }
        }
    }
    xmlhttp.open("GET", "http://api.xav/api/parcours?order%5Bid%5D=desc&page=1&itemsPerPage=1", true);
    xmlhttp.send(null);
}
window.onload = function(){
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    changeLaTailleDeLaCarte();
    initMap();
    actualiseDernierParcour();
};
window.onresize = function (){
    changeLaTailleDeLaCarte();
};