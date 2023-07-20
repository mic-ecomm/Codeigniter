<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>

<div class="container" style="font-size:11px;">
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    <span class="display-4 d-flex justify-content-center text-danger mb-3">Connexion</span>
    <form action="<?= base_url('auth/profile') ?>" method="post">
        <!-- Champs de formulaire pour matricule, titre et code d'accès -->
        <div>
            <label for="matricule" class="form-label h5">Matricule:</label>
            <input type="text" name="matricule" id="matricule" class="form-control" required>
        </div>
        <div>
            <label for="titre" class="form-label h5">Titre dans l'E/se:</label>
            <input type="text" name="titre" id="titre" class="form-control">
        </div>
        <div>
            <label for="access_code" class="form-label h5">Code d'accès:</label>
            <input type="password" name="access_code" id="access_code" class="form-control" required>
        </div>
        <div class="mb-3 mt-3 display-3 d-flex justify-content-center text-danger">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>
    </div>
    <div class="col-md-4"></div>
</div>
    
</div>

<?= $this->endSection() ?>
