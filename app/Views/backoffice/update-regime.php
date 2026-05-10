<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un régime</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>

        <section class="hero">
            <h1>Modifier le régime</h1>
            <p>Modifier le formulaire ci-dessous pour mettre à jour ce régime.</p>
        </section>

        <section class="card card--pad">
            <?php if (isset($errors) && is_array($errors) && count($errors) > 0): ?>
                <section class="error-section">
                    <ul style="color: red;">
                        <?php foreach ($errors as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <form action="/admin/regime-modify" method="post" class="form stack">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="libelle">Nom du régime :</label>
                    <input type="text" id="libelle" name="libelle" value="<?= isset($old['libelle']) ? esc($old['libelle']) : $regime["libelle"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="objectif">Objectif :</label>
                    <select id="objectif" name="id_objectif" required>
                        <option value="">Sélectionnez un objectif</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= $objectif['id_Objectif'] ?>" <?= (isset($old['id_objectif']) ? $old['id_objectif'] : $regime['id_objectif']) == $objectif['id_Objectif'] ? 'selected' : '' ?>><?= $objectif['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="duree">Durée (heures) :</label>
                    <input type="number" min="0" id="duree" name="duree" value="<?= isset($old['duree']) ? esc($old['duree']) : $regime["duree"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="variation_poids">Variation du poids (kg) :</label>
                    <input type="number" step="0.01" id="variation_poids" name="variation_poids" value="<?= isset($old['variation_poids']) ? esc($old['variation_poids']) : $regime["variation_poids"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="prix_unitaire">Prix unitaire :</label>
                    <input type="number" step="0.01" id="prix_unitaire" name="prix_unitaire" value="<?= isset($old['prix_unitaire']) ? esc($old['prix_unitaire']) : $regime["prix_unitaire"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="pourcentage_viande">Pourcentage de viande (%) :</label>
                    <input type="number" min="0" max="100" id="pourcentage_viande" name="pourcentage_viande" value="<?= isset($old['pourcentage_viande']) ? esc($old['pourcentage_viande']) : $regime["pourcentage_viande"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="pourcentage_poisson">Pourcentage de poisson (%) :</label>
                    <input type="number" min="0" max="100" id="pourcentage_poisson" name="pourcentage_poisson" value="<?= isset($old['pourcentage_poisson']) ? esc($old['pourcentage_poisson']) : $regime["pourcentage_poisson"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="pourcentage_legume">Pourcentage de légume (%) :</label>
                    <input type="number" min="0" max="100" id="pourcentage_legume" name="pourcentage_legume" value="<?= isset($old['pourcentage_legume']) ? esc($old['pourcentage_legume']) : $regime["pourcentage_legume"] ?>" required>
                </div>

                <input type="hidden" name="id_regime" value="<?= $regime['id_Regime'] ?>">
                <button type="submit" class="btn btn--primary">Modifier ce régime</button>
            </form>
        </section>

    </div>

    <a href="/admin/regimes">Retour à la liste</a>

</body>

</html>