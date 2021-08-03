var lesparcours = [];
var laselec = document.getElementById("maliste");
var macarte = null;
var carte = document.getElementById("laCarte");
var parcour = null;
var polyline;
var layer;

function lechoixestfait() {

    let index = parseInt(laselec.value);
    parcour = lesparcours[index];
    this.draw();

}

function draw() {

    if (polyline != undefined) {
        macarte.removeLayer(polyline);
    }

    if (layer != undefined) {
        macarte.removeLayer(layer);
    }
    layer = L.layerGroup();
    let lespositions = [];
    parcour.positions.forEach((pos) => {

        let pointA = new L.LatLng(pos.latitude, pos.longitude);
        lespositions.push(pointA);
        let couleur = '#0366D6';
        if (!pos.fromfield) {
            couleur = '#d60370'
        }
        let leclercle = L.circle([pos.latitude, pos.longitude], pos.accuracy, {
            color: couleur
        }).addTo(layer);
    })
    layer.addTo(macarte);
    polyline = L.polyline(lespositions, {color: 'blue'}).addTo(macarte);
    macarte.fitBounds(polyline.getBounds());
}

function recupparcours() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let maReponse = JSON.parse(xmlhttp.responseText);
            lesparcours = maReponse["hydra:member"];

            let index = 0;
            lesparcours.forEach((parcour) => {
                //let unchoix = "<option value =" + parcour.id + ">" + parcour.debut + "</option>";
                let heure = parcour.debut.slice(parcour.debut.indexOf("T") + 1
                    , parcour.debut.indexOf("+"));
                let jour = parcour.debut.slice(0, parcour.debut.indexOf("T"));
                let unchoix = "<option value =" + index + ">" + jour + " " + heure + "</option>";
                index++;
                laselec.innerHTML = laselec.innerHTML + unchoix;
            })
        }
    }
    xmlhttp.open("GET", "https://xavier-monset.fr/api/parcours?order%5Bid%5D=desc&page=1&itemsPerPage=30", true);
    xmlhttp.send(null);
}

function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"

    macarte = L.map('laCarte').setView([45.1386, 1.338196], 15);

    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(macarte);

    var osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"),
        mqi = L.tileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png", {subdomains: ['otile1', 'otile2', 'otile3', 'otile4']});

    var baseMaps = {
        "OpenStreetMap": osm,
        "MapQuestImagery": mqi
    };

    var overlays = {//add any overlays here

    };

    L.control.layers(baseMaps, overlays, {position: 'bottomleft'}).addTo(macarte);

    marker = L.marker([45.1386, 1.338196]).addTo(macarte);
    marker.bindTooltip("J'attends que tu choisisses un parcours").openTooltip();


}

function changeLaTailleDeLaCarte() {

    let hauteurCarte = Math.round(window.innerHeight * .7);
    carte.style.height = hauteurCarte + "px";

}

window.onload = function () {
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    changeLaTailleDeLaCarte();
    initMap();
    this.recupparcours();

};