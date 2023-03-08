<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<section class="text-center text-lg-start">
    <style>
        .cascading-right {
            margin-left: -50px;
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
            <div class="col-lg-5 mb-6 mb-lg-0">
                <img src="assets/img/backgrounds/catalogue.jpg" class="w-100 rounded-4 shadow-4" alt="" />
            </div>
            <div class="center col-lg-5 mb-5 mb-lg-0">
                <div class="card cascading-right shadow-sm" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
                    <div class="card-body p-5 shadow-5 text-center">
                        <h2 class="fw-bold mb-5">Le catalogue !</h2>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>