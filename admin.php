<?php

require "global.php";

if($client->getAdmin()) :
    define("TITLE", "Administation");
    require TPL."header.php";
	$admin = new Admin();
	
	// Modification d'une liaison
    // On regarde si les données existent en POST
	if(isset($_GET['editLiaison']) && isset($_POST['secteur']) && isset($_POST['depart']) && isset($_POST['arrivee']) && isset($_POST['distance'])){
	    
	    // On récupére les données
        $secteur = $_POST['secteur'];
        $depart = $_POST['depart'];
        $arrive = $_POST['arrivee'];
        $distance = $_POST['distance'];
    
        // Requête
        $req = Database::connect()->prepare(
            "UPDATE liaison
                      SET secteur = ?, depart = ?, arrivee = ?, distance = ?
                      WHERE id = ?"
        );

        $req->execute([$secteur, $depart, $arrive, $distance, $_GET['editLiaison']]);
        $message = ["success", "Votre modification a bien été effectuée !"];
    }
	
    // Ajout d'une liaison
	// On regarde si les données existent en POST
	if(isset($_GET['addLiaison']) && isset($_POST['secteur']) && isset($_POST['depart']) && isset($_POST['arrivee']) && isset($_POST['distance'])){
	    
	    // On récupére les données
		$secteur = $_POST['secteur'];
		$depart = $_POST['depart'];
		$arrive = $_POST['arrivee'];
		$distance = $_POST['distance'];
		
		// Requête
		$req = Database::connect()->prepare(
			"INSERT INTO liaison(secteur, distance, depart, arrivee)
                    VALUES(?, ?, ?, ?)"
		);
		
		$req->execute([$secteur, $distance, $depart, $arrive]);
		$message = ["success", "Votre liaison a bien été ajoutée !"];
	}
	
	// Modification d'une traversée
	// On regarde si les données existent en POST
	if(isset($_GET['editTraversee']) && isset($_POST['liaison']) && isset($_POST['bateau'])  && isset($_POST['dateD']) && isset($_POST['dateA'])) {
		
		// On récupére les données
	    $bateau = $_POST['bateau'];
        $liaison = $_POST['liaison'];
        $dateD = strtotime($_POST['dateD']);
        $dateA = strtotime($_POST['dateA']);
        $id = $_GET['editTraversee'];

        // Si la date d'arrivée est inférieure à la date de départ = ERREUR
        if($dateD > $dateA) {
            $message = ["error", "La date d'arrivée ne peut pas être inférieur à la date de départ."];
        } else {
            // Sinon on modifie la traversée
            Admin::updateTraversee($id, $bateau, $liaison, $dateD, $dateA);
            $message = ["success", "Votre traversée a bien été modifiée !"];
        }
    }
	
	// Ajout d'une traversée
	// On regarde si les données existent en POST
    if(isset($_GET['addTraversee']) && isset($_POST['liaison']) && isset($_POST['bateau'])  && isset($_POST['dateD']) && isset($_POST['dateA'])) {
	
	    // On récupére les données
	    $bateau = $_POST['bateau'];
        $liaison = $_POST['liaison'];
        $dateD = strtotime($_POST['dateD']);
        $dateA = strtotime($_POST['dateA']);
	
	    // Si la date d'arrivée est inférieure à la date de départ = ERREUR
        if($dateD > $dateA) {
            $message = ["error", "La date d'arrivée ne peut pas être inférieur à la date de départ."];
        } else {
	        // Sinon on ajoute la traversée
	        Admin::addTraversee($bateau, $liaison, $dateD, $dateA);
            $message = ["success", "Votre traversée a bien été ajoutée !"];
        }
    }
	
	// Modification d'une période
	// On regarde si les données existent en POST
    if(isset($_GET['editPeriode']) && isset($_POST['liaison']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
	
	    // On récupére les données
        $liaison = $_POST['liaison'];
        $dateD = strtotime($_POST['date_debut']);
        $dateF = strtotime($_POST['date_fin']);
        $id = $_GET['editPeriode'];
	
	    // Si la date de début est inférieure à la date de fin = ERREUR
        if($dateD > $dateF) {
            $message = ["error", "La date de debut ne peut pas être inférieur à la date de fin."];
        } else {
            // Sinon on modifie la période
            Admin::updatePeriode($id, $dateD, $dateF, $liaison);
            $message = ["success", "La période a bien été modifiée !"];
        }
    }
	
	// Ajout d'une période
	// On regarde si les données existent en POST
    if(isset($_GET['addPeriode']) && isset($_POST['liaison']) && isset($_POST['date_debut'])  && isset($_POST['date_fin'])) {
	
	    // On récupére les données
	    $liaison = $_POST['liaison'];
        $dateD = strtotime($_POST['date_debut']);
        $dateF = strtotime($_POST['date_fin']);
	
	    // Si la date de début est inférieure à la date de fin = ERREUR
	    if($dateD > $dateF) {
            $message = ["error", "La date de debut ne peut pas être inférieur à la date de fin."];
        } else {
		    // Sinon on ajoute la période
		    Admin::addPeriode($dateD, $dateF, $liaison);
            $message = ["success", "La période a bien été ajoutée !"];
        }
    }

    // Modification d'une caractéristique (prix)
    if(isset($_GET['lesCaracteristiques']) && isset($_POST['prix']) && isset($_POST['id'])) {
	    
	    // On récupère les données
        $prix = $_POST['prix'];
        $idPeriode = $_GET['lesCaracteristiques'];
        $id = $_POST['id'];

        // On modifie la caractéristique
        Admin::updateCaracteristiquesPeriode($idPeriode, $id, $prix);
        $message = ["success", "Le caracteristique a bien été changé !"];
    }
	
	// Ajout d'une caractéristique (prix)
	if(isset($_GET['addTarification']) && isset($_POST['periode']) && isset($_POST['transport_type']) && isset($_POST['prix'])) {
		
		// On récupère les données
		$prix = $_POST['prix'];
        $periode = $_POST['periode'];
        $transport_type = $_POST['transport_type'];
        
		// On ajoute la caractéristique
		$message = Admin::addCaracteristiquesPeriode($periode, $transport_type, $prix);
    }

    //Suppression d'un message
    if(isset($_GET['deleteMessage'])) {
        $message = Admin::deleteMessages($_GET['deleteMessage']);
    }
?>

<section class="about-banner relative">
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="about-content col-lg-12">
				<h1 class="text-white">
					Espace administratif
				</h1>
			</div>
		</div>
	</div>
</section>

<section class="destinations-area section-gap">
	<div class="container">
<!--		<div class="text-center mb-20">-->
<!--			<button id="btn-liaisons" class="genric-btn primary radius">Les liaisons</button>-->
<!--			<button id="btn-stats" class="genric-btn info radius">Statistiques</button>-->
<!--		</div>-->
		<div class="bg-white rounded p-20">
<!--			<div id="lesLiaisons">-->
<!--				<h4>Gestions des liaisons</h4>-->
<!--                <div class="row">-->
<!--                    <div class="col-lg-5 p-4">-->
<!--                    dssd-->
<!--                    </div>-->
<!--                    <div class="col-lg-5 p-4">-->
<!--                        sdfe-->
<!--                    </div>-->
<!--                </div>-->
<!--			</div>-->
<!--			-->
<!--			<div id="lesStats" class="d-none">-->
<!--				<h4>Les statistiques</h4>-->
<!--			</div>-->
            
            <!-- On vérifie quel "GET" on a en argument, puis on fait l'affichage -->
            <?php if(isset($_GET['lesLiaisons'])) : ?>
                <h3 class="mb-2">Liste des liaisons</h3>
                <table class="resa-table">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Port de départ</th>
                        <th>Port d'arrivé</th>
                        <th>Distance <small>en km</small></th>
                        <th>Secteur</th>
                        <th>Modification</th>
                    </tr>
                    </thead>
	                <?php
	                $liaisons = Admin::getLiaisons();
                    if($liaisons == null):
                        ?>
                        <div class="errorPopup w-50 m-auto bg-error">Il y a actuellement aucune période !</div><br>
                    <?php
                    else:

	                for($i = 0; $i < count($liaisons); $i++) : ?>
                        <tr>
                            <td>
                                <?= $liaisons[$i]['id']; ?>
                            </td>
                            <td>
                                <?= $liaisons[$i]['depart']; ?>
                            </td>
                            <td>
                                <?= $liaisons[$i]['arrivee']; ?>
                            </td>
                            <td>
                                <?= $liaisons[$i]['distance']; ?>
                            </td>
                            <td>
                                <?= $liaisons[$i]['secteur']; ?>
                            </td>
                            <td>
                                <div class="bg-warning text-center br-5" style="width: 75px;">
                                    <a href="?editLiaison=<?= $liaisons[$i]['id'] ?>">
                                        <h4 class="p-2 text-white">
                                            <i class="fa fa-edit"></i>
                                        </h4>
                                    </a>
                                </div>
                            </td>
                        </tr>
	                <?php endfor; ?>
                    <?php endif ?>
                </table>
            <?php endif ?>
            
            <?php if(isset($_GET['editLiaison'])) :
                $idLiaison = $_GET['editLiaison'];
                $uneLiaison = Admin::getUneLiaison($idLiaison);
                if($uneLiaison == null):
                    ?>
                    <div class="errorPopup w-50 m-auto bg-error">Cette liaison n'existe pas !</div><br>
                    <?php
                else:
            ?>
            <h3 class="text-center mb-2">Modification de la liaison n° <?= $idLiaison; ?></h3>
            <?php if(isset($message) && !empty($message)) : ?>
                <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
            <?php endif; ?>
                <form method="POST" action="?editLiaison=<?= $idLiaison ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Port de départ</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="depart">
		                            <?= Html::genereOption(Admin::getPorts(), "id", "libelle", $uneLiaison['depart']); ?>
                                </select>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Port d'arrivé</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="arrivee">
		                            <?= Html::genereOption(Admin::getPorts(), "id", "libelle", $uneLiaison['arrivee']); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Distance <small>EN KM</small></h5>
                                <input type="number" name="distance" placeholder="<?= $uneLiaison['distance'] ?>" value="<?= $uneLiaison['distance'] ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Secteur</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="secteur">
	                                <?= Html::genereOption(Destination::getListLiaisons(), "id", "nom", $uneLiaison['secteur']); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="genric-btn primary radius mt-15">Modifier</button>
                    </center>
                </form>
                <?php endif; ?>
            <?php endif; ?>
			
			<?php if(isset($_GET['addLiaison'])) : ?>
                <h3 class="text-center mb-2">Ajout d'une nouvelle liaison</h3>
				<?php if(isset($message) && !empty($message)) : ?>
                    <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
				<?php endif; ?>
                <form method="POST" action="?addLiaison">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Port de départ</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="depart">
									<?= Html::genereOption(Admin::getPorts(), "id", "libelle"); ?>
                                </select>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Port d'arrivé</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="arrivee">
									<?= Html::genereOption(Admin::getPorts(), "id", "libelle"); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Distance <small>EN KM</small></h5>
                                <input type="number" name="distance" placeholder="Distance" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Secteur</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="secteur">
									<?= Html::genereOption(Destination::getListLiaisons(), "id", "nom"); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="genric-btn primary radius mt-15">Ajouter</button>
                    </center>
                </form>
			<?php endif ?>
			
			<?php if(isset($_GET['lesTraversees'])) : ?>
                <h3 class="mb-2">Liste des traversées</h3>
                <table class="resa-table">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Bateau</th>
                        <th>Port de départ</th>
                        <th>Date de départ</th>
                        <th>Port d'arrivé</th>
                        <th>Date d'arrivée</th>
                        <th>Modification</th>
                    </tr>
                    </thead>
					<?php
					$traversees = Admin::getTraversees();
					if($traversees == null):
                    ?>
                     <div class="errorPopup w-50 m-auto bg-error">Il y a actuellement aucune traversée !</div><br>
                    <?php
                    else:

					for($i = 0; $i < count($traversees); $i++) : ?>
                        <tr>
                            <td>
                                <?= $traversees[$i]['id']; ?>
                            </td>
                            <td>
		                        <?= $traversees[$i]['bateau']; ?>
                            </td>
                            <td>
								<?= $traversees[$i]['depart']; ?>
                            </td>
                            <td>
								<?= strftime("%e %B %Y", $traversees[$i]['dateD']).' à '.date("H:i",$traversees[$i]['dateD']); ?>
                            </td>
                            <td>
								<?= $traversees[$i]['arrivee']; ?>
                            </td>
                            <td>
								<?= strftime("%e %B %Y", $traversees[$i]['dateA']).' à '.date("H:i",$traversees[$i]['dateA']); ?>
                            </td>
                            <td>
                                <div class="bg-warning text-center br-5" style="width: 75px;">
                                    <a href="?editTraversee=<?= $traversees[$i]['id'] ?>">
                                        <h4 class="p-2 text-white">
                                            <i class="fa fa-edit"></i>
                                        </h4>
                                    </a>
                                </div>
                            </td>
                        </tr>
					<?php endfor; ?>
                    <?php endif ?>
                </table>
			    <?php endif ?>

			
			<?php if(isset($_GET['editTraversee'])) :
				$idTraversee = $_GET['editTraversee'];
				$uneTraversee = Admin::getUneTraversee($idTraversee);
				if($uneTraversee == null): ?>
                    <div class="errorPopup w-50 m-auto bg-error">Cette traversée existe pas !</div><br>
                <?php else: ?>
                <h3 class="text-center mb-2">Modification de la traversée</h3>
				<?php if(isset($message) && !empty($message)) : ?>
                <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
			<?php endif; ?>
                <form method="POST" action="?editTraversee=<?= $idTraversee ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Bateau</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="bateau">
									<?= Html::genereOption(Admin::getBateaux(), "id", "libelle", $uneTraversee['bateau']); ?>
                                </select>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Liaison</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="liaison">
                                    <?= Html::genereOption(Admin::getLiaisons(), "id", "value", $uneTraversee['liaison']); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Date de départ</small></h5>
                                <input type="datetime-local" name="dateD" value="<?= date("Y-m-d", $uneTraversee['dateD']) ?>T<?= date("H:i", $uneTraversee['dateD']) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Date d'arrivée</h5>
                                <input type="datetime-local" name="dateA" value="<?= date("Y-m-d", $uneTraversee['dateA']) ?>T<?= date("H:i", $uneTraversee['dateA']) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="genric-btn primary radius mt-15">Modifier</button>
                    </center>
                </form>
                <?php endif; ?>
			<?php endif; ?>
			
			<?php if(isset($_GET['addTraversee'])) : ?>
                <h3 class="mb-2">Ajout d'une nouvelle traversee</h3>
                <?php if(isset($message) && !empty($message)) : ?>
                    <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
                <?php endif; ?>
                <form method="POST" action="?addTraversee">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Bateau</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="bateau">
                                    <?= Html::genereOption(Admin::getBateaux(), "id", "libelle"); ?>
                                </select>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Liaison</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="liaison">
                                    <?= Html::genereOption(Admin::getLiaisons(), "id", "value"); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Date de départ</small></h5>
                                <input type="datetime-local" name="dateD" value="<?= date("Y-m-d", time()) ?>T<?= date("H:i", time()) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Date d'arrivée</h5>
                                <input type="datetime-local" name="dateA" value="<?= date("Y-m-d", time()+60*60) ?>T<?= date("H:i", time()+60*60) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="genric-btn primary radius mt-15">Ajouter</button>
                    </center>
                </form>
			<?php endif ?>

            <?php if(isset($_GET['addTarification'])) : ?>
                <h3 class="mb-2">Ajout d'une nouvelle tarification</h3>
                <?php if(isset($message) && !empty($message)) : ?>
                    <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
                <?php endif; ?>
                <form method="POST" action="?addTarification">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Période</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="periode">
                                    <?= Html::genereOption(Admin::getPeriodesForOption(), "id", "value", isset($_POST['periode']) ? $_POST['periode'] : null); ?>
                                </select>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Type</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="transport_type">
                                    <?= Html::genereOption(Admin::getTransportType(), "id", "libelle", isset($_POST['transport_type']) ? $_POST['transport_type'] : null); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Prix</small></h5>
                                <input value="<?= @$_POST['prix']; ?>" type="number" name="prix" placeholder="10.0" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="genric-btn primary radius mt-15">Ajouter</button>
                    </center>
                </form>
            <?php endif ?>

            <?php if(isset($_GET['lesPeriodes'])) : ?>
                <h3 class="mb-2">Liste des périodes</h3>
                <table class="resa-table">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Liaison</th>
                        <th>Tarification</th>
                        <th>Modification</th>
                    </tr>
                    </thead>
                    <?php
                    $periodes = Admin::getPeriodes();
                    if($periodes == null):
                        ?>
                        <div class="errorPopup w-50 m-auto bg-error">Il y a actuellement aucune période !</div><br>
                    <?php
                    else:

                        for($i = 0; $i < count($periodes); $i++) : ?>
                            <tr>
                                <td>
                                    <?= $periodes[$i]['id']; ?>
                                </td>
                                <td>
                                    <?= strftime("%e %B %Y", $periodes[$i]['date_debut']); ?>
                                </td>
                                <td>
                                    <?= strftime("%e %B %Y", $periodes[$i]['date_fin']); ?>
                                </td>
                                <td>
                                    <?= $periodes[$i]['liaison']; ?>
                                </td>
                                <td>
                                    <div class="bg-warning text-center br-5" style="width: 75px;">
                                        <a href="?lesCaracteristiques=<?= $periodes[$i]['id'] ?>">
                                            <h4 class="p-2 text-white">
                                                <i class="fa fa-edit"></i>
                                            </h4>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="bg-warning text-center br-5" style="width: 75px;">
                                        <a href="?editPeriode=<?= $periodes[$i]['id'] ?>">
                                            <h4 class="p-2 text-white">
                                                <i class="fa fa-edit"></i>
                                            </h4>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    <?php endif ?>
                </table>
            <?php endif ?>


            <?php if(isset($_GET['editPeriode'])) :
                $idPeriode = $_GET['editPeriode'];
                $unePeriode = Admin::getUnePeriode($idPeriode);
                if($unePeriode == null): ?>
                    <div class="errorPopup w-50 m-auto bg-error">Cette période n'existe pas !</div><br>
                <?php else: ?>
                    <h3 class="text-center mb-2">Modification de la période n° <?= $idPeriode; ?></h3>
                    <?php if(isset($message) && !empty($message)) : ?>
                        <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
                    <?php endif; ?>
                    <form method="POST" action="?editPeriode=<?= $idPeriode ?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mt-10">
                                    <h5 class="mb-1">Liaison</h5>
                                    <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="liaison">
                                        <?= Html::genereOption(Admin::getLiaisons(), "id", "value", $unePeriode['liaison']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mt-10">
                                    <h5 class="mb-1">Date début</small></h5>
                                    <input type="date" name="date_debut" value="<?= date("Y-m-d", $unePeriode['date_debut']) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                                </div>
                                <div class="mt-10">
                                    <h5 class="mb-1">Date fin</h5>
                                    <input type="date" name="date_fin" value="<?= date("Y-m-d", $unePeriode['date_fin']) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="submit" class="genric-btn primary radius mt-15">Modifier</button>
                        </center>
                    </form>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(isset($_GET['addPeriode'])) : ?>
                <h3 class="mb-2">Ajout d'une nouvelle période</h3>
                <?php if(isset($message) && !empty($message)) : ?>
                    <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
                <?php endif; ?>
                <form method="POST" action="?addPeriode">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Liaison</h5>
                                <select style="padding:0 10px; background: #F8F8F8;" class="form-control" name="liaison">
                                    <?= Html::genereOption(Admin::getLiaisons(), "id", "value"); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-10">
                                <h5 class="mb-1">Date début</small></h5>
                                <input type="date" name="date_debut" value="<?= date("Y-m-d", time()) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                            <div class="mt-10">
                                <h5 class="mb-1">Date fin</h5>
                                <input type="date" name="date_fin" value="<?= date("Y-m-d", time()+60*60*7) ?>" class="single-input-primary br-5" style="background: #f8f8f8;" required>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="genric-btn primary radius mt-15">Ajouter</button>
                    </center>
                </form>
            <?php endif ?>

            <?php if(isset($_GET['lesCaracteristiques'])) : ?>
                <h3 class="mb-2">Liste des caractéristiques de la période n° <?= $_GET['lesCaracteristiques']; ?></h3>
                <table class="resa-table">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Tarification</th>
                        <th>Modifier</th>
                    </tr>
                    </thead>
                    <?php
                    $idPeriode = $_GET['lesCaracteristiques'];
                    $caracteristiques = Admin::getCaracteristiqueForPeriode($idPeriode);
                    if($caracteristiques == null):
                        ?>
                        <div class="errorPopup w-50 m-auto bg-error">Il y a actuellement aucun caracteristique pour cette période !</div><br>
                    <?php
                    else:

                    if(isset($message) && !empty($message)) : ?>
                        <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
                    <?php
                        endif;

                        for($i = 0; $i < count($caracteristiques); $i++) : ?>
                            <tr>
                                <td>
                                    <?= $caracteristiques[$i]['libelle']; ?>
                                </td>
                                <form method="POST" action="?lesCaracteristiques=<?= $idPeriode; ?>">
                                    <td>
                                        <input type="hidden" name="id" value="<?= $caracteristiques[$i]['id']; ?>">
                                        <input type="number" name="prix" value="<?= $caracteristiques[$i]['prix']; ?>" placeholder="prix" class="br-5" style="background: #f8f8f8;" required>
                                    </td>
                                    <td>
                                        <button class="p-2 text-white bg-warning border-0 br-5" style="width: 75px;cursor: pointer;">
                                            <h4 class="text-white"><i class="fa fa-edit"></i></h4>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        <?php endfor; ?>
                    <?php endif ?>
                </table>
            <?php endif ?>

            <?php if(isset($_GET['message'])) : ?>
                <h3 class="mb-2">Liste des messages reçus</h3>
                <table class="resa-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Sujet</th>
                        <th>Message</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>
                    <?php
                    $listeMessage = Admin::getMessages();
                    if($listeMessage == null):
                        ?>
                        <div class="errorPopup w-50 m-auto bg-error">Il y a actuellement aucun message!</div><br>
                    <?php
                    else:

                        if(isset($message) && !empty($message)) : ?>
                            <div class="errorPopup w-50 m-auto bg-<?= $message[0] ?>"><?= $message[1] ?></div><br>
                        <?php
                        endif;

                        for($i = 0; $i < count($listeMessage); $i++) : ?>
                            <tr>
                                <td>
                                    <?= $listeMessage[$i]['id']; ?>
                                </td>
                                <td>
                                    <?= $listeMessage[$i]['nom']; ?>
                                </td>
                                <td>
                                    <?= $listeMessage[$i]['email']; ?>
                                </td>
                                <td>
                                    <?= $listeMessage[$i]['sujet']; ?>
                                </td>
                                <td>
                                    <?= $listeMessage[$i]['message']; ?>
                                </td>
                                <form method="POST" action="?message&deleteMessage=<?= $listeMessage[$i]['id']; ?>">
                                    <td>
                                        <button class="p-2 text-white bg-danger border-0 br-5" style="width: 75px;cursor: pointer;">
                                            <h4 class="text-white"><i class="fa fa-trash"></i></h4>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        <?php endfor; ?>
                    <?php endif ?>
                </table>
            <?php endif ?>
			
			<?php if(isset($_GET['lesStats'])) : ?>
                <h3 class="mb-2">Les statistiques de ces 3 derniers mois</h3>
                <center>
                    <div id="resaChart"></div>
                    <div id="caChart"></div>
                    <div id="passagerTotalChart"></div>
                </center>
                <div id="passagerChart"></div>
			<?php endif ?>
		</div>
	</div>
</section>

<?php
require TPL."footer.php";
?>

<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/"; ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
<script>
    zingchart.THEME="classic";

    var myConfig = {
        "layout":"h",
        "globals":{
            "font-family":"Roboto"
        },
        "graphset":[
            {
                "type":"pie",
                "background-color":"none",
                "legend":{
                    "background-color":"none",
                    "border-width":0,
                    "shadow":false,
                    "layout":"float",
                    "margin":"auto auto 16% auto",
                    "marker":{
                        "border-radius":5,
                        "border-width":0
                    },
                    "item":{
                        "color":"%backgroundcolor"
                    }
                },
                "title":{
                    "text":"Les réservations",
                    "background-color":"none",
                    "font-size":16,
                    "color":"#626262",
                    "x":0,
                    "y":80
                },
                "plotarea":{
                    "background-color":"#FFFFFF",
                    "border-color":"none",
                    "border-width":1,
                    "border-radius":5,
                    "margin":"auto",
                    "width":"100px",
                },
                "labels":[
                    {
                        "x":"45%",
                        "y":"44%",
                        "width":"10%",
                        "text":"<b>TOTAL</b><br><small style='font-size: 15px;'><?php echo Admin::getStatsReservations()[3] ?> réservations</small>",
                        "font-size":24
                    }
                ],
                "plot":{
                    "size":120,
                    "slice":70,
                    "margin-right":100,
                    "border-width":0,
                    "shadow":0,
                    "value-box":{
                        "visible":false
                    },
                    "tooltip":{
                        "text":"%v réservation(s)",
                        "shadow":false,
                        "border-radius":5
                    }
                },
                "series":[
                    {
                        "values":[<?php echo Admin::getStatsReservations()[0] ?>],
                        "text":"<?php echo ucfirst(strftime("%B", time())); ?>",
                        "background-color":"#6CCFDF"
                    },
                    {
                        "values":[<?php echo Admin::getStatsReservations()[1] ?>],
                        "text":"<?php echo ucfirst(strftime("%B", strtotime("-1 months"))); ?>",
                        "background-color":"#E76D45"
                    },
                    {
                        "values":[<?php echo Admin::getStatsReservations()[2] ?>],
                        "text":"<?php echo ucfirst(strftime("%B", strtotime("-2 months"))); ?>",
                        "background-color":"#55BA72"
                    }
                ]
            }
        ]
    };

    zingchart.render({
        id : 'resaChart',
        data : myConfig,
    });

    var myConfig2 = {
        "layout":"h",
        "globals":{
            "font-family":"Roboto"
        },
        "graphset":[
            {
                "type":"pie",
                "background-color":"none",
                "legend":{
                    "background-color":"none",
                    "border-width":0,
                    "shadow":false,
                    "layout":"float",
                    "margin":"auto auto 16% auto",
                    "marker":{
                        "border-radius":5,
                        "border-width":0
                    },
                    "item":{
                        "color":"%backgroundcolor"
                    }
                },
                "title":{
                    "text":"Passagers transportés",
                    "background-color":"none",
                    "font-size":16,
                    "color":"#626262",
                    "x":0,
                    "y":80
                },
                "plotarea":{
                    "background-color":"#FFFFFF",
                    "border-color":"none",
                    "border-width":1,
                    "border-radius":5,
                    "margin":"auto",
                    "width":"100px",
                },
                "labels":[
                    {
                        "x":"45%",
                        "y":"44%",
                        "width":"10%",
                        "text":"<b>TOTAL</b><br><small style='font-size: 15px;'><?php echo Admin::getStatsPassagerTotal()[3] ?> passagers</small>",
                        "font-size":24
                    }
                ],
                "plot":{
                    "size":120,
                    "slice":70,
                    "margin-right":100,
                    "border-width":0,
                    "shadow":0,
                    "value-box":{
                        "visible":false
                    },
                    "tooltip":{
                        "text":"%v passager(s)",
                        "shadow":false,
                        "border-radius":5
                    }
                },
                "series":[
                    {
                        "values":[<?php echo Admin::getStatsPassagerTotal()[0] ?>],
                        "text":"<?php echo ucfirst(strftime("%B", time())); ?>",
                        "background-color":"#6CCFDF"
                    },
                    {
                        "values":[<?php echo Admin::getStatsPassagerTotal()[1] ?>],
                        "text":"<?php echo ucfirst(strftime("%B", strtotime("-1 months"))); ?>",
                        "background-color":"#E76D45"
                    },
                    {
                        "values":[<?php echo Admin::getStatsPassagerTotal()[2] ?>],
                        "text":"<?php echo ucfirst(strftime("%B", strtotime("-2 months"))); ?>",
                        "background-color":"#55BA72"
                    }
                ]
            }
        ]
    };

    zingchart.render({
        id : 'passagerTotalChart',
        data : myConfig2,
    });

    var colorCat = ['#4D707D', '#DB6662', '#89A0A8', '#6C8DE7', '#CB87E8'];
    
    //using basic custom theme
    var myTheme = {
        palette:{
            vbar:[
                ['#4D707D','#4D707D'],['#DB6662','#DB6662'],['#89A0A8','#89A0A8']
            ]
        },
    };

    // define chart JSON
    var myConfig3 = {
        type: 'bar',
        "background-color":"#FFFFFF",
        "globals":{
            "font-family":"Roboto"
        },
        title: {
            text: 'Passagers transportés par catégorie',
            "color": "#626262",
            "background-color": "#FFFFFF",
        },
        plot: {
            // barWidth: 25, // this will prevent users from noticing the barwidth changing
            animation:{}, // add animation to make the chart look alive
            "border-radius-top-left":5,
            "border-radius-top-right":5,
            tooltip:{
                text:"%v passager(s)",
                shadow:false,
                "border-radius":5
            }
        },
        tooltip: {
            fontColor: '#fff'
        },
        legend: {
            toggleAction:'remove',
            "border-radius":5,
            marker:{
                "border-radius":5,
                "border-width":0
            },
        },
        scaleY: {
            <?php $max = max(Admin::getStatsPassagerTotal()[0], Admin::getStatsPassagerTotal()[1], Admin::getStatsPassagerTotal()[2]); ?>
            values: '0:<?php echo $max+2 ?>:5', // this will prevent users from noticing the scale repaint
            guide:{
                lineStyle: 'solid'
            }
        },
        scaleX: {
            labels:["<?php echo ucfirst(strftime('%B', strtotime("-2 months"))); ?>", "<?php echo ucfirst(strftime('%B', strtotime("-1 months"))); ?>", "<?php echo ucfirst(strftime("%B", time())); ?>"],
            guide:{
                lineStyle: 'solid'
            }
        },
        series:[
            <?php for($i = 0; $i < count(Admin::getStatsPassagerByCategorie()); $i++) : ?>
            {
                "values":[<?php echo Admin::getStatsPassagerByCategorie()[$i][3] ?>, <?php echo Admin::getStatsPassagerByCategorie()[$i][2] ?>, <?php echo Admin::getStatsPassagerByCategorie()[$i][1] ?>],
                "text":"<?php echo ucfirst(Admin::getStatsPassagerByCategorie()[$i][0]) ?>",
                "background-color": colorCat[<?= $i ?>]
            },
            <?php endfor; ?>
        ]
    };
    
        zingchart.render({
            id: 'passagerChart',
            data: myConfig3,
            height: '100%',
            width: '100%',
            defaults: myTheme //define custom theme from above
        });

    var myConfig4 = {
        "layout":"h",
        "globals":{
            "font-family":"Roboto"
        },
        "graphset":[
            {
                "type":"pie",
                "background-color":"none",
                "legend":{
                    "background-color":"none",
                    "border-width":0,
                    "shadow":false,
                    "layout":"float",
                    "margin":"auto auto 16% auto",
                    "marker":{
                        "border-radius":5,
                        "border-width":0
                    },
                    "item":{
                        "color":"%backgroundcolor"
                    }
                },
                "title":{
                    "text":"Chiffre d'affaire",
                    "background-color":"none",
                    "font-size":16,
                    "color":"#626262",
                    "x":0,
                    "y":80
                },
                "plotarea":{
                    "background-color":"#FFFFFF",
                    "border-color":"none",
                    "border-width":1,
                    "border-radius":5,
                    "margin":"auto",
                    "width":"100px",
                },
                "labels":[
                    {
                        "x":"45%",
                        "y":"44%",
                        "width":"10%",
                        "text":"<b>TOTAL</b><br><small style='font-size: 15px;'><?php echo round(Admin::getStatsCA()[3], 2); ?> euros</small>",
                        "font-size":24
                    }
                ],
                "plot":{
                    "size":120,
                    "slice":70,
                    "margin-right":100,
                    "border-width":0,
                    "shadow":0,
                    "value-box":{
                        "visible":false
                    },
                    "tooltip":{
                        "text":"%v euros",
                        "shadow":false,
                        "border-radius":5
                    }
                },
                "series":[
                    {
                        "values":[<?php echo round(Admin::getStatsCA()[0], 2); ?>],
                        "text":"<?php echo ucfirst(strftime("%B", time())); ?>",
                        "background-color":"#25D0F6"
                    },
                    {
                        "values":[<?php echo round(Admin::getStatsCA()[1], 2); ?>],
                        "text":"<?php echo ucfirst(strftime("%B", strtotime("-1 months"))); ?>",
                        "background-color":"#CB4C90"
                    },
                    {
                        "values":[<?php echo round(Admin::getStatsCA()[2], 2); ?>],
                        "text":"<?php echo ucfirst(strftime("%B", strtotime("-2 months"))); ?>",
                        "background-color":"#F89C4F"
                    }
                ]
            }
        ]
    };

    zingchart.render({
        id : 'caChart',
        data : myConfig4,
    });
</script>
<?php
else:
    header('Location: index.php');
endif;
?>