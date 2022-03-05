<?php


class Reservation
{
	// Retourne les informations concernant un voyage par rapport à son ID
	// Reçoit en paramètre l'ID d'un voyage : INT
	public static function getUnVoyage($id) {
		$retour = null;
		
		if($id != null && is_numeric($id)){
			$req = Database::connect()->prepare(
				"SELECT t.*, ls.image, ls.description, pd.libelle AS depart, pa.libelle AS arrivee FROM liaison l
					INNER JOIN liaison_secteur ls ON ls.id = l.secteur
					INNER JOIN port pd ON pd.id = l.depart
					INNER JOIN port pa ON pa.id = l.arrivee
					INNER JOIN traversee t ON t.liaison = l.id
					WHERE t.id = ?
			");
			
			$req->execute([$id]);
			if($req->rowCount() > 0) {
				$retour = $req->fetch();
			}
		}
		
		return $retour;
	}

	// Retourne un tableau de prix concernant une traversée
	// Les prix dépendent de la période et de la traversée
	// Reçoit en paramètre l'ID d'une traversée : INT
	public static function getPrices($id){
		$retour = null;
		
		if($id != null && is_numeric($id)){
			$req = Database::connect()->prepare(
				"SELECT pt.prix, t.libelle, t.categorie, t.id
                        FROM traversee tr                                      
                        INNER JOIN liaison l ON tr.liaison = l.id
                        INNER JOIN periode p ON p.liaison = l.id
                        INNER JOIN periode_transport pt ON pt.periode = p.id                                           
                        INNER JOIN transport_type t ON t.id = pt.transport_type                  
                        WHERE tr.id = ? AND (tr.date_depart BETWEEN p.date_debut AND p.date_fin)
                        ORDER BY pt.transport_type ASC");
			
			$req->execute([$id]);
			
			if($req->rowCount() > 0) {
				$retour = $req->fetchAll();
			}
		}
		
		return $retour;
	}

	//retourne les places restantes disponibles d'une traversée
	public static function getStock($traversee_id) {
        $retour = null;

        if($traversee_id != null && is_numeric($traversee_id)){
            $req = Database::connect()->prepare(
                "SELECT tt.categorie, (b.nombre-sum(cc.nombre)) AS reste, b.nombre
                          FROM transport_type tt 
                            LEFT JOIN traversee t ON t.id = ?
                            LEFT JOIN client_reservation cr ON cr.traversee = t.id 
                            LEFT JOIN client_caracteristique cc ON cc.transport_type = tt.id AND cc.reservation_id = cr.id                                            
                            LEFT JOIN bateau_caracteristique b ON b.bateau = t.bateau AND b.transport = tt.categorie
                            GROUP BY tt.categorie");

            $req->execute([$traversee_id]);

            if($req->rowCount() > 0) {
                $tab = $req->fetchAll();
                $retour = [];
                for($i = 0; $i < count($tab); $i++) {
                    $retour[$tab[$i]['categorie']] = ["reste" => ($tab[$i]['reste'] == null ? $tab[$i]['nombre'] : $tab[$i]['reste']), "nombre" => $tab[$i]['nombre']];
                }
            }
        }

        return $retour;
    }

    //vérifie les places restantes disponibles d'une traversée (sous forme boolean)
    public static function checkStock($traversee_id) {
        $retour = false;

        if($traversee_id != null && is_numeric($traversee_id)){
            $req = Database::connect()->prepare(
                "SELECT (b.nombre-sum(cc.nombre)) AS reste
                            FROM transport_type tt                            
                            LEFT JOIN traversee t ON t.id = ?
                            LEFT JOIN client_reservation cr ON cr.traversee = t.id 
                            LEFT JOIN client_caracteristique cc ON cc.transport_type = tt.id AND cc.reservation_id = cr.id
                            LEFT JOIN bateau_caracteristique b ON b.bateau = t.bateau AND b.transport = tt.categorie                     
                            WHERE tt.categorie = ?
                            GROUP BY tt.categorie");

            $req->execute([$traversee_id, 1]);

            if($req->rowCount() > 0) {
                $tab = $req->fetch();
                if($tab['reste'] > 0 || $tab['reste'] == null)
                    $retour = true;
            }

            return $retour;
        }
    }
}