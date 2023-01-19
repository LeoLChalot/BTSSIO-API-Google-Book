<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . "/require/header.php"); ?>
<div class="py-5 text-center container">
    <div id="carouselExample" class="carousel slide col-6">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/explain/php/script_register.png" class="d-block w-100" alt="Script de création de compte">
            </div>
            <div class="carousel-item">
                <img src="assets/img/explain/php/script_login.png" class="d-block w-100" alt="Script de connexion au compte">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php require_once(__DIR__ . "/require/footer.php"); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>