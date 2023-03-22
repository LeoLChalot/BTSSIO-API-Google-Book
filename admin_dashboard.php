<?php require_once(__DIR__ . '/require/bdd-on.php'); ?>
<?php require_once(__DIR__ . '/require/header.php'); ?>
<?php if (!empty($_SESSION) && $_SESSION['user']->getRole() == 'admin') : ?>
    <section class="py-5 text-left container">

        <div class="row py-lg-5">
            <div class="accordion" id="accordionExample">


                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Liste des utilisateurs
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php $sth_listUsers = $connexion->prepare("SELECT * FROM users");
                            $sth_listUsers->execute();
                            $listUsers = $sth_listUsers->fetchAll(PDO::FETCH_ASSOC); ?>
                            <?php foreach ($listUsers as $user) : ?>
                                <div class="col-lg-12 col-md-8 m-1">
                                    <ul class="list-group">
                                        <li class="list-group-item active" aria-current="true">Détails compte ID : <?= $user['id'] ?></li>
                                        <li class="list-group-item">Prénom : <?= $user['prenom'] ?></li>
                                        <li class="list-group-item">Nom : <?= $user['nom'] ?></li>
                                        <li class="list-group-item">@Mail : <?= $user['mail'] ?></li>
                                        <li class="list-group-item">Rôle : <?= $user['role'] ?></li>
                                        <li class="list-group-item">
                                            <a href="functions/admin-functions?func=userEdit"><button type="button" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                    </svg></button></a>
                                            <?php if (!($user['role'] == 'admin')) : ?>
                                                <a href="functions/admin-functions.php?func=userDelete&id=<?= $user['id'] ?>"><button type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                        </svg></button></a>
                                            <?php endif ?>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>


                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Messagerie
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php $sth_listMessages = $connexion->prepare("SELECT * FROM messages");
                            $sth_listMessages->execute();
                            $listMessages = $sth_listMessages->fetchAll(PDO::FETCH_ASSOC); ?>
                            <?php foreach ($listMessages as $message) : ?>
                                <div class="col-lg-12 col-md-8 m-1">
                                    <ul class="list-group">
                                        <li class="list-group-item active <?php if ($message['isRegister'] == true) : ?>
                                            bg-primary" aria-current="true">Utilisateur : <?= $message['mail'] ?> | Inscrit</li>
                                    <?php else : ?>
                                        bg-secondary" aria-current="true">Utilisateur : <?= $message['mail'] ?> | Anonyme</li>
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