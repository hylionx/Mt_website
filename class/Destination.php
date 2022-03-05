<?php


class Destination
{

    //retourne la liste des liaisons
    public static function getListLiaisons()
    {
        $req = Database::connect()->query("SELECT id,nom FROM liaison_secteur ORDER by nom ASC");
        return $req->fetchAll();
    }

    //retourne la liste des secteurs
    public static function getFavorite() {
        $req = Database::connect()->query("SELECT id,nom,image FROM liaison_secteur ORDER BY nom desc LIMIT 3");
        return $req->fetchAll();
    }

    //retourne le nom des secteurs à partir de son identifiant
    public static function getNameForId($id) {
        $req = Database::connect()->prepare("SELECT nom FROM liaison_secteur WHERE id = ?");
        $req->execute([$id]);
        return $req->fetch()['nom'];
    }

    //retourne les destinations à partir d'une date
    public static function getSecteurDate($secteur, $date) {
        $retour = null;

        if($date == date("Y-m-d"))
            $timesDuJour00h = time();
        else
            $timesDuJour00h = strtotime($date);

        $timesDuJour23h59 = $timesDuJour00h+86399;

        if($secteur > 0) {
            $req = Database::connect()->prepare("SELECT pd.libelle AS libelle_pd, pa.libelle AS libelle_pa, ls.image,ls.description,t.date_depart,t.date_arrivee,t.id, l.id AS liaison FROM liaison l
                                                    INNER JOIN traversee t ON l.id = t.liaison
                                                    INNER JOIN liaison_secteur ls ON l.secteur = ls.id
                                                    INNER JOIN port pd ON pd.id = l.depart
                                                    INNER JOIN port pa ON pa.id = l.arrivee
                                                    WHERE t.date_depart >= ? AND t.date_depart <= ? AND l.secteur = ? ORDER BY t.date_depart ASC");
            $req->execute([$timesDuJour00h, $timesDuJour23h59, $secteur]);
        } else {
            $req = Database::connect()->prepare("SELECT pd.libelle AS libelle_pd, pa.libelle AS libelle_pa, ls.image,ls.description,t.date_depart,t.date_arrivee,t.id, l.id AS liaison FROM liaison l
                                                    INNER JOIN traversee t ON l.id = t.liaison
                                                    INNER JOIN liaison_secteur ls ON l.secteur = ls.id
                                                    INNER JOIN port pd ON pd.id = l.depart
                                                    INNER JOIN port pa ON pa.id = l.arrivee
                                                    WHERE t.date_depart >= ? AND t.date_depart <= ? ORDER BY t.date_depart ASC");
            $req->execute([$timesDuJour00h, $timesDuJour23h59]);
        }

        if($req->rowCount() > 0)
            $retour = $req->fetchAll();

        return $retour;
    }
    
    public function getDetails(){
    
    }
}