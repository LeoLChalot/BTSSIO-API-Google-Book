<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php');
include 'class/Book.php';
?>
<?php var_dump($_SESSION['user']->getCollection()) ?>
<section class="text-center text-lg-start">
    <div class="container py-4">
        <div class="row w-100 d-flex flex-row align-items-center justify-content-center">
            <div class="col-lg-5 mb-6 mb-lg-0">
                <img src="assets/img/backgrounds/librairie_3.png" class="w-100 rounded-4 shadow-4" alt="" />
            </div>
            <div class="center d-flex col-md-6 mb-5 mb-lg-0">
                <div id="catalogue" class="card cascading-right col-md-12 shadow-sm w-100 center" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
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
                $book = new Book();
                $book = $book->search_book_name($title);
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                ?>

                <div class="center col-md-12 d-flex justify-content-center py-5 flex-wrap gap-4">
                    <?php if ($page == 1) : ?>
                        <?php $j = 0;
                        $count = 3 ?>
                    <?php elseif ($page == 2) : ?>
                        <?php $j = 3;
                        $count = 6 ?>
                    <?php elseif ($page == 3) : ?>
                        <?php $j = 6;
                        $count = 9 ?>
                    <?php elseif ($page == 4) : ?>
                        <?php $j = 9;
                        $count = 12 ?>
                    <?php elseif ($page == 5) : ?>
                        <?php $j = 12;
                        $count = 15 ?>
                    <?php else : ?>
                        <?php $j = 15;
                        $count = 18 ?>
                    <?php endif ?>

                    <?php for ($i = $j; $i < $count; $i++) : ?>

                        <div class="card card-container shadow">
                            <div class="card-header d-flex justify-content-center align-items-center" style="height: 15rem;">
                                <?php if (isset($book[$i]["volumeInfo"]['imageLinks']['thumbnail'])) : ?>
                                    <img class="card-img-top center" src="<?= $book[$i]["volumeInfo"]['imageLinks']['smallThumbnail'] ?>" style="width:130px;" alt="">
                                <?php else : ?>
                                    <img class="card-img-top center" src="assets/img/backgrounds/empty_book.png" style="width:200px;" alt="">
                                <?php endif ?>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="book-title">
                                    <h5><?= $book[$i]["volumeInfo"]["title"] ?></h5>
                                    <?php if (isset($book[$i]["volumeInfo"]["subtitle"])) : ?>
                                        <p class="card-text"><?= $book[$i]["volumeInfo"]["subtitle"] ?></p>
                                    <?php endif ?>
                                </div>
                                <div class="book-auteur">
                                    <?php if (isset($book[$i]["volumeInfo"]["authors"])) : ?>
                                        <p><strong>Auteur(s) :</strong></p>
                                        <ul>
                                            <?php foreach ($book[$i]["volumeInfo"]["authors"] as $author) : ?>
                                                <li><?= $author ?></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-around">
                                <a class="btn btn-primary" href="<?= $book[$i]['volumeInfo']['previewLink'] ?> " target="_blank">Lire</a>
                                <?php if (!empty($_SESSION)) : ?>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#<?= $book[$i]['id'] ?>">
                                        Ajouter
                                    </button>
                                    <div class="modal fade" id="<?= $book[$i]['id'] ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalCenterTitle">Confirmation d'ajout du livre...</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body w-100 d-flex flex-column justify-content-center align-items-center">
                                                    <p>Vous êtes sur le point d'ajouter cette référence à votre collection privée.</p>
                                                    <div class="spinner-border text-success" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="?bookId=<?= $book[$i]['id'] ?>" method="post">
                                                        <input class="btn btn-success" type="submit" value="Ajouter">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif ?>
                                <?php if (isset($book[$i]['volumeInfo']['description'])) : ?>
                                    <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#description-<?= $book[$i]["id"] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                        </svg>
                                    </button>
                                    <div class="modal fade" id="description-<?= $book[$i]["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $book[$i]["volumeInfo"]['title'] ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?= $book[$i]["volumeInfo"]["description"] ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endfor ?>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($page == 1) : ?>
                            <li class="page-item disabled">
                            <?php else : ?>
                            <li class="page-item">
                            <?php endif ?>
                            <a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=<?= $page - 1 ?>">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=1">1</a></li>
                            <li class="page-item"><a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=2">2</a></li>
                            <li class="page-item"><a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=3">3</a></li>
                            <li class="page-item"><a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=4">4</a></li>
                            <li class="page-item"><a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=5">5</a></li>
                            <li class="page-item"><a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=6">6</a></li>
                            <?php if ($page == 6) : ?>
                                <li class="page-item disabled">
                                <?php else : ?>
                                <li class="page-item">
                                <?php endif ?>
                                <a class="page-link" href="catalogue.php?title=<?= $_GET['title'] ?>&page=<?= $page + 1 ?>">Next</a>
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
<?php

if (isset($_SESSION['user']) && isset($_GET['bookId'])) {
    $id_user = $_SESSION['user']->getId();
    $book = new Book();
    $book = $book->search_book_id($_GET['bookId']);
    $book_id = $book['id'];
    $req_verif = $connexion->prepare("SELECT COUNT(*) FROM biblio_perso WHERE book_id = '$book_id'");
    $req_verif->execute();
    $compare = $req_verif->fetch(PDO::FETCH_ASSOC);
    if ($compare["COUNT(*)"] == 0) {
        $req_add = $connexion->prepare("INSERT INTO biblio_perso(`book_id`, `title`, `subtitle`, `description`, `pageCount`, `img`, `id_user`)VALUES(:book_id, :title, :subtitle, :description, :pageCount, :img, :id_user)");
        $req_add->bindParam(':book_id', $book['id']);
        $req_add->bindParam(':title', $book['volumeInfo']['title']);
        $req_add->bindParam(':subtitle', $book['volumeInfo']['subtitle']);
        $req_add->bindParam(':description', $book['volumeInfo']['description']);
        $req_add->bindParam(':pageCount', $book['volumeInfo']['pageCount']);
        $req_add->bindParam(':img', $book['volumeInfo']['imageLinks']['smallThumbnail']);
        $req_add->bindParam(':id_user', $id_user);
        $req_add->execute();
        $_SESSION['user']->add_to_collection($book);
    }
}

?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>