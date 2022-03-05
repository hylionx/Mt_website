<?php
require "global.php";

define("TITLE", "Bienvenue");

require TPL."header.php";
?>
<section class="banner-area relative">
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row fullscreen align-items-center justify-content-between">
            <div class="col-lg-6 col-md-6 banner-left">
                <h6 class="text-white">Loin de la vie monotone</h6>
                <h1 class="text-white">Marie Team</h1>
                <p class="text-white">
                    Compagnie de transports maritimes déservant les îles du littoral français.
                </p>
                <a href="destination.php" class="primary-btn rounded text-uppercase">Voir nos destinations</a>
            </div>
            <div class="col-lg-4 col-md-6 banner-right">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item rounded-top overflow-hidden">
                        <a class="nav-link active" role="tab">TROUVER UNE DESTINATION</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="flight" role="tabpanel" aria-labelledby="flight-tab">
                        <form class="form-wrap" method="GET" action="destination.php">
                            <select style="padding:0 10px;" class="form-control" name="secteur">
                                <option>Arrivée</option>
                                <?= Html::genereOption(Destination::getListLiaisons(), "id", "nom"); ?>
                            </select>
                            <input type="date" class="form-control" name="date" placeholder="Date">
                            <input type="submit" value="Rechercher" class="primary-btn rounded text-uppercase"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->
<!-- Start popular-destination Area -->
<section class="popular-destination-area section-gap">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-70 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Nos destinations populaires</h1>
                    <p>Envie de partir maintenant dans la destination du moment ?</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                $favoristeDestination = Destination::getFavorite();
                for($i = 0; $i < count($favoristeDestination); $i++) {
                    echo '<div class="col-lg-4">
                <div class="single-destination relative">
                    <div class="thumb relative">
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid" src="'.IMG_ILE.$favoristeDestination[$i]['image'].'" alt="">
                    </div>
                    <div class="desc">
                        <a href="destination.php?secteur='.$favoristeDestination[$i]['id'].'&date='.date('Y-m-d').'" class="price-btn rounded">Réserver</a>
                        <h4>'.$favoristeDestination[$i]['nom'].'</h4>
                    </div>
                </div>
            </div>';
                }

            ?>
        </div>
    </div>
</section>
<?php
require TPL."footer.php";
?>