<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>
<h1>Listes des employées Inactifs</h1>
<div class="container">
    <div class="table-responsive" style="font-size:11px">
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
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <a href="<?= site_url('admin/users') ?>" class="btn btn-primary">Actifs</a>
                                <a href="<?= site_url('admin/users?showDeleted=1') ?>" class="btn btn-secondary">Inactifs</a>
                            </div>
                        </div>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $user['matricule'] ?></td>
                                <td><?= $user['nom'] ?></td>
                                <td><?= $user['prenoms'] ?></td>
                                <td><?= $user['titre'] ?></td>
                                <td><?= $user['date_embauche'] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Lien pour réactiver l'utilisateur -->
                                        <a href="<?= site_url("admin/users/reactivate/{$user['id']}") ?>" class="btn btn-smbtn-success">Réactiver</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>