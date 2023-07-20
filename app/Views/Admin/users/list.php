<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>
<h1> Listes des employées Actifs</h1>
<?php
$successMessage = session()->getFlashdata('success');
$errorMessage = session()->getFlashdata('error');
?>


<div class="d-flex justify-content-end mb-3">
    <a href="users/add" class="btn btn-primary">Ajouter</a>
</div>

<?php if ($errorMessage) : ?>
    <div class="alert alert-danger">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

<?php if ($successMessage) : ?>
    <div class="alert alert-success">
        <?php echo $successMessage; ?>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="<?= site_url('admin/users') ?>" class="btn btn-primary"> Actifs</a>
            <a href="<?= site_url('admin/users/inactive') ?>" class="btn btn-secondary"> Inactifs</a>
        </div>
    </div>
</div>

<div class="table-responsive" style="font-size:11px;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Titre</th>
                <th>Date d'embauche</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['matricule'] ?></td>
                    <td><?= $user['nom'] ?></td>
                    <td><?= $user['prenoms'] ?></td>
                    <td><?= $user['titre'] ?></td>
                    <td><?= $user['date_embauche'] ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                            <a href="users/delete/<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="btn btn-sm btn-danger">Supprimer</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>