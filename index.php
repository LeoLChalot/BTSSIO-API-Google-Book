<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Template de formulaire de connexion</h1>
            <p class="lead text-muted">Sur ce projet, j'expliquerai comment établir une connexion à une base de données, mais aussi gérer les inscriptions et connexions des différents utilisateurs.</p>
            <?php if (!empty($_SESSION)) : ?>
                <p>
                    Username : <?= $_SESSION['username']; ?>
                </p>
                <p>
                    Rôle : <?= $_SESSION['role']; ?>
                </p>
</section>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <!-- Début vignette Bootstrap -->
            <div class="col">
                <div class="card shadow-sm">
                    <img src="assets/img/bootstrap.jpg" class="img-thumbnail" alt="vignette Bootstrap">
                    <div class="card-body">
                        <p class="card-text">Résumé de l'utilisation du framework Bootstrap 5.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="explain-bootstrap.php"><button type="button" class="btn btn-sm btn-outline-secondary">En savoir plus</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin vignette Bootstrap -->
            <!-- Début vignette PHP -->
            <div class="col">
                <div class="card shadow-sm">
                    <img src="assets/img/php.jpg" class="img-thumbnail" alt="vignette Bootstrap">
                    <div class="card-body">
                        <p class="card-text">Détail de la connexion réalisée avec PDO en PHP.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="explain-php.php"><button type="button" class="btn btn-sm btn-outline-secondary">En savoir plus</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin vignette PHP -->
            <!-- Début vignette Users Account -->
            <div class="col">
                <div class="card shadow-sm">
                    <img src="assets/img/connexion-user.jpg" class="img-thumbnail" alt="vignette Bootstrap">
                    <div class="card-body">
                        <p class="card-text">Explications sur les différents procédés de gestion.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="explain-user.php"><button type="button" class="btn btn-sm btn-outline-secondary">En savoir plus</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin vignette Users Account -->
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