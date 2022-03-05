<?php
/**
 * Class pour mettre des fonctions de génération de HTML
 */

class Html
{
    //genere option html
    public static function genereOption($array, $value, $name, $default = null)
    {
        $retour = null;
        for($i = 0; $i < count($array); $i++) {
            $retour = $retour.'<option '.($array[$i][$value] == $default ? 'selected' : '').' value="'.$array[$i][$value].'">'.$array[$i][$name].'</option>';
        }
        return $retour;
    }

    //vérifie la validité d'un string
    public static function validStr($str) {
        return isset($str) && strlen(trim($str)) > 0;
    }

    //vérifie la validité d'un entier
    public static function validInt($int) {
        return isset($int) && is_numeric($int);
    }

    //génère un token
    public static function token($nb) {
        $string = "";
        $chaine = "a0b1c2d3e4f5g6h7i8j9klmnpqrstuvwxy123456789";
        for($i=0; $i< $nb; $i++){
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }

    //rend valide un URL pour la connexion à l'espace client
    public static function validUrlEspaceClient($url) {
        $url = str_replace("?connect", "", $url);
	    $url = str_replace("?register", "", $url);
	    $url = str_replace("&connect", "", $url);
	    $url = str_replace("&register", "", $url);
        return $url;
    }
}