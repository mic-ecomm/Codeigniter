<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Ajouter un nouvel utilisateur</h4>
                </div>
                <div class="card-body">
                    <!-- Formulaire d'ajout d'un nouvel utilisateur -->
                    <form method="post" action="/admin/users/add">
                        <div class="form-group">
                            <label for="matricule">Matricule:</label>
                            <input type="text" name="matricule" id="matricule" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" name="nom" id="nom" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="prenoms">Prénoms:</label>
                            <input type="text" name="prenoms" id="prenoms" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="titre">Titre:</label>
                            <input type="text" name="titre" id="titre" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="date_embauche">Date d'embauche:</label>
                            <input type="date" name="date_embauche" id="date_embauche" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>