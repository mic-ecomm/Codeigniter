<!DOCTYPE html>
<html>

<head>
    <title>Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="<?= site_url('/') ?>">Mon Entreprise</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (session()->isLoggedIn) : ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <div class="d-flex align-items-center">
                                <span class="mr-3 text-white"><?= session('prenom'); ?></span>
                                <span class="mr-3 text-white"><?= session('nom'); ?></span>
                                <span class="mr-3 text-white"><?= session('titre'); ?></span>
                                <a class="nav-link text-white" href="<?= site_url('/auth/logout') ?>">Déconnexion</a>
                            </div>
                        </li>
                    </ul>

                <?php else : ?>
                    <ul class="navbar-nav ml-auto">
                        <?php if (!session()->isLoggedIn) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('/') ?>">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('/registration') ?>">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('/login') ?>">Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">Mon Entreprise &copy; <?php echo date('Y'); ?></span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>