<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/fav.png">
    <meta name="author" content="La team PPE">
    <meta name="description" content="Compagnie de transports maritimes déservant les îles du littoral français.">
    <meta name="keywords" content="MarieTeam">
    <meta charset="UTF-8">
    <title>MarieTeam - <?= TITLE; ?></title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= CSS; ?>linearicons.css">
    <link rel="stylesheet" href="<?= CSS; ?>font-awesome.min.css">
    <link rel="stylesheet" href="<?= CSS; ?>bootstrap.css">
    <link rel="stylesheet" href="<?= CSS; ?>magnific-popup.css">
    <link rel="stylesheet" href="<?= CSS; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?= CSS; ?>nice-select.css">
    <link rel="stylesheet" href="<?= CSS; ?>animate.min.css">
    <link rel="stylesheet" href="<?= CSS; ?>owl.carousel.css">
    <link rel="stylesheet" href="<?= CSS; ?>main.css?<?= time(); ?>">
    <link rel="stylesheet" href="<?= CSS; ?>parts/reservation.css?<?= time(); ?>">
    <link rel="stylesheet" href="<?= CSS; ?>parts/admin.css">
</head>
<body>
<header id="header">
    <div class="container main-menu">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="index.php"><img src="img/newLogo.png" width="130" alt="" title="" /></a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="destination.php">Destination</a></li>
                    <li><a href="about.php">Notre compagnie</a></li>
                    <li class="menu-has-children"><a href="<?php echo $client->getOnline() ? 'mon-espace.php' : '#'; ?>">Espace Client</a>
                        <ul>
                            <?php if($client->getOnline()) : ?>
                                <li><a href="mon-espace.php"><b><?= strtoupper($client->getNom()).' '.$client->getPrenom() ?></b></a></li>
                                <li><a href="deconnexion.php">Déconnexion</a></li>
                            <?php else: ?>
                                <li id="connexion">Connexion</li>
                                <li id="register">Inscription</li>
                            <?php endif ?>
                        </ul>
                    </li>
	                <?php if($client->getOnline() && $client->getAdmin()) : ?>
                        <li class="menu-has-children"><a href="#">Administration</a>
                            <ul>
                                <li class="menu-has-children"><a href="admin.php?lesTraversees">Traversée</a>
                                    <ul>
                                        <li><a href="admin.php?lesTraversees">Voir</a></li>
                                        <li><a href="admin.php?addTraversee">Ajouter</a></li>
                                    </ul>
                                </li>
                                <li class="menu-has-children"><a href="admin.php?lesLiaisons">Liaisons</a>
                                    <ul>
                                        <li><a href="admin.php?lesLiaisons">Voir</a></li>
                                        <li><a href="admin.php?addLiaison">Ajouter</a></li>
                                    </ul>
                                </li>
                                <li class="menu-has-children"><a href="admin.php?lesPeriodes">Périodes</a>
                                    <ul>
                                        <li><a href="admin.php?lesPeriodes">Voir</a></li>
                                        <li><a href="admin.php?addPeriode">Ajouter</a></li>
                                        <li><a href="admin.php?addTarification">Tarification</a></li>
                                    </ul>
                                </li>
                                <li><a href="admin.php?lesStats">Les stats</a></li>
                                <li><a href="admin.php?message">Les messages</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </div>
</header><!-- #header -->

<!-- POPUP CONNEXION / INSCRIPTION -->
<div id="popupBack"></div>
<div id="popup" class="popup">
    <?php if(isset($errorPopup)): ?>
        <div class="errorPopup"><?= $errorPopup ?></div>
    <?php endif; ?>
    <form method="POST" id="form-inscription" action="?<?= (isset($_GET['id']) ? 'id='.$_GET['id'].'&' : ''); ?>register">
        <h3 class="float-lg-left">Création de compte</h3>
        <div id="btn-connect" class="genric-btn info radius float-right mb-3">J'ai déjà un compte</div>
        <div class="mt-10">
            <input value="<?= @$_POST['nom']; ?>" type="text" name="nom" placeholder="Nom" required class="single-input-primary">
        </div>
        <div class="mt-10">
            <input value="<?= @$_POST['prenom']; ?>" type="text" name="prenom" placeholder="Prénom" required class="single-input-primary">
        </div>
        <div class="mt-10">
            <input value="<?= @$_POST['email']; ?>" type="email" name="email" placeholder="Adresse e-mail" required class="single-input-primary">
        </div>
        <div class="mt-10">
            <input type="password" name="password" placeholder="Mot de passe" required class="single-input-primary">
        </div>
        <div class="input-group-icon mt-10">
            <div class="icon"><i class="fa fa-thumb-tack" aria-hidden="true"></i></div>
            <input value="<?= @$_POST['adresse']; ?>" type="text" name="adresse" placeholder="Adresse" required class="single-input">
        </div>
        <div class="w-25 d-inline-block mt-10 mr-10">
            <input value="<?= @$_POST['cp']; ?>" type="text" name="cp" placeholder="Code postal" required class="single-input-primary">
        </div>
        <div class="d-inline-block mt-10 email">
            <input value="<?= @$_POST['ville']; ?>" type="text" name="ville" placeholder="Ville" required class="single-input-accent">
        </div>
        <center>
            <button type="submit" class="genric-btn primary radius mt-15 center">Je m'inscris</button>
            <button id="annulerPopup_1" class="genric-btn danger mt-15 radius">Annuler</button>
        </center>
    </form>

    <form method="POST" id="form-connect" action="?<?= (isset($_GET['id']) ? 'id='.$_GET['id'].'&' : ''); ?>connect" class="d-none">
        <h3 class="float-lg-left">Connexion</h3>
        <div id="btn-register" class="genric-btn info radius float-right mb-3">Je souhaite m'inscrire</div>
        <div class="mt-10">
            <input value="<?= @$_POST['email']; ?>" type="email" name="email" placeholder="Adresse e-mail" required class="single-input-primary">
        </div>
        <div class="mt-10">
            <input type="password" name="password" placeholder="Mot de passe" required class="single-input-accent">
        </div>

        <center>
            <button type="submit" class="genric-btn primary radius mt-15 center">Je me connecte</button>
            <button id="annulerPopup_2" type="button" class="genric-btn danger mt-15 radius">Annuler</button>
        </center>
    </form>
</div>
<!-- FIN POPUP -->