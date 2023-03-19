<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<?php
$sth_display = $connexion->prepare("SELECT * FROM users WHERE id = $userID");
$sth_display->execute();
$sth_user = $sth_display->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
foreach ($sth_user as $user) :  ?>

    <section class="container">
        <div class="container">
            <div class="rowm">
                <form action="functions/form-control.php?func=userEdit&id=<?= $user['id'] ?>" enctype="multipart/form-data" method="POST" class="d-flex justify-content-center gap-3 mt-3">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="assets/img/users/<?= $user['profil_picture'] ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 200px;">
                                <h5 class="my-3"><?= $user['prenom'] ?> <?= $user['nom'] ?></h5>
                                <div class="input-group mb-2">
                                    <input type="file" class="form-control" id="profil_picture" name="profil_picture" aria-describedby="inputGroupFileAddon03" aria-label="Upload" value="<?= $user['profil_picture']?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <label class="input-group-text justify-content-center" for="nom" style="width:100px">Nom</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" id="nom" name="nom" aria-describedby="inputGroup-sizing-default" value="<?= $user['nom'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <label class="input-group-text justify-content-center" for="prenom" style="width:100px">Prénom</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" id="prenom" name="prenom" aria-describedby="inputGroup-sizing-default" value="<?= $user['prenom'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <label class="input-group-text justify-content-center" for="profession" style="width:100px">Profession</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" id="profession" name="profession" aria-describedby="inputGroup-sizing-default" value="<?= $user['profession'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <label class="input-group-text justify-content-center" for="mail" style="width:100px">Mail</label>
                                    <input type="email" class="form-control" aria-label="Sizing example input" id="mail" name="mail" aria-describedby="inputGroup-sizing-default" value="<?= $user['mail'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <label class="input-group-text justify-content-center" for="telephone" style="width:100px">Téléphone</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" id="telephone" name="telephone" aria-describedby="inputGroup-sizing-default" value="<?= $user['telephone'] ?>">
                                </div>

                                <div class="input-group">
                                    <label class="input-group-text justify-content-center" for="adresse" style="width:100px">Adresse</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" id="adresse" name="adresse" aria-describedby="inputGroup-sizing-default" value="<?= $user['adresse'] ?>">
                                </div>

                            </div>
                        </div>
                    </div>

            </div>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <a href="user-profil.php">
                <button type="button" class="btn btn-outline-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backspace" viewBox="0 0 16 16">
                        <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"></path>
                        <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-7.08z"></path>
                    </svg>
                    Retour
                </button>
            </a>
            <a href="functions/form-control.php?func=userEdit&id=<?= $user['id'] ?>">
                <button type="submit" class="btn btn-outline-success">
                    Valider
                    <svg xmlns=" http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                        <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                        <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                    </svg>
                </button>
            </a>
        </div>

        </form>


    </section>

<?php endforeach ?>

<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>