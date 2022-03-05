<?php

class Client
{
    private $id;
    private $email;
    private $nom;
    private $prenom;
    private $ville;
    private $cp;
    private $adresse;
    private $points;
    private $password;
    private $admin;

    //Vérifie si il existe une session et si c'est la cas on vérifie sa validitée
    public function __construct() {
        if(isset($_COOKIE['session']) && $_COOKIE['session'] != null && !empty($_COOKIE['session'])) {
            $this->checkConnexion(true);
        }
    }

    //chiffre le mot de passe du client
    private function chiffrePassword($password) {
        return md5($password);
    }

    //inscription du client
    public function register($nom, $prenom, $email, $password, $adresse, $cp, $ville) {
        $retour = false;

        $checkEmail = Database::connect()->prepare("SELECT id FROM client WHERE email = ?");
        $checkEmail->execute([$email]);

        if($checkEmail->rowCount() == 0) {
            $req = Database::connect()->prepare("INSERT INTO client (nom,prenom,email,password,adresse,cp,ville) VALUE (?,?,?,?,?,?,?)");
            $req->execute([$nom, $prenom, $email, $this->chiffrePassword($password), $adresse, $cp, $ville]);

            $this->checkConnexion(false, $email, $password);
            $retour = true;
        }

        return $retour;
    }

    //vérifie la connexion du client à partir de son token ou bien des informations envoyées depuis la page de login
    public function checkConnexion($byToken, $email = null, $password = null) {
        if(!$byToken) {
            $connexion = Database::connect()->prepare("SELECT * FROM client WHERE email = ? AND password = ?");
            $connexion->execute([$email, $this->chiffrePassword($password)]);
        } else {
            $connexion = Database::connect()->prepare("SELECT * FROM client WHERE token = ?");
            $connexion->execute([$_COOKIE['session']]);
        }

        if($connexion->rowCount() > 0) {
            $req = $connexion->fetch();
            $this->createConnexion($req['id'], $req['email'], $req['nom'], $req['prenom'], $req['ville'], $req['cp'], $req['adresse'], $req['points'], $byToken, $req['password'], $req['admin']);
        } else if($byToken) {
            $this->deconnexion();
        }
    }

    //constructeur de l'objet
    public function createConnexion($id, $email, $nom, $prenom, $ville, $cp, $adresse, $points, $byToken, $password, $admin) {
        $this->id = $id;
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->ville = $ville;
        $this->cp = $cp;
        $this->adresse = $adresse;
        $this->points = $points;
        $this->password = $password;
        $this->admin = $admin;

        if(!$byToken)
            $this->genereSession();
    }

    //génère un token pour garder la session du client active à partir d'un cookie
    public function genereSession() {
        $session = Html::token(100);
        
        $req = Database::connect()->prepare("UPDATE client SET token = ? WHERE id = ?");
        $req->execute([$session, $this->id]);

        setcookie("session", $session, time()+432000);
    }

    //déconnexion du client
    public function deconnexion() {

        if(isset($_COOKIE['session'])) {
            setcookie('session');
            unset($_COOKIE['session']);
        }

        $req = Database::connect()->prepare("UPDATE client SET token = ? WHERE id = ?");
        $req->execute(["", $this->id]);
    }

