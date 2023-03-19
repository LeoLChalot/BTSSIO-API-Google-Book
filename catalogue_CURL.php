<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<?php require_once(__DIR__ . '/class/BookSearcher.php');
// define('APIKEY', '$AIzaSyAY1N3MiifNN02kmk2X6j64tk6WVP57kqQ');
?>
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
    <div class="container py-4">
        <div class="row g-0 align-items-center justify-content-center">
            <div class="col-lg-5 mb-6 mb-lg-0">
                <img src="assets/img/backgrounds/catalogue.jpg" class="w-100 rounded-4 shadow-4" alt="" />
            </div>
            <div class="center col-lg-5 mb-5 mb-lg-0">
                <div class="card cascading-right shadow-sm w-100 center" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
                    <div class="card-body p-5 shadow-5 text-center">
                        <h2 class="fw-bold mb-5">Le catalogue !</h2>
                        <form class="mb-3" action="" method="GET">
                            <input type="text" class="form-control" id="title" name="title" placeholder="titre du livre">
                            <button type="submit" class="btn btn-primary mt-3 btn-block mb-4">
                                Rechercher
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <?php if (!empty($_GET['title'])) : ?>
                <?php

                $title = $_GET['title'];
                $curl = curl_init('http://books.google.com/books/feeds/volumes?q=' . $title . '&key=$AIzaSyAY1N3MiifNN02kmk2X6j64tk6WVP57kqQ');
                // Options
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_TIMEOUT => 0
                );

                curl_setopt_array($curl, $options);

                $data = json_decode(curl_exec($curl));
                // $data = curl_exec($curl);

                if ($data === false) {
                    var_dump(curl_error($curl));
                } else {
                    var_dump($data);
                    
                }




                ?>
                <div class="center col-lg-8 mt-5 mb-5 mb-lg-0">
                    <div class="card cascading-right shadow-sm" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
                        <div class="card-body p-5 shadow-5 text-center d-flex flex-column align-items-center">
                            <h3>Liste des livres trouvés</h3>
                            <!-- <?php for ($i = 0; $i < count($livres); $i++) : ?>
                                <div class="book-card col-12 d-flex gap-5 m-4 p-4 border-bottom d-flex flex-row justify-content-center align-items-center">
                                    <?php if (isset($livres[$i]['image'])) : ?>
                                        <div class="book-img">
                                            <img src="<?= $livres[$i]['image'] ?>" alt="">
                                        </div>
                                    <?php endif ?>
                                    <div class="book-info d-flex flex-column gap-3 justify-content-center align-items-center">
                                        <p><strong><?= $livres[$i]['titre'] ?></strong></p>
                                        <p><strong>Auteur :</strong> '<?= $livres[$i]['auteur'] ?></p>
                                    </div>
                                </div>
                            <?php endfor ?> -->
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php
            if (isset($curl)) {
                curl_close($curl);
            } ?>

        </div>
    </div>
</section>
<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>