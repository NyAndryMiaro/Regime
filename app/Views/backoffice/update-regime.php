<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le régime - Ré-Gym Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>

        <section class="hero">
            <h1>✏️ Modifier le régime</h1>
            <p>Mettez à jour les informations de ce régime alimentaire.</p>
        </section>

        <section class="card card--pad" style="max-width: 700px;">
            <?php if (isset($errors) && is_array($errors) && count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-content">
                        <strong>Erreurs détectées</strong>
                        <ul style="margin: 0.5rem 0 0 1rem; padding-left: 1rem;">
                            <?php foreach ($errors as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form action="/admin/regime-modify" method="post" class="form">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="libelle">Nom du régime</label>
                    <input type="text" id="libelle" name="libelle" value="<?= isset($old['libelle']) ? esc($old['libelle']) : $regime["libelle"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="objectif">Objectif</label>
                    <select id="objectif" name="id_objectif" required>
                        <option value="">Sélectionnez un objectif</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= $objectif['id_Objectif'] ?>" <?= (isset($old['id_objectif']) ? $old['id_objectif'] : $regime['id_objectif']) == $objectif['id_Objectif'] ? 'selected' : '' ?>>
                                <?= $objectif['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duree">Durée (heures)</label>
                        <input type="number" min="0" id="duree" name="duree" value="<?= isset($old['duree']) ? esc($old['duree']) : $regime["duree"] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="variation_poids">Variation poids (kg)</label>
                        <input type="number" step="0.01" id="variation_poids" name="variation_poids" value="<?= isset($old['variation_poids']) ? esc($old['variation_poids']) : $regime["variation_poids"] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="prix_unitaire">Prix unitaire (€)</label>
                        <input type="number" step="0.01" id="prix_unitaire" name="prix_unitaire" value="<?= isset($old['prix_unitaire']) ? esc($old['prix_unitaire']) : $regime["prix_unitaire"] ?>" required>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid var(--border);">
                    <h3 style="margin-bottom: 1rem; color: var(--primary);">🥗 Composition nutritionnelle</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pourcentage_viande">🥩 Viande (%)</label>
                            <input type="number" min="0" max="100" id="pourcentage_viande" name="pourcentage_viande" value="<?= isset($old['pourcentage_viande']) ? esc($old['pourcentage_viande']) : $regime["pourcentage_viande"] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="pourcentage_poisson">🐟 Poisson (%)</label>
                            <input type="number" min="0" max="100" id="pourcentage_poisson" name="pourcentage_poisson" value="<?= isset($old['pourcentage_poisson']) ? esc($old['pourcentage_poisson']) : $regime["pourcentage_poisson"] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="pourcentage_legume">🥬 Légume (%)</label>
                            <input type="number" min="0" max="100" id="pourcentage_legume" name="pourcentage_legume" value="<?= isset($old['pourcentage_legume']) ? esc($old['pourcentage_legume']) : $regime["pourcentage_legume"] ?>" required>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id_regime" value="<?= $regime['id_Regime'] ?>">
                
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn--primary" style="flex: 1;">✅ Modifier ce régime</button>
                    <a href="/admin/regimes" class="btn btn--secondary" style="flex: 1; text-align: center;">❌ Annuler</a>
                </div>
            </form>
        </section>
    </div>
</body>

</html>