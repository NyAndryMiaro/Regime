<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une activité</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <div class="page-shell stack">
         <?php include("navbar-admin.html");?>
        <section class="hero">
            <h1>Ajouter une activité</h1>
            <p>Remplissez le formulaire ci-dessous pour ajouter une nouvelle activité sportive.</p>
        </section>

        <section class="card card--pad">
            <form action="/admin/activite-save" method="post" class="form stack">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nom">Nom de l'activité :</label>
                    <input type="text" id="nom" name="nom" required>

                </div>

                <div class="form-group">
                    <label for="objectif">Objectif :</label>
                    <select id="objectif" name="id_objectif" required>
                        <option value="">Sélectionnez un objectif</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option name="id_objectif" value="<?= $objectif['id_Objectif'] ?>"><?= $objectif['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Durée :</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="number" min="0" id="mois" name="mois" placeholder="Mois" style="width: 80px;">
                        <input type="number" min="0" max="31" id="jours" name="jours" placeholder="Jours" style="width: 80px;">
                        <input type="number" min="0" max="23" id="heures" name="heures" placeholder="Heures" style="width: 80px;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="variation_poids">Variation du poids (kg) :</label>
                    <input type="number" step="0.01" id="variation_poids" name="variation_poids" required>
                </div>

                <button type="submit" class="btn btn--primary">Ajouter</button>
            </form>
        </section>
    </div>
</body>
</html>