<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php');
?>
<style>
    .cascading-right {
        margin-left: -50px;
    }

    @media (max-width: 992px) {
        .cascading-right {
            margin-right: 0;
        }
    }

    .card-container {
        width: 18rem;
        transition: .3s all ease;
    }

    .card-container:hover {
        z-index: 999;
        transform: scale(1.1);
    }

    .card-container img {
        transition: .3s all ease;
    }

    .card-container:hover img {
        transform: rotate(10deg);
    }

    li {
        list-style-type: none;
    }
</style>
<section class="text-center text-lg-start">
    <div class="container py-4">
        <div class="row g-0 align-items-center justify-content-center">
            <div class="col-lg-5 mb-6 mb-lg-0">
                <img src="assets/img/backgrounds/librairie_3.png" class="w-100 rounded-4 shadow-4" alt="" />
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
                $title = str_replace(' ', '+', $title);
                $url = "https://www.googleapis.com/books/v1/volumes?q=$title&langRestrict=fr&maxResults=3";
                $curl = curl_init($url);
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_URL => $url,
                    CURLOPT_CAINFO => __DIR__ . '/assets/Certificat/GTS Root R1.crt'
                );

                curl_setopt_array($curl, $options);

                $resp = curl_exec($curl);

                if ($e = curl_error($curl)) {
                    var_dump($e);
                } else {
                    $data = json_decode($resp, true);
                    $results = $data["items"];
                }
                ?>

                <div class="center col-md-12 d-flex justify-content-center py-5 flex-wrap gap-4">

                    <?php for ($i = 0; $i < count($results); $i++) : ?>

                        <div class="card card-container shadow">
                            <div class="card-header d-flex justify-content-center align-items-center" style="height: 15rem;">
                                <?php if (isset($results[$i]["volumeInfo"]['imageLinks']['thumbnail'])) : ?>
                                    <img class="card-img-top center" src="<?= $results[$i]["volumeInfo"]['imageLinks']['smallThumbnail'] ?>" style="width:130px;" alt="">
                                <?php else : ?>
                                    <img class="card-img-top center" src="assets/img/backgrounds/empty_book.png" style="width:200px;" alt="">
                                <?php endif ?>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="book-title">
                                    <h5><?= $results[$i]["volumeInfo"]["title"] ?></h5>
                                    <?php if (isset($results[$i]["volumeInfo"]["subtitle"])) : ?>
                                        <p class="card-text"><?= $results[$i]["volumeInfo"]["subtitle"] ?></p>
                                    <?php endif ?>
                                </div>
                                <div class="book-auteur">
                                    <?php if (isset($results[$i]["volumeInfo"]["authors"])) : ?>
                                        <p><strong>Auteur(s) :</strong></p>
                                        <ul>
                                            <?php foreach ($results[$i]["volumeInfo"]["authors"] as $author) : ?>
                                                <li><?= $author ?></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </div>
                                <div class="book-description text-justify">
                                    <?php if (isset($results[$i]["volumeInfo"]["description"])) : ?>
                                        <details>
                                            <summary>Details</summary>
                                            <p><?= $results[$i]["volumeInfo"]["description"]; ?></p>
                                        </details>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-around">
                                <a class="btn btn-primary" href="<?= $results[$i]['volumeInfo']['previewLink'] ?> " target="_blank">Lire</a>
                                <?php if (!empty($_SESSION)) : ?>
                                    <a class="btn btn-success" href="http://">Ajouter</a>
                                <?php endif ?>

                            </div>
                        </div>
                    <?php endfor ?>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>



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