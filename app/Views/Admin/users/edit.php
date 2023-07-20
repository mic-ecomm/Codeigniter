<!-- Formulaire de modification d'un utilisateur -->
<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>
<form method="post" action="/admin/users/edit/<?= $user['id'] ?>">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" id="nom" value="<?= $user['nom'] ?>" required>

    <label for="prenoms">Prénoms:</label>
    <input type="text" name="prenoms" id="prenoms" value="<?= $user['prenoms'] ?>">

    <label for="titre">Titre:</label>
    <input type="text" name="titre" id="titre" value="<?= $user['titre'] ?>">

    <label for="titre">Date d'embauche:</label>
    <input type="date" name="date_embauche" id="titre" value="<?= $user['date_embauche'] ?>">

    <input type="submit" value="Modifier">
</form>
<?= $this->endSection() ?>