    //Sélectionne les réservations du client
    public function getReservations(){
    	$retour = null;
    	
    	$req = Database::connect()->prepare(
    		"SELECT cr.id, cr.prix_final, ls.image, ls.description, pd.libelle AS depart, pa.libelle AS arrivee, t.date_depart FROM client_reservation cr
					  INNER JOIN traversee t ON t.id = cr.traversee
					  INNER JOIN liaison l ON l.id = t.liaison
					  INNER JOIN liaison_secteur ls ON l.secteur = ls.id
                      INNER JOIN port pd ON pd.id = l.depart
                      INNER JOIN port pa ON pa.id = l.arrivee
					  WHERE cr.client = ?
					  ORDER BY t.date_depart ASC, cr.id ASC");
	
	    $req->execute([$this->id]);
	    
	    if($req->rowCount() > 0) {
		    $retour = $req->fetchAll();
	    }

		return $retour;
    }


    //Sélectionne le nb de places d'une réservation à partir de son identifiant
    public function getPlaces($idResa){
    	$retour = null;
	
	    $req = Database::connect()->prepare(
		    "SELECT tt.libelle, cc.nombre FROM client_reservation cr
                    INNER JOIN client_caracteristique cc ON cc.reservation_id = cr.id
                    INNER JOIN transport_type tt ON tt.id = cc.transport_type
                    WHERE cr.id = ?");
	
	    $req->execute([$idResa]);
	
	    if($req->rowCount() > 0) {
		    $retour = $req->fetchAll();
	    }
	
	    return $retour;
    }


    //Renvoie le détail d'une réservation
    public function getDetailsResa($idResa){
	    $retour = null;
	
	    $req = Database::connect()->prepare(
		    "SELECT cr.prix_final, ls.image, ls.description, pd.libelle AS depart, pa.libelle AS arrivee, t.date_depart FROM client_reservation cr
					  INNER JOIN traversee t ON t.id = cr.traversee
					  INNER JOIN liaison l ON l.id = t.liaison
					  INNER JOIN liaison_secteur ls ON l.secteur = ls.id
                      INNER JOIN port pd ON pd.id = l.depart
                      INNER JOIN port pa ON pa.id = l.arrivee
					  WHERE cr.id = ?
					  ORDER BY t.date_depart DESC");
	
	    $req->execute([$idResa]);
	
	    if($req->rowCount() > 0) {
		    $retour = $req->fetch();
	    }
	
	    return $retour;
    }

    //Ajoute une réservation
    public function addReservation($traversee){
        $prix_final = 0;
        $qtnCat = [];

        $prices = Reservation::getPrices($traversee);
        $stock = Reservation::getStock($traversee);

        if($prices != null && $stock != null) {

            for($i = 0; $i < count($prices); $i++) {
                if(isset($_POST[$prices[$i]['id']])) {

                    $qtn = $_POST[$prices[$i]['id']];
                    $qtnCat[$prices[$i]['categorie']] = $qtnCat[$prices[$i]['categorie']] + $qtn;

                    if(($stock[$prices[$i]['categorie']]['reste']-$qtnCat[$prices[$i]['categorie']]) < 0) {
                        throw new Exception('Impossible de réserver votre traversée, car il ne reste plus suffisamment de places.');
                    }

                    if($qtn > 0) {
                        $prix_final = $prix_final + ($prices[$i]['prix'] * $qtn);
                    }
                }
            }

            if($prix_final == 0) {
                throw new Exception('Impossible de réserver cette destination, les critères doivent être remplis.');
            }

            $req = Database::connect()->prepare("INSERT INTO client_reservation (client,traversee,prix_final,times) VALUE (?,?,?,?)");
            $req->execute([$this->id, $traversee, $prix_final, time()]);

            $reservationId = Database::connect()->lastInsertId();

            for($i = 0; $i < count($prices); $i++) {
                if(isset($_POST[$prices[$i]['id']])) {
                    $qtn = $_POST[$prices[$i]['id']];
                    if($qtn > 0) {
                        $req = Database::connect()->prepare("INSERT INTO client_caracteristique (reservation_id,transport_type,nombre) VALUE (?,?,?)");
                        $req->execute([$reservationId, $prices[$i]['id'], $qtn]);
                    }
                }
            }

            $this->update();

        } else {
            throw new Exception('Impossible de réserver votre traversée, car il le voyage n\'est plus disponible.');
        }


        return "Félicitations ! Votre traversée est maintenant réservée.";
    }

    //Met à jour les infos client dans l'objet
    public function update()
    {
        $req = Database::connect()->prepare("SELECT * FROM client WHERE token = ?");
        $req->execute([$_COOKIE['session']]);

        if ($req->rowCount() > 0) {
            $req = $req->fetch();
            $this->createConnexion($req['id'], $req['email'], $req['nom'], $req['prenom'], $req['ville'], $req['cp'], $req['adresse'], $req['points'], true, $req['password'], $req['admin']);
        }
    }

    // Permet à un utilisateur de changer son mot de passe
	// Reçoit deux paramètres : l'ancien et le nouveau mot de passe : STRING
    public function changePassword($ancien, $nouveau){
    	$retour = null;
    	
    	if($this->chiffrePassword($ancien) == $this->password){
    	    $newPassword = $this->chiffrePassword($nouveau);
    	    $req = Database::connect()->prepare("UPDATE client set password = ? WHERE id = ?");
    	    $req->execute([$newPassword, $this->id]);
    	    
    	    $retour = "ok";
	    }else{
    		$retour = "L'ancien mot de passe n'est pas correct.";
	    }
	    
	    return $retour;
    }

    //Envoie un message
    public function sendMessage($nom, $email, $sujet, $message) {
        $req = Database::connect()->prepare("INSERT INTO contact (nom,email,sujet,message) VALUE (?,?,?,?)");
        $req->execute([$nom, $email, $sujet, $message]);
    }
    
    // Permet à un utilisateur de changer son adresse mail
	// Reçoit en paramètre la nouvelle adresse mail : STRING
	public function changeMail($nouvelle){
    	$retour = null;
		$checkEmail = Database::connect()->prepare("SELECT id FROM client WHERE email = ?");
		$checkEmail->execute([$nouvelle]);
		
		if($checkEmail->rowCount() == 0){
			$req = Database::connect()->prepare("UPDATE client set email = ? WHERE id = ?");
			$req->execute([$nouvelle, $this->id]);
			
			$retour = "ok";
		}else {
			$retour = "L'adresse mail est déjà utilisée.";
		}
		
		return $retour;
	}

    //si le client est en ligne
    public function getOnline() {
        return $this->id != null;
    }
	
	/**
	 * @return adresse
	 */
	public function getAdresse()
	{
		return strip_tags($this->adresse);
	}
	
	/**
	 * @return code postal
	 */
	public function getCp()
	{
		return strip_tags($this->cp);
	}
	
	/**
	 * @return l'email
	 */
	public function getEmail()
	{
		return strip_tags($this->email);
	}
	
	/**
	 * @return le nom
	 */
	public function getNom()
	{
		return strip_tags($this->nom);
	}
	
	/**
	 * @return les points de fidélités
	 */
	public function getPoints()
	{
		return $this->points;
	}
	
	/**
	 * @return le prénom
	 */
	public function getPrenom()
	{
		return strip_tags($this->prenom);
	}
	
	/**
	 * @return la ville
	 */
	public function getVille()
	{
		return strip_tags($this->ville);
	}
	
	/**
	 * @return si le client est admin
	 */
	public function getAdmin()
	{
		return $this->admin;
	}
}