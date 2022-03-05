<?php

//Les constantes du template
define("SITE", "http://localhost/MT_website/");

define("CSS", SITE."css/");
define("JS", SITE."js/");
define("IMG_ILE", SITE."img/iles/");

define("TPL", "./require/");

define('ROOTDIR', __DIR__);
define('CLASSDIR', ROOTDIR . '/class/');

define("ACTION", SITE."action/");

//Date en français
setlocale(LC_TIME, "fr_FR");

//Include des class
include CLASSDIR . 'Autoloader.php';
Autoloader::load();

//création des objets
$db = new Database();
$html = new Html();

$destination = new Destination();
$reservation = new Reservation();
$client = new Client();


//Inscription client avec vérifications de la saisie
if(isset($_GET['register'])){
	if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && Html::validStr($_POST['nom']) && Html::validStr($_POST['prenom']) && Html::validStr($_POST['email']) && Html::validStr($_POST['password']) && Html::validStr($_POST['adresse']) && Html::validStr($_POST['cp']) && Html::validStr($_POST['ville'])){

	    if(strlen($_POST['password']) < 5) {
            $errorPopup = "Le mot de passe saisi est trop petit.";
        } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errorPopup = "L'email saisie n'est pas valide.";
        } else if(!$client->register($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password'], $_POST['adresse'], $_POST['cp'], $_POST['ville'])){
                $errorPopup = "L'adresse mail est déjà utilisée.";
        } else {
            header("location: ".Html::validUrlEspaceClient($_SERVER['HTTP_REFERER']));
        }

	}else{
		$errorPopup = "Les données saisies ne sont pas correctes !";
	}
}

//Connexion client
if(isset($_GET['connect'])){
	if(isset($_POST['email']) && isset($_POST['password']) && Html::validStr($_POST['email']) && Html::validStr($_POST['password'])){
		
		$client->checkConnexion(false, $_POST['email'], $_POST['password']);
		if(!$client->getOnline()) {
			$errorPopup = "E-mail ou mot de passe incorrect !";
		} else {
		    header("location: ".Html::validUrlEspaceClient($_SERVER['HTTP_REFERER']));
        }
	}else{
		$errorPopup = "Les données saisies ne sont pas correctes !";
	}
}
?>