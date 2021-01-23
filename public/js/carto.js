
var lat = 45.1386;
var lon = 1.338196;
var precision = 2.5;
var leclercle;
var onField;
var dateDernierePosition;
var dateEnregistrement;
var macarte = null;
var idInt = 0;
var idString = "";
var metronome = setInterval(actualisePosition, 3000);
var metronomeParcour = setInterval(actualiseDernierParcour, 5000);
var marker;
var laDivInfo = document.getElementsByClassName("heurPos")[0];
var laDivEnr = document.getElementsByClassName("heurEnr")[0];
var carte = document.getElementById("laCarte");

function changeLaTailleDeLaCarte() {

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

    var osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"),
        mqi = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png", {subdomains: ['otile1','otile2','otile3','otile4']});

    var baseMaps = {
        "OpenStreetMap": osm,
        "MapQuestImagery": mqi
    };

    var overlays =  {//add any overlays here

    };

    L.control.layers(baseMaps,overlays, {position: 'bottomleft'}).addTo(macarte);

    marker = L.marker([lat, lon]).addTo(macarte);
    marker.bindTooltip("Je cherche la dernière position").openTooltip();
    laDivInfo.innerText = "En attente de la réponse du serveur"

}
function actualisePosition() {

    if (idInt ===0) {
        return;}

    let url = "https://xavier-monset.fr/api/parcours/" + idInt + "/positions?order%5BdatePosition%5D=desc&page=1&itemsPerPage=1";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

            let maReponse = JSON.parse(xmlhttp.responseText);
            let laPosition = maReponse["hydra:member"][0];


            lat = laPosition["latitude"];
            lon = laPosition["longitude"];
            precision = laPosition["accuracy"];
            onField = laPosition["fromfield"];

            dateDernierePosition = laPosition["datePosition"];
            dateEnregistrement = laPosition["dateInsertion"];
            let heureOnly = dateDernierePosition.slice(dateDernierePosition.indexOf("T") +1
            , dateDernierePosition.indexOf("+"));

            let HeureEnregistrement = dateEnregistrement.slice(dateEnregistrement.indexOf("T") +1
                , dateEnregistrement.indexOf("+"));

            macarte.setView([lat, lon]);
            marker.setLatLng([lat, lon]);
            marker.bindTooltip(heureOnly).openTooltip();
            laDivInfo.innerText = "Heure de la position : " + heureOnly;
            laDivEnr.innerText = "Heure réception : " + HeureEnregistrement;

            if (leclercle != undefined) {
                macarte.removeLayer(leclercle);
            }
            let couleur = '#0366D6';

            if (!onField) {

                couleur ='#d60370'
            }
            leclercle = L.circle([lat,lon],precision, {
                color: couleur
            }).addTo(macarte);

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
                laDivInfo.innerText = "Pas de parcours ... en cours"
                laDivEnr.innerText = "";

            } else {
                idInt = leParcour["id"];
                idString = leParcour["@id"];
            }
        }
    }
    xmlhttp.open("GET", "https://xavier-monset.fr/api/parcours?order%5Bid%5D=desc&page=1&itemsPerPage=1", true);
    xmlhttp.send(null);
}
window.onload = function() {
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    changeLaTailleDeLaCarte();
    initMap();
    actualiseDernierParcour();

};
window.onresize = function (){
    changeLaTailleDeLaCarte();
};