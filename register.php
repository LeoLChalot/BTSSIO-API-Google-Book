<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<!-- Section: Design Block -->
<section class="text-center text-lg-start">
    <style>
        .cascading-right {
            margin-right: -50px;
        }

        @media (max-width: 992px) {
            .cascading-right {
                margin-right: 0;
            }
        }
    </style>

    <!-- Zone Register -->
    <div class="container py-4">
        <div class="row g-0 align-items-center justify-content-center">
            <div class="center col-lg-5 mb-5 mb-lg-0">
                <div class="card cascading-right shadow-sm" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
                    <div class="card-body p-5 shadow-5 text-center">
                        <h2 class="fw-bold mb-5">Inscrivez-vous !</h2>
                        <form action="functions/form-control.php?func=register" method="post">
                            <!-- Nom et prenom sur 2 colonnes sur 1 ligne -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="text" id="prenom" name="prenom" class="form-control" require />
                                        <label class="form-label" for="prenom">Prénom</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input type="text" id="nom" name="nom" class="form-control" require />
                                        <label class="form-label" for="nom">Nom</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="mail" id="mail" name="mail" class="form-control" require />
                                <label class="form-label" for="mail">Email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="mdp" name="mdp" class="form-control" pattern="[A-z0-9]{8,}" require />
                                <label class="form-label" for="mdp">Password</label>
                            </div>
                            <!-- Password confirm input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="mdp-repeat" name="mdp-repeat" class="form-control" require />
                                <label class="form-label" for="mdp-repeat">Confirm Password
                                    <ol>
                                        <li>Au moins 8 caractères</li>
                                        <li>Pas de caractères spéciaux</li>
                                    </ol>
                                </label>
                            </div>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">
                                Inscription
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-6 mb-lg-0">
                <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" class="w-100 rounded-4 shadow-4" alt="" />
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>