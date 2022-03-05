<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <p>MarieTeam est une société de voyages maritimes enregistrée à Lille, en France. Nous proposons un service de paiement sécurisé pour nos clients.</p>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h4 class="mb-2 text-center" style="color: #f8f8f8;" >Nos moyens de paiement</h4>
                <center><img src="img/paiement.png" style="width: 160px;"></center>
            </div>
        </div>
        <div class="row footer-bottom d-flex justify-content-between align-items-center">
            <p class="col-lg-8 col-sm-12 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
        </div>
    </div>
</footer>
<!-- End footer Area -->

<script src="<?= JS; ?>vendor/jquery-2.2.4.min.js"></script>
<script src="<?= JS; ?>popper.min.js"></script>
<script src="<?= JS; ?>vendor/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
<script src="<?= JS; ?>jquery-ui.js"></script>
<script src="<?= JS; ?>easing.min.js"></script>
<script src="<?= JS; ?>hoverIntent.js"></script>
<script src="<?= JS; ?>superfish.min.js"></script>
<script src="<?= JS; ?>jquery.ajaxchimp.min.js"></script>
<script src="<?= JS; ?>jquery.magnific-popup.min.js"></script>
<script src="<?= JS; ?>jquery.nice-select.min.js"></script>
<script src="<?= JS; ?>owl.carousel.min.js"></script>
<script src="<?= JS; ?>mail-script.js"></script>
<script src="<?= JS; ?>main.js"></script>

<script>
    $(document).ready(function() {
        // Affichage de la popup
        $(document).on('click', '#connexion', function(){
            $('body').css('overflow', 'hidden');
            $('#popupBack').addClass('popupActive');
            $('#popup').css('display', 'block');

            $('#form-inscription').addClass('d-none');
            $('#form-connect').removeClass('d-none');
        });
        
        $(document).on('click', '#register', function(){
            $('body').css('overflow', 'hidden');
            $('#popupBack').addClass('popupActive');
            $('#popup').css('display', 'block');

            $('#form-inscription').removeClass('d-none');
            $('#form-connect').addClass('d-none');
        });
        
        // Fermeture de la popup
        $(document).on('click', '#annulerPopup_1', function(){
            $('body').css('overflow', '');
            $('#popupBack').removeClass('popupActive');
            $('#popup').css('display', '');
        });

        $(document).on('click', '#annulerPopup_2', function(){
            $('body').css('overflow', '');
            $('#popupBack').removeClass('popupActive');
            $('#popup').css('display', '');
        });

        // Dans la popup
        $(document).on('click', '#btn-connect', function(){
            $('#form-inscription').addClass('d-none');
            $('#form-connect').removeClass('d-none');
        });

        $(document).on('click', '#btn-register', function(){
            $('#form-inscription').removeClass('d-none');
            $('#form-connect').addClass('d-none');
        });
        
        // Erreur dans la popup
        var erreurPopup = "<?php echo isset($errorPopup) ? $errorPopup : ""; ?>";
        var register = "<?php echo isset($_GET['register']) ?>";
        
        if(erreurPopup != ""){
            // Affichage de la popup
            $('body').css('overflow', 'hidden');
            $('#popupBack').addClass('popupActive');
            $('#popup').css('display', 'block');

            if(register == true){
                $('#form-inscription').removeClass('d-none');
                $('#form-connect').addClass('d-none');
            }else{
                $('#form-inscription').addClass('d-none');
                $('#form-connect').removeClass('d-none');
            }
        }
        
        $(document).on('click', '.popupActive', function(){
            var link = window.location.pathname;
            link = link.replace('/MT_website/', '');
            
            if(link != "reservation.php"){
                $('body').css('overflow', '');
                $('#popupBack').removeClass('popupActive');
                $('#popup').css('display', '');
            }
        });
    });
</script>
</body>
</html>