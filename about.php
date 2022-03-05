<?php
require "global.php";

define("TITLE", "Notre compagnie");

require TPL."header.php";
?>
			<!-- start banner Area -->
			<section class="about-banner relative">
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
							MarieTeam
							</h1>	

						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->

			<!-- Start about-info Area -->
			<section class="about-info-area section-gap">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-6 info-left">
							<img class="img-fluid img-about" src="img/about/info-img.jpg" alt="">
						</div>
						<div class="col-lg-6 info-right">
							<h6>MarieTeam</h6>
							<h1>Qui sommes-nous?</h1>
							<p>
                                <b>MarieTeam</b> est une compagnie de transports maritimes. Ayant obtenus plusieurs contrats avec des conseils généraux, la compagnie assure la desserte maritime d'îles du littoral français par délégation de service public.<br> <b>Les îles desservies par la compagnie:</b><br> Belle-île-en-mer, Houat, Ile de Groix, Ouessant, Molène, Sein, Batz, Aix et Yeu.
							</p>
						</div>
					</div>
				</div>	
			</section>
			<!-- End about-info Area -->


<!--Section google maps nous situer-->
    <section class="contact-page-area pt-20">
        <div class="title text-center">
            <h1 class="mt-15 mb-30">Notre siège social</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="map-responsive radius">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3580.427441934882!2d3.0747819480649716!3d50.613284570400715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2d5c13a455069%3A0x91ed40ba0c3ca621!2sAvenue+Gaston+Berger%2C+59000+Lille!5e0!3m2!1sfr!2sfr!4v1543227218310" width="1200" height="1000" frameborder="0" style="border:0" allowfullscreen></iframe> </div>
                <?php
                if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['sujet']) && isset($_POST['message'])
                    && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['sujet']) && !empty($_POST['message'])){

                    echo " <div class='col-lg-12' style='margin: 15px; height: 10px;'>
                                <div class=\"errorPopup w-50 m-auto bg-success\">
                                    Votre message a bien été envoyé!
                                </div><br><br>
                            </div>";
                }
                ?>
                <div class="col-lg-4 d-flex flex-column address-wrap mt-35">
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-home"></span>
                        </div>
                        <div class="contact-details">
                            <h5>Lille, France</h5>
                            <p>
                               Avenue Gaston Berger
                            </p>
                        </div>
                    </div>
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-phone-handset"></span>
                        </div>
                        <div class="contact-details">
                            <h5>03 20 01 02 03</h5>
                            <p>Du lundi au vendredi de 9h00 à 18h00 </p>
                        </div>
                    </div>
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-envelope"></span>
                        </div>
                        <div class="contact-details">
                            <h5>support@marieteam.com</h5>
                            <p>Contactez nous, pour toutes informations supplémentaires!</p>
                        </div>
                    </div>
                </div>

                <?php

                //récupération des champs
                    if(isset($_GET['contact']))
                    {
                        if(isset($_POST['nom'])&& isset($_POST['email']) && isset($_POST['sujet'])&& isset($_POST['message']))
                        {
                            $nom = $_POST['nom'];
                            $email = $_POST['email'];
                            $sujet = $_POST['sujet'];
                            $message = $_POST['message'];

                            if (!empty($nom) AND !empty($email) AND !empty($sujet) AND !empty($message)) {
                                $client->sendMessage($nom, $email, $sujet, $message);
                            } else {
                                $erreur= "Attention ! Tous les champs ne sont pas remplis!";
                            }
                        }else {
                            $erreur= "Attention ! Tous les champs ne sont pas remplis!";
                        }
                    }
                ?>

                <div class="col-lg-8 mt-35">
                    <form class="form-area contact-form text-right" id="formContact" action="about.php?contact#formContact" method="post">
                        <div class="row">
                            <?php if(isset($erreur)) : ?>
                                <div class="errorPopup w-100 mb-3 bg-danger">
                                  <?= $erreur ?>
                                </div>
                            <?php endif; ?>
                            <div class="col-lg-6 form-group">
                                <input name="nom" placeholder="Entrez votre nom" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrez votre nom'" class="common-input mb-20 form-control" required="" type="text" style="border-radius: 10px">

                                <input name="email" placeholder="Entrez adresse email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrez adresse email'" class="common-input mb-20 form-control" required="" type="email" style="border-radius: 10px">

                                <input name="sujet" placeholder="Entrez le sujet" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrez le sujet'" class="common-input mb-20 form-control" required="" type="text" style="border-radius: 10px" >
                            </div>
                            <div class="col-lg-6 form-group">
                                <textarea class="common-textarea form-control" name="message" placeholder="Entrez votre message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrez votre message'" required="" style="border-radius: 10px"></textarea>
                            </div>

                            <div class="col-lg-12">
                                <div class="alert-msg" style="text-align: left;"></div>
                                <input class="genric-btn primary" type="submit" style="float: right;" value="Envoyer"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<!-- fin de la section nous situer-->




			<!-- Start testimonial Area -->
		    <section class="testimonial-area section-gap">
		        <div class="container">
		            <div class="row d-flex justify-content-center">
		                <div class="menu-content pb-30 col-lg-8">
		                    <div class="title text-center">
		                        <h1 class="mb-10">Ils nous ont fait confiance...</h1>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="active-testimonial">
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
		                            <img class="img-fluid" src="img/elements/user1.png" alt="">
		                        </div>
		                        <div class="desc">
		                            <p>
		                                Compagnie martime au top! Le cadre est idyllique. Je recommande à 100%.
		                            </p>
		                            <h4>Marine Dupont</h4>
	                            	<div class="star">
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star"></span>				
									</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
		                            <img class="img-fluid" src="img/elements/user2.png" alt="">
		                        </div>
		                        <div class="desc">
		                            <p>
		                            Personnel très agréable! Prix très attractifs. Bateau très propre. Parking spacieux pour installé notre véhicule qui est assez imposant. Merci à vous.
		                            </p>
		                            <h4>Laurine Dalgo</h4>
	                           		<div class="star">
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
									</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
		                            <img class="img-fluid" src="img/elements/user3.png" alt="">
		                        </div>
		                        <div class="desc">
		                            <p>
		                               Je recommande ! Petit bémol, le prix des déjeuners dans le bateau est trop couteux! Sachant que j'ai 4 enfants ça revient très cher, de plus nous ne pouvons pas prendre notre propre nourriture à l'intérieur du bateau. Le trajet est long, donc c'est dommage.
		                            </p>
		                            <h4>Jean Marc Delattre</h4>
	                            	<div class="star">
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star "></span>
										<span class="fa fa-star"></span>				
									</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
		                            <img class="img-fluid" src="img/elements/user2.png" alt="">
		                        </div>
		                        <div class="desc">
		                            <p>
		                                J'ai adoré mon séjour chez MarieTeam! Personel très sympa. De plus j'ai un bébé, il y avait tout le nécessaire pour son confort et tout ça sans frais supplémentaires! Nous avons passé un séjour très agréable! Merci MarieTeam!  :)
		                            </p>
		                            <h4>Carolyn Craig</h4>
	                           		<div class="star">
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
									</div>	
		                        </div>
		                    </div>

		                    </div>
		                </div>
		            </div>

		    </section>
		    <!-- End testimonial Area -->
    <script>function initMap() {
            var uluru = {lat: 50.633333, lng: 3.066667};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    inetMap();
    </script>
			<!-- start footer Area -->
<?php
require TPL."footer.php";
?>