<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Page d'inscription</h2>
    <?php if (count(validation_errors()) > 0) : ?>
        <div class="alert alert-danger">
            <?php foreach (validation_errors() as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= form_open('registration/process_registration', ['class' => 'needs-validation', 'novalidate' => '']) ?>
    <div class="mb-3">
        <label for="matricule" class="form-label">Matricule:</label>
        <input type="text" name="matricule" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="nom" class="form-label">Nom:</label>
        <input type="text" name="nom" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="prenoms" class="form-label">Prénoms:</label>
        <input type="text" name="prenoms" class="form-control">
    </div>

    <div class="mb-3">
        <label for="titre" class="form-label">Titre:</label>
        <input type="text" name="titre" class="form-control">
    </div>

    <div class="mb-3">
        <label for="mail" class="form-label">Mail:</label>
        <input type="email" name="mail" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Inscription</button>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
