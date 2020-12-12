
//Pour temporiser le temps que l'API réponde
laPhrase = "EnAttendantGodot";

var form = document.getElementById("formulaire");
form.addEventListener("click", function () {
    while (laPhrase == "EnAttendantGodot") {}
    let inpout = document.getElementsByName("captcha");
    let proposition = inpout[0].value;
    // Si on a saisi la bonne valuer, on la garde. Sinon on efface !
    inpout[0].value = (proposition == laPhrase) ? inpout[0].value : "";
});

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function () {

    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        let maReponse = xmlhttp.responseXML;
        laPhrase = maReponse.getElementsByTagName("phrase")[0].firstChild.nodeValue;
    }
}
xmlhttp.open("GET", "/apicaptcha.php", true);
xmlhttp.send(null);