<?php

require "global.php";

define("TITLE", "Nos destinations");

require TPL."header.php";

// On regarde si il n'existe pas de date OU si elle n'est pas valide
// Si c'est le cas, on lui donne la date du jour
if(!isset($_GET['date']) || !Html::validStr($_GET['date'])) {
    $_GET['date'] = date('Y-m-d', time());
}

// On regarde si il n'existe pas de secteur OU si il n'est pas valide
// Si c'est le cas, on lui donne le secteur 0 par défaut
if(!isset($_GET['secteur']) || !Html::validInt($_GET['secteur'])) {
    $_GET['secteur'] = 0;
}

// On regarde si la date est passée
if(strtotime($_GET['date']) < time()-86399) {
    $message = "La date saisie est déjà passée.";
} else {
    // Sinon on affiche les résultats des destinations selon le secteur et la date données
    $resultats = Destination::getSecteurDate($_GET['secteur'], $_GET['date']);
    // Dans le cas où il n'y aurait pas de résultat, on retourne un message d'erreur
    if($resultats == null) {
        $message = "Désolé nous n'avons trouvé aucune destination pour cette date.";
    }
}
?>
    <section class="about-banner relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white mb-10">
                        <?= $_GET['secteur'] ? Destination::getNameForId($_GET['secteur'])  : "Choisissez votre destination"; ?>
                    </h1>
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="bg-white p-20" style="border-radius: 10px;">
                                <form class="form-wrap" method="GET" action="destination.php">
                                    <label class="form-control my-label" style="width: 140px; text-align: center;" for="secteur">Destination</label>
                                    <select class="form-control my-input mr-10" style="width: 180px;" id="secteur" name="secteur">
                                        <option <?= $_GET['secteur'] == 0 ? "selected" : ""; ?> value="0">Toutes</option>
                                        <?= Html::genereOption(Destination::getListLiaisons(), "id", "nom", $_GET['secteur']); ?>
                                    </select><br>
                                    <label class="form-control my-label" style="width: 140px; text-align: center;" for="date">Date</label>
                                    <input type="date" value="<?= @$_GET['date']; ?>" class="form-control my-input mr-10" style="width: 180px;" id="date" name="date" placeholder="Date"><br>
                                    <input type="submit" value="Rechercher" class="primary-btn rounded text-uppercase" style="width: 140px; margin: auto; display: block;"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="destinations-area section-gap">
        <?php
        if(isset($message)) {
            ?>
            <div class="container">
                <div class="bg-white p-4 text-center rounded">
                    <h5><?= $message; ?></h5>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="container">
                <div class="row">
                    <?php for ($i = 0; $i < count($resultats); $i++): ?>
                    <?php if(Reservation::checkStock($resultats[$i]['liaison'])): ?>
                        <div class="col-lg-4">
                            <div class="single-destinations radius overflow-hidden">
                                <div class="thumb">
                                    <img src="<?= IMG_ILE . $resultats[$i]['image']; ?>" alt="" style="height: 235px;">
                                </div>
                                <div class="details">
                                    <h4 class="d-flex justify-content-between">
                                        <span>Par <?= $resultats[$i]['libelle_pd']; ?></span>
                                    </h4>
                                    <ul class="package-list">
                                        <li class="d-flex justify-content-between align-items-center">

                                            <span><?= $resultats[$i]['description']; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>Départ</span>
                                            <span>
                                         <?= $resultats[$i]['libelle_pd'] . ' à ' . date('H:i', $resultats[$i]['date_depart']); ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>Arrivée </span>
                                            <span>
                                        <?= $resultats[$i]['libelle_pa'] . ' à ' . date('H:i', $resultats[$i]['date_arrivee']); ?></span>
                                        </li>

                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>Nos tarifs dépendent des périodes ainsi que du nombre de passager. Consultez-les directement sur l'offre.</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <a href="reservation.php?id=<?= $resultats[$i]['id']; ?>" class="primary-btn rounded text-uppercase rounded m-auto">Réserver</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
    </section>
<?php
require TPL."footer.php";
?>