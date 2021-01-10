<?php

if(isset ($_POST['valider'])) {

    $civilite = $_POST['Civilité'];
    $nom = $_POST['familyName'];
    $tel = $_POST['telephone'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
        <title>Demande de contact validée !</title>
        <style>
            body {
                
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                font-family: Arial, Helvetica, sans-serif;
            }
            
            
            div{
                
                display: flex;
                flex-direction: column;
                width: 70%;
                border: 1px solid #555;
                box-shadow: 4px 4px 12px #555;
                border-radius: 10px;
                padding: 1em;
            }
            div h3, div a{
                
                align-self: center;
            }
    
            a {
    
                text-decoration: none;
                border: 1px solid #555;
                border-radius: 8px;
                padding: 10px;
                box-shadow: 2px 2px 8px #555;  
                color : black;
            }

            a:hover, a:focus-within {
                box-shadow: 4px 4px 12px #555; 
                color : white;
                background-color: blue;
                font-weight : bold;
            }
        </style>
    </head>
    <body>
        <div>
            <h3>Confirmation de la prise de contact</h3><br>
            <p>Bonjour ".$civilite." ".$nom.",</p>
            <p>un email de confirmation a été envoyé a <strong>".$email."</strong>. (N'oubliez pas de vérifier dans vos spams)</p>
            <p>Je vous répondrais aussi rapidement que possible.</p><br>
            <p>Xavier Monset</p>
            <br>
            <a href=\"index.php\">Ok, merci</a>
        </div>
    </body>
    </html>";
   
    /* Rédaction du premier e-mail, a destination du visiteur */
    $corps = "Bonjour ". $civilite ." ".$nom . "\r\n".
    "J'ai bien pris note de votre demande et je vais y répondre au plus vite \r\n".
    "Bien à vous, \n\r"."Xavier Monset";
    $success = mail($email,'Confirmation de la prise de contact',$corps,'From: xavier.monset@gmail.com','-f xavier.monset@gmail.com');
    
    /* Rédaction du second e-mail, à mon intention */

    $corps = $civilite ." ".$nom . " Tel : " . $tel ."\r\n" .
    "email : " . $email . "\n\r"
    . $message;
    $success = mail('xavier.monset@gmail.com','Demande de contact via CV',$corps,'From: xavier.monset@gmail.com','-f xavier.monset@gmail.com');
    
}
?>
