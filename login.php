<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<section>

    <div class="container border-0">
        <div class="row d-flex justify-content-center align-items-center h-100 border-0">
            <div class="col col-xl-10 border-0">
                <div class="card border-0">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block border-0">
                            <img src="assets/img/backgrounds/librairie_1.png" class="w-100 rounded-4 shadow-4" alt="" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form action="functions/form-control.php?func=login" method="post">

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Connexion à votre compte</h5>
                                    <div class="form-outline mb-4">
                                        <input type="email" id="mail" name="mail" class="form-control form-control-lg" />
                                        <label class="form-label" for="mail">Email</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="mdp" name="mdp" class="form-control form-control-lg" />
                                        <label class="form-label" for="mdp">Password</label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                    </div>

                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Pas encore de compte ? <a href="register.php" style="color: #393f81;">Register here</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>