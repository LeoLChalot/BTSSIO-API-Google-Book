<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Template de formulaire de connexion</h1>
            <?php if (!empty($_SESSION)) : ?>
                <h2 class="fw-light">Bienvenue <?= $_SESSION['username'] ?></h2>
            <?php endif ?>
            <p class="lead text-muted">Sur ce projet, j'expliquerai comment établir une connexion à une base de données, mais aussi gérer les inscriptions et connexions des différents utilisateurs.</p>
            <?php if (!empty($_SESSION)) : ?>
</section>
<div class="album py-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <!-- Espace dédié aux vignettes  -->
        </div>
    </div>
</div>

<?php else : ?>
    <p>
        Vous n'êtes pas encore connecté !
    </p>
    </section>
<?php endif ?>
</div>
</div>



<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>