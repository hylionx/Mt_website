<?php

require "global.php";

if($client->getOnline()):

    define("TITLE", "Mon espace");

    require TPL."header.php";

    // Changement de mot de passe
    if (isset($_GET['password'])) {
        // Si l'ancien et le nouveau password existent
        if (isset($_POST['ancien']) && isset($_POST['nouveau'])) {
            
            // On récupére les données
            $ancien = $_POST['ancien'];
            $nouveau = $_POST['nouveau'];
            
            // Il y a une erreur
            $error = $client->changePassword($ancien, $nouveau);

            // Message d'erreur
            if ($error != "ok") {
                $messageError = $error;
            } else {
                // Message de succés
                $messageOK = "Le changement a bien été effectué !";
            }
        }
    }

    // Changement d'email
    if (isset($_GET['mail'])) {
        // Si l'email existe
        if (isset($_POST['email'])) {
            
            // On récupére les données
            $nouvelle = $_POST['email'];
            
            // Il y a une erreur
            $error = $client->changeMail($nouvelle);

            // Message d'erreur
            if ($error != "ok") {
                $messageError = $error;
            } else {
                // Message de succés
                $messageOK = "Le changement a bien été effectué !";
            }
        }
    }

    // Ajout d'une réservation
    if(isset($_GET['addReservation']) && HTML::validInt($_GET['addReservation'])) {
        // On essaie l'ajout d'une réservation
        try {
            $messageOK = $client->addReservation($_GET['addReservation']);
        } catch (Exception $e) {
            // Dans le cas où il y a une erreur, on l'affiche
            $messageError = $e->getMessage();
        }
    }
    ?>
    <div id="popupBackResa"></div>
    <div id="popupResa" class="popup">
        <div id="image" class="image"></div>
        <h3 id="trajet"></h3>
        <p id="description"></p>
        <h4>Détails de votre réservation</h4>
        
        <div id="details" class="details">
        </div>

        <div class="unDetail total">
            <!--        style="color: #dc6f6f;"-->
            <h6 id="total"></h6>
        </div>
        <center>
            <button id="closePopup" type="button" class="genric-btn danger mt-15 radius">Fermer</button>
        </center>
    </div>

    <section class="about-banner relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        Espace membre
                    </h1>
                    <h4 class="text-white link-nav"><?= strtoupper($client->getNom()) . ' ' . $client->getPrenom(); ?></h4>
                </div>
            </div>
        </div>
    </section>

    <section class="section-gap">
        <div class="container">
            <?php if (isset($messageError)) : ?>
                <div class="errorPopup w-50 m-auto"><?= $messageError ?></div><br>
            <?php endif;
            if (isset($messageOK)): ?>
                <div class="errorPopup w-50 m-auto bg-success"><?= $messageOK ?></div><br>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-6 info-left">
                    <div class="container bg-white">
                        <h2>Mes réservations</h2>

                        <?php
                        $lesReservations = $client->getReservations();
                        if ($lesReservations == NULL): ?>
                            <h5>Vous n'avez effectué aucune réservation.</h5>
                        <?php else:
                            $bool = false;
                            $bool2 = false;
                            for ($i = 0; $i < count($lesReservations); $i++):
                                if ($lesReservations[$i]['date_depart'] > time() && !$bool2): ?>
                                    <h4>Récentes</h4>
                                    <?php $bool2 = true;
                                elseif ($lesReservations[$i]['date_depart'] < time() && !$bool): ?>

                                    <h4>Anciennes</h4>
                                    <?php $bool = true; endif; ?>

                                <div class="uneResa resaBox align-items-center"
                                     data-id="<?= $lesReservations[$i]['id'] ?>">
                                    <div class="image">
                                        <img src="<?= IMG_ILE . $lesReservations[$i]['image']; ?>"
                                             style="max-height: 180px;">
                                    </div>
                                    <div class="description">
                                        <h6>Commande n°<?= $lesReservations[$i]['id'] ?>
                                            <small> - <?= $lesReservations[$i]['prix_final']; ?> €</small>
                                        </h6>
                                        <h5><?= $lesReservations[$i]['depart'] . ' - ' . $lesReservations[$i]['arrivee']; ?></h5>
                                        <small>Départ au <b><?= strftime("%A %d %B %Y", $lesReservations[$i]['date_depart']); ?></b></small>
                                        <p><?= $lesReservations[$i]['description']; ?></p>
                                    </div>
                                </div>
                            <?php endfor; endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 info-right">
                    <h2>Mes points fidélités</h2>
                    <div class="uneResa p-20">
                        <p>
                            Vous possédez un total de <b><?= $client->getPoints(); ?>
                                point<?= ($client->getPoints() > 0) ? 's' : ''; ?>.</b><br><br>
                            Il vous manque <b><?php echo 100 - $client->getPoints(); ?> points</b> afin de pouvoir
                            bénificier d'une <b>réduction de 25%</b> valable lors de votre prochaine réservation.
                        </p>

                        <?php if ($client->getPoints() >= 100): ?>
                            <p>Cela vous donnera droit à une <b>réduction de 25%</b> à utiliser lors de votre prochaine
                                réservation.</p>
                        <?php endif; ?>
                    </div>

                    <h2>Mes informations</h2>
                    <div class="uneResa p-20">
                        <h5>Modification de l'adresse mail</h5>

                        <form method="POST" action="?mail">
                            <div class="mt-10">
                                <input type="email" name="email" placeholder="<?= $client->getEmail() ?>" required
                                       class="single-input-primary br-5">
                            </div>

                            <center>
                                <button type="submit" class="genric-btn primary radius mt-15">Modifier</button>
                            </center>
                        </form>
                    </div>

                    <div class="uneResa p-20">
                        <h5>Modification du mot de passe</h5>

                        <form method="POST" action="?password">
                            <div class="mt-10">
                                <input type="password" name="ancien" placeholder="Ancien mot de passe" required
                                       class="single-input-primary br-5">
                            </div>
                            <div class="mt-10">
                                <input type="password" name="nouveau" placeholder="Nouveau mot de passe" required
                                       class="single-input-primary br-5">
                            </div>

                            <center>
                                <button type="submit" class="genric-btn primary radius mt-15">Modifier</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    require TPL . "footer.php";
    ?>

    <script>
        $(document).ready(function () {
            // Au clic sur une réservation
            $(document).on('click', '.resaBox', function(){
                var idResa = $(this).attr('data-id');
                console.log(idResa);
                // On remet à 0 les affichages
                $('#trajet').html("");
                $('#description').html("");
                $('#details').html("");
                $('#total').html("");
                
                // On va récupérer les nouvelles infos
                $.ajax({
                    type: "POST",
                    url: "action/getInfosResa.php",
                    data: {idResa: idResa},
                    dataType: "json",
                    success: function(response) {
                        console.log(response.infos);
                        // Affichage
                        $('#trajet').append(response.infos["depart"] + ' - ' + response.infos["arrivee"] + '<br><h6> Départ au <b>' + response.date + '</b></h6>');
                        $('#description').append(response.infos["description"]);
                        document.getElementById("image").style.backgroundImage = "url('img/iles/" + response.infos['image'] +"')";
                        
                        var html = "";
                        for(var i = 0; i < response.places.length; i++){
                            html += "<div class='unDetail'> <h6>" + response.places[i]['nombre'] + " place";
                            if(response.places[i]['nombre'] > 1){
                                html += "s";
                            }
                            html += " " + response.places[i]['libelle'] + " </h6> </div>";
                        }
                        
                        $('#details').append(html);
                        
                        $('#total').append("Montant total de votre réservation<br>" + response.infos['prix_final'] + "€");
                    },
                    error: function(response){
                        console.log(response);
                    }
                });

                // Affichage de la popup
                $('body').css('overflow', 'hidden');
                $('#popupBackResa').addClass('popupActive');
                $('#popupResa').css('display', 'block');
            });

            // On ferme la popup
            $(document).on('click', '#closePopup', function(){
                $('body').css('overflow', '');
                $('#popupBackResa').removeClass('popupActive');
                $('#popupResa').css('display', '');
            });
            
            
            $(document).on('click', '.popupActive', function(){
                var link = window.location.pathname;
                link = link.replace('/MT_website/', '');
                
                if(link != "reservation.php"){
                    $('body').css('overflow', '');
                    $('#popupBackResa').removeClass('popupActive');
                    $('#popupResa').css('display', '');
                }
            });
        });
    </script>
<?php
else:
    header('Location: index.php');
endif;
?>
