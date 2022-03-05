<?php
require "global.php";

define("TITLE", "Réservation");

//sélection d'un voyage et des prix à partir de son id
if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$voyage = Reservation::getUnVoyage($_GET["id"]);
}

require TPL."header.php";
?>

<section class="about-banner relative">
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white">
                    Réservation
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="destinations-area section-gap">
    <?php if(isset($voyage) && $voyage != null){

         $prices = Reservation::getPrices($voyage["id"]);

         if(isset($prices) && $prices != null) {
        ?>

    <?php if(Reservation::checkStock($voyage["id"])) { ?>
    <div class="container">
        <div class="row bg-white rounded overflow-hidden">
            <div class="col-lg-4 p-0">
                <img src="<?= IMG_ILE; ?><?= $voyage["image"]; ?>" class="img-resa">
            </div>
            <div class="col-lg-8 p-3">
                <h3><?= $voyage["arrivee"]; ?></h3>
                <h5>Au départ de <?= $voyage["depart"]; ?></h5><br>
                
                <h6>
                    Départ prévu le <?= strftime("%A %d %B %Y", $voyage["date_depart"]) ?> à <?= strftime("%Hh%M", $voyage["date_depart"]) ?><br>
                    Arrivée prévue le <?= strftime("%A %d %B %Y", $voyage["date_arrivee"]) ?> à <?= strftime("%Hh%M", $voyage["date_arrivee"]) ?><br><br>
                </h6>
                <p><?= $voyage["description"] ?></p>
            </div>
        </div>
    </div>
</section>

<section class="destinations-area">
    <div class="container">
        <div class="row bg-white rounded-top">
            <form method="POST" id="form-reservation" action="mon-espace.php?addReservation=<?= $voyage["id"]; ?>">
                <div class="col-lg-6 p-4">
                    <div class="errorPopup m-auto bg-warning hidden">Vous n'avez sélectionné aucune place !</div>
                    <table class="resa-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tarification</th>
                            <th style="width: 5% !important;">Quantité</th>
                        </tr>
                        </thead>
                        <?php
                         $stock = Reservation::getStock($voyage["id"]);
                         //affiche les prix du voyage
                         for($i = 0; $i < count($prices); $i++) : ?>
                         <?php if($stock[$prices[$i]['categorie']]['nombre'] > 0) { ?>
                            <tr>
                                <td><?= $prices[$i]['libelle'] ?></td>
                                <td><?= $prices[$i]['prix'] ?> €</td>
                                <td><input type="number" name="<?= $prices[$i]['id'] ?>" data-price="<?= $prices[$i]['prix'] ?>" value="0" min="0" max="<?= $stock[$prices[$i]['categorie']]['reste']; ?>" onkeyup="if(this.value > <?= $stock[$prices[$i]['categorie']]['reste']; ?>) this.value = 0;"></td>
                            </tr>
                        <?php } ?>
                        <?php endfor; ?>
                    </table>
                </div>
                <div class="col-lg-6 p-4 text-center">
                    <h3>Mes informations</h3><br>
                    <p class="m-0"><?= strtoupper($client->getNom()).' '.$client->getPrenom(); ?></p>
                    <p class="m-0"><?= $client->getAdresse(); ?></p>
                    <p class="m-0"><?= $client->getVille().', '.$client->getCp(); ?></p>
                    <p class="m-0"><?= $client->getEmail(); ?></p>
                    <p class="m-0"><b>Vous possédez un total de <?= $client->getPoints(); ?> point<?= ($client->getPoints() > 0) ? 's' : ''; ?>.</b></p><br>
                    <label class="form-control my-label" for="prix">Prix total</label>
                    <input type="text" class="form-control my-input mr-10" name="prix" id="prix" value="0.00 €" disabled><br>
                    <button type="button" class="genric-btn primary radius mt-10" id="btn-reserver">Réserver <i class="fa fa-angle-right"></i></button>
                </div>
            </form>
        </div>
    </div>
    <?php } else { ?>
    <div class="container">
        <div class="bg-white p-4 text-center rounded">
            <h3>Trop tard...</h3>
            <h5>Le voyage que vous recherchez est complet.</h5>
        </div>
    </div>
    <?php
     }
     } else { ?>
        <div class="container">
            <div class="bg-white p-4 text-center rounded">
                <h3>Suite à un incident technique...</h3>
                <h5>Le voyage est temporairement indisponible.</h5>
            </div>
        </div>
        <?php
    }
    }else{ ?>
    <div class="container">
        <div class="bg-white p-4 text-center rounded">
            <h3>Nous avons rencontré une erreur...</h3>
            <h5>Le voyage que vous recherchez n'existe pas ou plus.</h5>
        </div>
    </div>
    <?php } ?>
    
</section>


<?php
require TPL."footer.php";
?>

<script>
    $(document).ready(function() {
        
        // On regarde s'il y a une session et un voyage
        var session = "<?= $client->getOnline() ?>";
        var voyage = "<?= isset($voyage)? 'yesVoyage' : 'noVoyage' ?>";
        
        // S'il n'y a pas de session et qu'il y a un voyage on afficher la popup
        if(session == false && voyage == "yesVoyage"){
            $('body').css('overflow', 'hidden');
            $('#popupBack').addClass('popupActive');
            $('#popup').css('display', 'block');
        }

        // On cache le bouton annuler
        $('#annulerPopup_1').css('display', 'none');
        $('#annulerPopup_2').css('display', 'none');

        // Calcul du prix
        var price = 0;
        $("input[type='number']").change(function() {
            price = 0;
            $('input[type="number"]').each(function(){
                price += $(this).val()* $(this).attr('data-price');
            });
            
            $('#prix').val(price.toLocaleString('fr-FR', {style: 'currency', currency: 'EUR'}));
        });
        
        $(document).on('click', '#btn-reserver', function(){
            var places = 0;
            $('input[type="number"]').each(function(){
                places += parseInt($(this).val());
            });

            if(places != 0){
                document.getElementById('form-reservation').submit();
            }else{
                $('.errorPopup').removeClass('hidden');
            }
        });
    });
</script>