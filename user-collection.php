<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<section class="py-5 text-center container">
    <h1 class="fw-light">Librairie - Le mille feuilles</h1>
    <p class="lead text-muted">Bienvenue dans votre collection personnelles...</p>

    <?php
    if (isset($_SESSION['user'])) {
        $id_user = $_SESSION['user']->getId();
        $req_collection = $connexion->prepare("SELECT * FROM biblio_perso WHERE id_user = '$id_user' ORDER BY title");
        $req_collection->execute();
        $biblio = $req_collection->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($biblio);
    }
    ?>
    <div class="center col-md-12 d-flex justify-content-center py-5 flex-wrap gap-4">
        <?php for ($i = 0; $i < count($biblio); $i++) : ?>
            <div class="card card-container shadow">
                <div class="card-header d-flex justify-content-center align-items-center" style="height: 15rem;">
                    <?php if (!($biblio[$i]['img'] == null)) : ?>
                        <img class="card-img-top center" src="<?= $biblio[$i]['img'] ?>" style="width:130px;" alt="">
                    <?php else : ?>
                        <img class="card-img-top center" src="assets/img/backgrounds/empty_book.png" style="width:200px;" alt="">
                    <?php endif ?>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="book-title">
                        <h5><?= $biblio[$i]["title"] ?></h5>
                        <?php if (!($biblio[$i]["subtitle"]) == null) : ?>
                            <p class="card-text"><?= $biblio[$i]["subtitle"] ?></p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-around">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                        Supprimer
                    </button>
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalCenterTitle">Souhaitez-vous continuer ?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body w-100 d-flex flex-column justify-content-center align-items-center">
                                    <p>Vous êtes sur le point de supprimer cette référence de votre collection</p>
                                    <div class="spinner-border text-danger" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <!-- <?php var_dump($biblio[$i]["book_id"])?> -->
                                    <form method="GET" action="?book=<?= $biblio[$i]["book_id"] ?>">
                                        <input class="btn btn-danger" type="submit" value="Supprimer">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endfor ?>
    </div>


</section>
<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php
// var_dump($_POST['book']);

if (isset($_GET['book'])) {
    var_dump($_GET['book']);
    $id_user = $_SESSION['user']->getId();
    $book_id = $_GET['book'];
    $req_add = $connexion->prepare(
        "DELETE FROM biblio_perso 
        WHERE book_id = '$book_id' 
        AND id_user = '$id_user'"
    );
    $req_add->execute();
}


?>

<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>