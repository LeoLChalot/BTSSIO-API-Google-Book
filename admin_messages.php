<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<?php if (!empty($_POST['mail'])) {
    $userMail = $_POST['mail'];
}
?>
<?php if (!empty($_SESSION)) : ?>


    <section class="text-left container">

        <?php if (!empty($_POST['optionFilter']) && ($_POST['optionFilter'] == 2)) : ?>
            <form class="row g-3" action="" method="POST">
                <div class="col-auto">
                    <label for="inputPassword2" class="visually-hidden">Choix du filtre</label>
                    <select name="optionFilter" class="form-select" aria-label="Default select example">
                        <option value="1">Tous les messages</option>
                        <option value="2" selected>Par mail utilisateur</option>
                        <option value="3">Par date</option>
                        <option value="4">Utilisateurs inscrits</option>
                        <option value="5">Utilisateurs anonymes</option>
                    </select>
                </div>
                <div class="col-auto">
                    <label for="mail" class="visually-hidden">Mail</label>
                    <?php if (!empty($_POST['mail'])) : ?>
                        <input type="mail" name="mail" class="form-control" id="mail" value="<?= $userMail ?>">
                    <?php else : ?>
                        <input type="mail" name="mail" class="form-control" id="mail" placeholder="@mail">
                    <?php endif ?>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Ok</button>
                </div>
            </form>
        <?php else : ?>
            <form class="row g-3" action="" method="POST">
                <div class="col-auto">
                    <label for="inputPassword2" class="visually-hidden">Choix du filtre</label>
                    <select name="optionFilter" class="form-select" aria-label="Default select example">
                        <option value="1">Tous les messages</option>
                        <option value="2">Par mail utilisateur</option>
                        <option value="3">Par date</option>
                        <option value="4">Utilisateurs inscrits</option>
                        <option value="5">Utilisateurs anonymes</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Ok</button>
                </div>
            </form>
        <?php endif ?>


    </section>
    <section class="text-left container">
        <div class="row py-lg-5">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Messagerie
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php $filtre = $_POST['optionFilter'] ?>
                            <?php if ($filtre == 1) : ?>
                                <h5>Tous les messages</h5>
                                <?php $sth_listMessages = $connexion->prepare("SELECT * FROM messages ORDER BY mail") ?>
                            <?php elseif ($filtre == 2) : ?>
                                <h5>Utilisateur ciblé</h5>
                                <?php $sth_listMessages = $connexion->prepare("SELECT * FROM messages WHERE mail = '$userMail'"); ?>
                            <?php elseif ($filtre == 3) : ?>
                                <h5>Messages par dates</h5>
                                <?php $sth_listMessages = $connexion->prepare("SELECT * FROM messages ORDER BY dateEnvoi"); ?>
                            <?php elseif ($filtre == 4) : ?>
                                <h5>Utilisateurs Inscrits</h5>
                                <?php $sth_listMessages = $connexion->prepare("SELECT * FROM messages WHERE isRegister = 1"); ?>
                            <?php elseif ($filtre == 5) : ?>
                                <h5>Utilisateurs anonymes</h5>
                                <?php $sth_listMessages = $connexion->prepare("SELECT * FROM messages WHERE isRegister = 0"); ?>
                            <?php else : ?>
                                <? header('location: admin_messages.php'); ?>
                            <?php endif ?>

                            <?php $sth_listMessages->execute();
                            $listMessages = $sth_listMessages->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($listMessages as $message) : ?>

                                <div class="col-lg-12 col-md-8 m-1">
                                    <ul class="list-group">
                                        <?php if ($message['isRegister'] == true) : ?>
                                            <li class="list-group-item active bg-primary" aria-current="true">Utilisateur : <?= $message['mail'] ?> | Inscrit</li>
                                        <?php else : ?>
                                            <li class="list-group-item active bg-secondary" aria-current="true">Utilisateur : <?= $message['mail'] ?> | Anonyme</li>
                                        <?php endif ?>

                                        <li class="list-group-item">Sujet : <?= $message['sujet'] ?></li>
                                        <li class="list-group-item"><?= $message['msg'] ?></li>
                                        <li class="list-group-item">Envoyé le : <?= $message['dateEnvoi'] ?></li>
                                        <li class="list-group-item">
                                            <a href="mailto:<?= $message['mail'] ?>"><button type="button" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply-all-fill" viewBox="0 0 16 16">
                                                        <path d="M8.021 11.9 3.453 8.62a.719.719 0 0 1 0-1.238L8.021 4.1a.716.716 0 0 1 1.079.619V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                                                        <path d="M5.232 4.293a.5.5 0 0 1-.106.7L1.114 7.945a.5.5 0 0 1-.042.028.147.147 0 0 0 0 .252.503.503 0 0 1 .042.028l4.012 2.954a.5.5 0 1 1-.593.805L.539 9.073a1.147 1.147 0 0 1 0-1.946l3.994-2.94a.5.5 0 0 1 .699.106z" />
                                                    </svg></button></a>
                                            <a href="functions/admin-functions.php?func=msgDelete&id=<?= $message['id'] ?>"><button type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                    </svg></button></a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else : ?>
    <?php header('location: http://localhost/bootstrap/form-connexion/'); ?>
<?php endif ?>


<?php require_once(__DIR__ . '/require/footer.php'); ?>
<?php require_once(__DIR__ . '/require/bdd-off.php'); ?>