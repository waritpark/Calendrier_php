    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?= isset($data['nom']) ? h($data['nom']) : ''; ?>">
        <?php if (isset($errors['nom'])): ?>
        <p class="alert alert-danger"><?= $errors['nom']; ?></p>
        <?php endif;?>
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <textarea type="text" class="form-control" name="desc" id="desc"><?= isset($data['desc']) ? h($data['desc']) : ''; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" name="date" id="date" value ="<?= isset($data['date']) ? h($data['date']) : ''; ?>">
        <?php if (isset($errors['date'])): ?>
        <p class="alert alert-danger"><?= $errors['date']; ?></p>
        <?php endif;?>
    </div>
    <div class="mb-3">
        <label for="start" class="form-label">Début de l'événement</label>
        <input type="time" class="form-control" name="start" id="start" value="<?= isset($data['start']) ? h($data['start']) : ''; ?>">
        <?php if (isset($errors['start'])): ?>
        <p class="alert alert-danger"><?= $errors['start']; ?></p>
        <?php endif;?>
    </div>
    <div class="mb-3">
        <label for="end" class="form-label">fin de l'événement</label>
        <input type="time" class="form-control" name="end" id="end" value="<?= isset($data['end']) ? h($data['end']) : ''; ?>">
        <?php if (isset($errors['end'])): ?>
        <p class="alert alert-danger"><?= $errors['end']; ?></p>
        <?php endif;?>
        <?php if (isset($errors['time'])): ?>
        <p class="alert alert-danger"><?= $errors['time']; ?></p>
        <?php endif;?>

    </div>