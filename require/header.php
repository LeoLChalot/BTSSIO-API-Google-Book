<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">


            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="contact.php" class="nav-link px-2 link-dark">contact</a></li>
                <li><a href="about.php" class="nav-link px-2 link-dark">A propos de moi</a></li>
            </ul>

            <div class="col-md-3 text-end">
                <?php if (empty($_SESSION)) : ?>
                    <a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Connexion</button></a>
                    <a href="register.php"><button type="button" class="btn btn-primary">Inscription</button></a>
                <?php else : ?>
                    <a href="functions/form-control.php?func=logout"><button type="button" class="btn btn-primary">Log Out</button></a>
                <?php endif ?>
            </div>
        </header>
    </div>