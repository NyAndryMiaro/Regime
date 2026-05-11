<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'activité - Ré-Gym Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>

        <section class="hero">
            <h1>✏️ Modifier l'activité</h1>
            <p>Mettez à jour les informations de cette activité sportive.</p>
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

            <form action="/admin/activite-modify" method="post" class="form">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nom">Nom de l'activité</label>
                    <input type="text" id="nom" name="nom" value="<?= isset($old['nom']) ? esc($old['nom']) : $activite["libelle"] ?>" required>
                </div>

                <div class="form-group">
                    <label for="objectif">Objectif</label>
                    <select id="objectif" name="id_objectif" required>
                        <option value="">Sélectionnez un objectif</option>
                        <?php foreach ($objectifs as $objectif): ?>
                            <option value="<?= $objectif['id_Objectif'] ?>" <?= (isset($old['id_objectif']) ? $old['id_objectif'] : $activite['id_Objectif']) == $objectif['id_Objectif'] ? 'selected' : '' ?>>
                                <?= $objectif['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Durée</label>
                    <div class="form-row">
                        <?php 
                            $duree = $activite['duree'] ?? 0;
                            $mois = 0;
                            $jours = 0;
                            $heures = 0;
                            
                            if ($duree > 24) {
                                $jours = floor($duree / 24);
                                $heures = $duree % 24;
                            } else {
                                $heures = $duree;
                            }
                            
                            if ($jours > 30) {
                                $mois = floor($jours / 30);
                                $jours = $jours % 30;
                            }
                        ?>
                        <div>
                            <label for="mois" class="form-label--small">Mois</label>
                            <input type="number" min="0" id="mois" name="mois" placeholder="0" value="<?= isset($old['mois']) ? esc($old['mois']) : $mois ?>">
                        </div>
                        <div>
                            <label for="jours" class="form-label--small">Jours</label>
                            <input type="number" min="0" max="31" id="jours" name="jours" placeholder="0" value="<?= isset($old['jours']) ? esc($old['jours']) : $jours ?>">
                        </div>
                        <div>
                            <label for="heures" class="form-label--small">Heures</label>
                            <input type="number" min="0" max="23" id="heures" name="heures" placeholder="0" value="<?= isset($old['heures']) ? esc($old['heures']) : $heures ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="variation_poids">Variation du poids (kg)</label>
                    <input type="number" step="0.01" id="variation_poids" name="variation_poids" value="<?= isset($old['variation_poids']) ? esc($old['variation_poids']) : $activite["variation_poids"] ?>" required>
                </div>

                <input type="hidden" name="id_activite" value="<?= $activite['id_Activite'] ?>">
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">✅ Modifier cette activité</button>
                    <a href="/admin/activites" class="btn btn-logout">❌ Annuler</a>
                </div>
            </form>
        </section>
    </div>
</body>
</html>