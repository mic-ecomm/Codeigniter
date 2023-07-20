<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>

<h1>Votre profil est: </h1>
<div class="container">
    <div>
        <b>Matricule: </b> <?= session('matricule') ?><br/>
        <b>Prenom:</b> <?= session('prenom') ?> <br/>
        <b>Nom: </b>  <?= session('nom') ?> <br/>
        <b>Titre: </b> <?= session('titre') ?> <br/>
    </div>
</div>

<?= $this->endSection() ?>