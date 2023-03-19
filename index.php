<?php
require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<section id="section-home" class="text-center container">
    <div class="row">
        <div class="col-lg-6 col-md-6 mx-auto d-flex flex-column justify-content-center">
            <h1 class="fw-light">Librairie - Le mille feuilles</h1>
            <?php if (!empty($_SESSION)) : ?>
                <h2 class="fw-light">Bienvenue <?= $_SESSION['username'] ?></h2>
            <?php endif ?>
            <br>
            <p class="lead text-muted">La librairie "Le Mille Feuilles vous présente sa collection de livres tous plus incroyables les uns que les autres (sauf certains qui ne sont pas oufs)</p>
            <p class="lead text-muted">Grâce à notre dématérialisation, nous vous proposons de naviguer au travers de notre <a href="http://localhost/librairie/form-connexion/catalogue.php" class="link-dark">Catalogue virtuel</a> pour pouvoir découvrir toujours plus de nouvelles références, mais que vous ne pourrez pas acheter (et paf!)</p>
            <p class="lead text-muted">Un système d'ajout et de suppression au sein de votre collection personnelle (uniquement réservée aux adhérants) vous permettra de conserver les références que vous souhaitez !</p>
            <?php if (!empty($_SESSION)) : ?>
                <p>
                    Vous n'êtes pas encore connecté !
                </p>
            <?php endif ?>
        </div>
        <div class="col-lg-6 col-md-6 mx-auto">
            <img id="img"src="assets/img/backgrounds/librairie_full.png" alt="image accueil" width="600px">
        </div>
    </div>
</section>


<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>