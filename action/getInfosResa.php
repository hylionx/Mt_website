<?php


require "../global.php";

if($client->getOnline()){
	if(isset($_POST['idResa']) && is_numeric($_POST['idResa'])){
		$places = $client->getPlaces($_POST['idResa']);
		$infos = $client->getDetailsResa($_POST['idResa']);
		$date = strftime("%A %d %B %Y", $infos['date_depart']);
		$dataToReturn = array("places" => $places, "infos" => $infos, "date" => $date);
		
		echo json_encode($dataToReturn);
	}
}