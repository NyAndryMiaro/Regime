<?php
    $mois = 0;
    $jours = 0;
    $heures = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar-admin.html"); ?>

        <section class="hero">
            <h1>Modifier l' activité</h1>
            <p>Modifier le formulaire ci-dessous pour mettre a jour cette activité sportive.</p>
        </section>

        <section class="card card--pad">
            <form action="/admin/activite-modify" method="post" class="form stack">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nom">Nom de l'activité :</label>
                    <input type="text" id="nom" name="nom" value="<?= $activite["libelle"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="objectif">Objectif :</label>
                    <select id="objectif" name="id_objectif" required>
                        <option value="">Sélectionnez un objectif</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= $objectif['id_Objectif'] ?>" <?= ($objectif['id_Objectif'] == $activite['id_Objectif']) ? 'selected' : '' ?>><?= $objectif['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Durée :</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="number" min="0" id="mois" name="mois" placeholder="Mois" value="<?= $mois ?>" style="width: 80px;">
                        <input type="number" min="0" max="31" id="jours" name="jours" placeholder="Jours" value="<?= $jours ?>" style="width: 80px;">
                        <input type="number" min="0" max="23" id="heures" name="heures" placeholder="Heures" value="<?= $heures ?>" style="width: 80px;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="variation_poids">Variation du poids (kg) :</label>
                    <input type="number" step="0.01" id="variation_poids" name="variation_poids" value="<?= $activite["variation_poids"] ?>" required>
                </div>

                <input type="hidden" name="id_activite" value="<?= $activite['id_Activite'] ?>">
                <button type="submit" class="btn btn--primary">Modifier cette activite</button>
            </form>
        </section>

    </div>

    <a href="/admin/activites">Retour a la liste</a>

</body>

</html>