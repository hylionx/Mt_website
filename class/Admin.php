<?php

class Admin
{
    // Permet de récupérer tous les transport type
    public static function getTransportType(){
        $retour = null;

        $req = Database::connect()->query("SELECT * FROM transport_type ORDER BY categorie ASC, libelle ASC");
        if($req->rowCount() > 0) {
            $retour = $req->fetchAll();
        }

        return $retour;
    }

	// Permet de récupérer toutes les liaisons
	public static function getLiaisons(){
		$retour = null;
		
		$req = Database::connect()->query(
			"SELECT l.id, ls.nom AS secteur, l.distance, pd.libelle AS depart, pa.libelle as arrivee, CONCAT('N°', l.id, ' [', pd.libelle, ' - ', pa.libelle, '] en ', l.distance, ' kms') AS value FROM liaison l
					INNER JOIN liaison_secteur ls ON ls.id = l.secteur
					INNER JOIN port pd ON pd.id = l.depart
					INNER JOIN port pa ON pa.id = l.arrivee
					ORDER BY l.id DESC");
		
		if($req->rowCount() > 0) {
			$retour = $req->fetchAll();
		}
		
		return $retour;
	}
	
	// Permet de récupérer une liaison par rapport à son ID
	// Reçoit en paramètre l'id d'une liaison : INT
	public static function getUneLiaison($id){
		$retour = null;
		
		$req = Database::connect()->prepare(
			"SELECT l.id, ls.id AS secteur, l.distance, pd.id AS depart, pa.id as arrivee FROM liaison l
					INNER JOIN liaison_secteur ls ON ls.id = l.secteur
					INNER JOIN port pd ON pd.id = l.depart
					INNER JOIN port pa ON pa.id = l.arrivee
					WHERE l.id = ?");
		
		$req->execute([$id]);
		
		if($req->rowCount() > 0) {
			$retour = $req->fetch();
		}
		
		return $retour;
	}
	
	// Permet de récupérer toutes les traversées
	public static function getTraversees(){
		$retour = null;
		
		$req = Database::connect()->query(
			"SELECT t.id, b.libelle AS bateau, t.date_depart AS dateD, t.date_arrivee AS dateA, pd.libelle AS depart, pa.libelle as arrivee FROM traversee t
					INNER JOIN bateau b ON t.bateau = b.id
					INNER JOIN liaison l ON t.liaison = l.id
					INNER JOIN port pd ON pd.id = l.depart
					INNER JOIN port pa ON pa.id = l.arrivee				
					ORDER BY t.date_depart DESC");
		
		$req->execute();
		
		if($req->rowCount() > 0) {
			$retour = $req->fetchAll();
		}
		
		return $retour;
	}
	
	// Permet de récupérer une traversée par rapport à son ID
	// Reçoit en paramètre l'id d'une traversée : INT
	public static function getUneTraversee($id){
		$retour = null;
		
		$req = Database::connect()->prepare(
			"SELECT t.id, b.id AS bateau, t.date_depart AS dateD, t.date_arrivee AS dateA, t.liaison FROM traversee t
					INNER JOIN bateau b ON t.bateau = b.id
					WHERE t.id = ?");
		
		$req->execute([$id]);
		
		if($req->rowCount() > 0) {
			$retour = $req->fetch();
		}
		
		return $retour;
	}

	//Met à jour une traverséé par rapport à son identifiant
    public static function updateTraversee($id, $bateau, $liaison, $dateD, $dateA) {
        $req = Database::connect()->prepare("UPDATE traversee SET bateau = ?, liaison = ?, date_depart = ?, date_arrivee = ? WHERE id = ?");
        $req->execute([$bateau, $liaison, $dateD, $dateA, $id]);
    }

    //Ajoute une nouvelle traverséé
    public static function addTraversee($bateau, $liaison, $dateD, $dateA) {
        $req = Database::connect()->prepare("INSERT INTO traversee (bateau,liaison,date_depart,date_arrivee) VALUE (?,?,?,?)");
        $req->execute([$bateau, $liaison, $dateD, $dateA]);
    }

    // Permet de récupérer toutes les periodes
    public static function getPeriodes(){
        $retour = null;

        $req = Database::connect()->query(
            "SELECT p.id,p.date_debut,p.date_fin,CONCAT('N°', l.id, ' [', pd.libelle, ' - ', pa.libelle, '] en ', l.distance, ' kms') AS liaison FROM periode p 
                    INNER JOIN liaison l ON p.liaison = l.id
					INNER JOIN liaison_secteur ls ON ls.id = l.secteur
					INNER JOIN port pd ON pd.id = l.depart
					INNER JOIN port pa ON pa.id = l.arrivee ORDER BY p.id DESC");

        $req->execute();

        if($req->rowCount() > 0) {
            $retour = $req->fetchAll();
        }

        return $retour;
    }

    // Permet de récupérer toutes les periodes pour une option (html)
    public static function getPeriodesForOption(){
        $retour = null;

        $req = Database::connect()->query(
            'SELECT id, CONCAT("N°", id, "  [", DATE_FORMAT(FROM_UNIXTIME(date_debut), "%d-%m-%Y"), " - ", DATE_FORMAT(FROM_UNIXTIME(date_fin), "%d-%m-%Y"), "]  liaison N°", liaison) AS value FROM periode ORDER BY id DESC');
        $req->execute();

        if($req->rowCount() > 0) {
            $retour = $req->fetchAll();
        }

        return $retour;
    }

    // Permet de récupérer une traversée par rapport à son ID
    // Reçoit en paramètre l'id d'une traversée : INT
    public static function getUnePeriode($id){
        $retour = null;

        $req = Database::connect()->prepare(
            "SELECT p.*,CONCAT('N°', l.id, ' [', pd.libelle, ' - ', pa.libelle, '] en ', l.distance, ' kms') AS value FROM periode p 
                    INNER JOIN liaison l ON p.liaison = l.id
					INNER JOIN liaison_secteur ls ON ls.id = l.secteur
					INNER JOIN port pd ON pd.id = l.depart
					INNER JOIN port pa ON pa.id = l.arrivee WHERE p.id = ?");

        $req->execute([$id]);

        if($req->rowCount() > 0) {
            $retour = $req->fetch();
        }

        return $retour;
    }

    //Met à jour une traverséé par rapport à son identifiant
    public static function updatePeriode($id, $date_debut, $date_fin, $liaison) {
        $req = Database::connect()->prepare("UPDATE periode SET date_debut = ?, date_fin = ?, liaison = ? WHERE id = ?");
        $req->execute([$date_debut, $date_fin, $liaison, $id]);
    }

    //Ajoute une nouvelle traverséé
    public static function addPeriode($date_debut, $date_fin, $liaison) {
        $req = Database::connect()->prepare("INSERT INTO periode (date_debut,date_fin,liaison) VALUE (?,?,?)");
        $req->execute([$date_debut, $date_fin, $liaison]);
    }

    // Permet de récupérer les caracteristiques d'une période
    public static function getCaracteristiqueForPeriode($idPeriode){
        $retour = null;

        $req = Database::connect()->prepare(
            "SELECT pt.prix, tp.libelle, pt.id FROM periode_transport pt INNER JOIN transport_type tp ON pt.transport_type = tp.id WHERE pt.periode = ? ORDER BY tp.categorie ASC, tp.libelle ASC");

        $req->execute([$idPeriode]);

        if($req->rowCount() > 0) {
            $retour = $req->fetchAll();
        }

        return $retour;
    }

    // Permet de changer les caracteristique d'une période
    public static function updateCaracteristiquesPeriode($idPeriode, $id, $prix){
        $req = Database::connect()->prepare(
            "UPDATE periode_transport SET periode = ?, prix = ? WHERE id = ?");
        $req->execute([$idPeriode, $prix, $id]);
    }

    // Permet de changer les caracteristique d'une période
    public static function addCaracteristiquesPeriode($periode, $transport_type, $prix){

        $checkExist = $req = Database::connect()->prepare("SELECT id FROM periode_transport WHERE periode = ? AND transport_type = ?");
        $checkExist->execute([$periode, $transport_type]);

        if($checkExist->rowCount() == 0) {
            $req = Database::connect()->prepare("INSERT INTO periode_transport(periode,prix,transport_type) VALUE (?,?,?)");
            $req->execute([$periode, $prix, $transport_type]);
            $message = ["success", "Le caracteristique a bien été ajouté !"];
        } else {
            $message = ["error", "Ce caracteristique existe déjà pour cette période."];
        }

        return $message;
    }

	// Retourne un tableau avec l'ensemble des ports
	public static function getBateaux(){
		$retour = null;
		
		$req = Database::connect()->query(
			"SELECT * FROM bateau ORDER BY id DESC");
		
		if($req->rowCount() > 0) {
			$retour = $req->fetchAll();
		}
		
		return $retour;
	}

	//Retourne la liste des messages reçus
    public static function getMessages() {
        $retour = null;

        $req = Database::connect()->query("SELECT * FROM contact ORDER BY id DESC");
        if($req->rowCount() > 0) {
            $retour = $req->fetchAll();
        }

        return $retour;
    }

    //Supprimer un message par son id
    public static function deleteMessages($id) {

        $req = Database::connect()->prepare("DELETE FROM contact WHERE id = ?");
        $req->execute([$id]);

        $message = ["success", "Le message est bien supprimé !"];

        return $message;
    }
	
	// Retourne un tableau avec l'ensemble des ports
	public static function getPorts(){
		$retour = null;
		
		$req = Database::connect()->query(
			"SELECT * FROM port ORDER BY id DESC");
		
		if($req->rowCount() > 0) {
			$retour = $req->fetchAll();
		}
		
		return $retour;
	}
	
	// Retourne un tableau qui contient le nombre total de réservations
	// effectuées sur les trois derniers mois
	public static function getStatsReservations(){
		
		// MOIS EN COURS
		$req = Database::connect()->prepare(
			"SELECT count(*) AS nb_resa FROM client_reservation WHERE times BETWEEN ? AND ?"
		);
		
		$req->execute([strtotime("-1 months"), time()]);
		$actualMonth = $req->fetch();
		
		if($actualMonth['nb_resa'] == NULL){
			$actualMonth['nb_resa'] = 0;
		}
		
		// MOIS PRECEDENT
		$req2 = Database::connect()->prepare(
			"SELECT count(*) AS nb_resa FROM client_reservation WHERE times BETWEEN ? AND ?"
		);
		
		$req2->execute([strtotime("-2 months"), strtotime("-1 months")]);
		$firstMonth = $req2->fetch();
		
		if($firstMonth['nb_resa'] == NULL){
			$firstMonth['nb_resa'] = 0;
		}
		
		// IL Y A DEUX MOIS
		$req3 = Database::connect()->prepare(
			"SELECT count(*) AS nb_resa FROM client_reservation WHERE times BETWEEN ? AND ?"
		);
		
		$req3->execute([strtotime("-3 months"), strtotime("-2 months")]);
		$secondMonth = $req3->fetch();
		
		if($secondMonth['nb_resa'] == NULL){
			$secondMonth['nb_resa'] = 0;
		}
		
		// AU TOTAL
		$req4 = Database::connect()->query(
			"SELECT count(*) AS nb_resa FROM client_reservation"
		);
		
		$total = $req4->fetch();
		
		if($total['nb_resa'] == NULL){
			$total['nb_resa'] = 0;
		}
		
		return $tab = [$actualMonth['nb_resa'], $firstMonth['nb_resa'], $secondMonth['nb_resa'], $total['nb_resa']];
	}
	
	// Retourne un tableau qui contient le nombre total de passagers
	// transportés sur les trois derniers mois
	public static function getStatsPassagerTotal(){
		
		// MOIS EN COURS
		$req = Database::connect()->prepare(
			"SELECT SUM(cc.nombre) AS nb_passager
					FROM client_caracteristique cc
					INNER JOIN client_reservation cr ON cc.reservation_id = cr.id
					WHERE cr.times BETWEEN ? AND ?"
		);
		
		$req->execute([strtotime("-1 months"), time()]);
		$actualMonth = $req->fetch();
		
		if($actualMonth['nb_passager'] == NULL){
			$actualMonth['nb_passager'] = 0;
		}
		
		// MOIS PRECEDENT
		$req2 = Database::connect()->prepare(
			"SELECT SUM(cc.nombre) AS nb_passager
					FROM client_caracteristique cc
					INNER JOIN client_reservation cr ON cc.reservation_id = cr.id
					WHERE times BETWEEN ? AND ?"
		);
		
		$req2->execute([strtotime("-2 months"), strtotime("-1 months")]);
		$firstMonth = $req2->fetch();
		
		if($firstMonth['nb_passager'] == NULL){
			$firstMonth['nb_passager'] = 0;
		}
		
		// IL Y A DEUX MOIS
		$req3 = Database::connect()->prepare(
			"SELECT SUM(cc.nombre) AS nb_passager
					FROM client_caracteristique cc
					INNER JOIN client_reservation cr ON cc.reservation_id = cr.id
					WHERE times BETWEEN ? AND ?"
		);
		
		$req3->execute([strtotime("-3 months"), strtotime("-2 months")]);
		$secondMonth = $req3->fetch();
		
		if($secondMonth['nb_passager'] == NULL){
			$secondMonth['nb_passager'] = 0;
		}
		
		// AU TOTAL
		$req4 = Database::connect()->query(
			"SELECT SUM(cc.nombre) AS nb_passager
					FROM client_caracteristique cc
					INNER JOIN client_reservation cr ON cc.reservation_id = cr.id"
		);
		
		$total = $req4->fetch();
		
		if($total['nb_passager'] == NULL){
			$total['nb_passager'] = 0;
		}
		
		return $tab = [$actualMonth['nb_passager'], $firstMonth['nb_passager'], $secondMonth['nb_passager'], $total['nb_passager']];
	}
	
	// Retourne un tableau qui contient le nom des catégories
	// et le nombre de passagers respectifs transportés dans ces catégories sur les trois derniers mois
	public static function getStatsPassagerByCategorie(){
		
		// NOM DES CATEGORIES
		$req4 = Database::connect()->query(
			"SELECT libelle
					FROM transport_categorie"
		);
		
		$categories = $req4->fetchAll();
		
		$tabFinal = null;
		
		for($i = 0; $i < count($categories); $i++){
			// MOIS EN COURS
			$req = Database::connect()->prepare(
				"SELECT SUM(cc.nombre) AS nb_passager
					FROM client_caracteristique cc
					INNER JOIN client_reservation cr ON cc.reservation_id = cr.id
					INNER JOIN transport_type tt ON cc.transport_type = tt.id
					INNER JOIN transport_categorie tc ON tt.categorie = tc.id
					WHERE (cr.times BETWEEN ? AND ?)
					AND tc.libelle LIKE ?
					GROUP BY tt.categorie
					ORDER BY tt.id"
			);
			
			$req->execute([strtotime("-1 months"), time(), "%".$categories[$i]['libelle']."%"]);
			$actualMonth = $req->fetch();
			
			if($actualMonth['nb_passager'] == NULL){
				$actualMonth['nb_passager'] = 0;
			}
			
			// MOIS PRECEDENT
			$req2 = Database::connect()->prepare(
				"SELECT SUM(cc.nombre) AS nb_passager
					FROM client_caracteristique cc
					INNER JOIN client_reservation cr ON cc.reservation_id = cr.id
					INNER JOIN transport_type tt ON cc.transport_type = tt.id
					INNER JOIN transport_categorie tc ON tt.categorie = tc.id
					WHERE (cr.times BETWEEN ? AND ?)
					AND tc.libelle LIKE ?
					GROUP BY tt.categorie
					ORDER BY tt.id"
			);
			
			$req2->execute([strtotime("-2 months"), strtotime("-1 months"), "%".$categories[$i]['libelle']."%"]);
			$firstMonth = $req2->fetch();
			
			if($firstMonth['nb_passager'] == NULL){
				$firstMonth['nb_passager'] = 0;
			}
			
			// IL Y A DEUX MOIS
			$req3 = Database::connect()->prepare(
				"SELECT SUM(cc.nombre) AS nb_passager
					FROM client_caracteristique cc
					INNER JOIN client_reservation cr ON cc.reservation_id = cr.id
					INNER JOIN transport_type tt ON cc.transport_type = tt.id
					INNER JOIN transport_categorie tc ON tt.categorie = tc.id
					WHERE (cr.times BETWEEN ? AND ?)
					AND tc.libelle LIKE ?
					GROUP BY tt.categorie
					ORDER BY tt.id"
			);
			
			$req3->execute([strtotime("-3 months"), strtotime("-2 months"), "%".$categories[$i]['libelle']."%"]);
			$secondMonth = $req3->fetch();
			
			if($secondMonth['nb_passager'] == NULL){
				$secondMonth['nb_passager'] = 0;
			}
			
			$tabFinal[$i] = [$categories[$i]['libelle'], $actualMonth['nb_passager'], $firstMonth['nb_passager'], $secondMonth['nb_passager']];
		}
		return $tabFinal;
	}
	
	// Retourne un tableau qui contient les chiffres d'affaires
	// sur les trois derniers mois
	public static function getStatsCA(){
		$req = Database::connect()->prepare(
			"SELECT SUM(prix_final) AS total FROM client_reservation WHERE times BETWEEN ? AND ?"
		);
		
		$req->execute([strtotime("-1 months"), time()]);
		$actualMonth = $req->fetch();
		
		if($actualMonth['total'] == NULL){
			$actualMonth['total'] = 0;
		}
		
		// MOIS PRECEDENT
		$req2 = Database::connect()->prepare(
			"SELECT SUM(prix_final) AS total FROM client_reservation WHERE times BETWEEN ? AND ?"
		);
		
		$req2->execute([strtotime("-2 months"), strtotime("-1 months")]);
		$firstMonth = $req2->fetch();
		
		if($firstMonth['total'] == NULL){
			$firstMonth['total'] = 0;
		}
		
		// IL Y A DEUX MOIS
		$req3 = Database::connect()->prepare(
			"SELECT SUM(prix_final) AS total FROM client_reservation WHERE times BETWEEN ? AND ?"
		);
		
		$req3->execute([strtotime("-3 months"), strtotime("-2 months")]);
		$secondMonth = $req3->fetch();
		
		if($secondMonth['total'] == NULL){
			$secondMonth['total'] = 0;
		}
		
		// AU TOTAL
		$req4 = Database::connect()->query(
			"SELECT SUM(prix_final) AS total FROM client_reservation"
		);
		
		$total = $req4->fetch();
		
		if($total['total'] == NULL){
			$total['total'] = 0;
		}
		
		return $tab = [$actualMonth['total'], $firstMonth['total'], $secondMonth['total'], $total['total']];
	}
}