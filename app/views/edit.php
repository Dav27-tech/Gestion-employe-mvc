<?php require __DIR__ . '/header.php'; ?>
<section class="form-panel">
    <h2>Modifier un employé</h2>
    <a class="back-link" href="?page=liste">
        <span aria-hidden="true">←</span>
        Retour à la liste
    </a>
    <form action="?page=update" method="POST" class="input-group employee-form">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <div class="form-field">
            <label>Nom complet</label>
            <input type="text" name="nom" value="<?php echo $data['nom']; ?>" placeholder="Ex: Marie Dupont" required>
        </div>

        <div class="form-field">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $data['email']; ?>" placeholder="Ex: marie.dupont@email.com" required>
        </div>

        <div class="form-field">
            <label>Poste</label>
            <input type="text" name="poste" value="<?php echo $data['poste']; ?>" placeholder="Ex: Développeur web" required>
        </div>

        <div class="form-field">
            <label>Département</label>
            <input type="text" name="departement" value="<?php echo $data['departement']; ?>" placeholder="Ex: Informatique" required>
        </div>

        <div class="form-field">
            <label>Salaire</label>
            <input type="number" name="salaire" value="<?php echo $data['salaire']; ?>" placeholder="Ex: 45000" required>
        </div>

        <div class="hero-buttons">
            <button class="btn btn-primary" type="submit">Mettre à jour</button>
            <a class="btn btn-cancel" href="?page=liste">Annuler</a>
        </div>
    </form>
</section>
<?php require __DIR__ . '/footer.php'; ?>
