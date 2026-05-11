<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une activité - Ré-Gym Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>
        
        <section class="hero">
            <h1>➕ Ajouter une activité</h1>
            <p>Créez une nouvelle activité sportive disponible pour les utilisateurs.</p>
        </section>

        <section class="card card--pad card--form">
            <?php if (isset($errors) && is_array($errors) && count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-content">
                        <strong>Erreurs détectées</strong>
                        <ul class="alert-list">
                            <?php foreach ($errors as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form action="/admin/activite-save" method="post" class="form">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="nom">Nom de l'activité</label>
                    <input type="text" id="nom" name="nom" placeholder="Ex: Course à pied" required value="<?= isset($old['nom']) ? esc($old['nom']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="objectif">Objectif</label>
                    <select id="objectif" name="id_objectif" required>
                        <option value="">Sélectionnez un objectif</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= $objectif['id_Objectif'] ?>" <?= (isset($old['id_objectif']) && $old['id_objectif'] == $objectif['id_Objectif']) ? 'selected' : '' ?>>
                                <?= $objectif['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Durée</label>
                    <div class="form-row">
                        <div>
                            <label for="mois" class="form-label--small">Mois</label>
                            <input type="number" min="0" id="mois" name="mois" placeholder="0" value="<?= isset($old['mois']) ? esc($old['mois']) : '0' ?>">
                        </div>
                        <div>
                            <label for="jours" class="form-label--small">Jours</label>
                            <input type="number" min="0" max="31" id="jours" name="jours" placeholder="0" value="<?= isset($old['jours']) ? esc($old['jours']) : '0' ?>">
                        </div>
                        <div>
                            <label for="heures" class="form-label--small">Heures</label>
                            <input type="number" min="0" max="23" id="heures" name="heures" placeholder="0" value="<?= isset($old['heures']) ? esc($old['heures']) : '0' ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="variation_poids">Variation du poids (kg)</label>
                    <input type="number" step="0.01" id="variation_poids" name="variation_poids" placeholder="Ex: -0.5" required value="<?= isset($old['variation_poids']) ? esc($old['variation_poids']) : '0' ?>">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">✅ Ajouter l'activité</button>
                    <a href="/admin/activites" class="btn btn--secondary">❌ Annuler</a>
                </div>
            </form>
        </section>
    </div>
</body>
</html>