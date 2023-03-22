<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<!-- Section: Design Block -->
<section class="text-center text-lg-start">


    <!-- Zone Register -->
    <div class="container py-4">
        <div class="row g-0 align-items-center justify-content-center">
            <div class="center col-lg-5 mb-5 mb-lg-0">
                <div class="card cascading-right shadow-sm" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
                    <div class="card-body p-5 shadow-5 text-center">
                        <h2 class="fw-bold mb-5">Laissez-moi un message</h2>
                        <?php if (!empty($_SESSION['user'])) : ?>
                            <form action="functions/form-control.php?func=sendMessage&usrid=<?= $_SESSION['user']->getId(); ?>" method="post">
                                <div class="form-outline mb-4">
                                    <input type="text" id="mail" name="mail" class="form-control" require value="<?= $_SESSION['user']->getMail(); ?>" />
                                </div>
                            <?php else : ?>
                                <form action="functions/form-control.php?func=sendMessage" method="post">
                                    <div class="form-outline mb-4">
                                        <input type="text" id="mail" name="mail" class="form-control" require placeholder="@Mail" />
                                    </div>
                                <?php endif ?>

                                <div class="form-outline mb-4">
                                    <input type="text" id="sujet" name="sujet" class="form-control" require placeholder="Le sujet du message..." />
                                </div>
                                <div class="form-outline mb-4">
                                    <textarea class="form-control" name="message" id="message" cols="30" rows="5" require placeholder="Votre message..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-4">
                                    Envoyer !
                                </button>
                                </form>
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