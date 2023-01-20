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
                <?php if (!empty($_SESSION) && ($_SESSION['role'] == 'admin')) : ?>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                                <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2zM3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z" />
                                <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item active" href="http://localhost/bootstrap/form-connexion/admin_dashboard.php?display=users">List Users</a></li>
                            <li><a class="dropdown-item" href="http://localhost/bootstrap/form-connexion/admin_dashboard.php?display=messages">Messages</a></li>
                            <li><a class="dropdown-item" href="#">In progress...</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">In progress...</a></li>
                        </ul>
                    </div>
                <?php endif ?>
                <li><a href="http://localhost/bootstrap/form-connexion/" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="http://localhost/bootstrap/form-connexion/contact.php" class="nav-link px-2 link-dark">contact</a></li>
                <li><a href="http://localhost/bootstrap/form-connexion/about.php" class="nav-link px-2 link-dark">A propos de moi</a></li>

            </ul>

            <div class="col-md-3 text-end">
                <?php if (empty($_SESSION)) : ?>
                    <a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Connexion</button></a>
                    <a href="register.php"><button type="button" class="btn btn-primary">Inscription</button></a>
                <?php else : ?>
                    <a href="http://localhost/bootstrap/form-connexion/functions/form-control.php?func=logout"><button type="button" class="btn btn-primary">Log Out</button></a>
                <?php endif ?>
            </div>
        </header>
    </div>