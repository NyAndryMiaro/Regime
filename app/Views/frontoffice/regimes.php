<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Régimes - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <?php include("navbar/navbar-user.html"); ?>

    <div class="container regimes-container">
        <div class="regimes-header">
            <h1>🎯 Régimes Personnalisés</h1>
            <p>Trouvez le régime parfait pour atteindre vos objectifs</p>
            <a href="/plan" class="btn btn--primary front-link-btn">
                📋 Voir mon plan complet
            </a>
        </div>

        <div class="user-metrics">
            <div class="metric-item">
                <div class="metric-label">Taille</div>
                <div class="metric-value"><?= $user['taille'] ?></div>
                <div class="metric-unit">cm</div>
            </div>
            <div class="metric-item">
                <div class="metric-label">Poids Actuel</div>
                <div class="metric-value"><?= $user['poids'] ?></div>
                <div class="metric-unit">kg</div>
            </div>
            <div class="metric-item">
                <div class="metric-label">IMC Actuel</div>
                <div class="metric-value"><?= number_format(($user['poids']) / (($user['taille']) ** 2 / 10000), 1) ?></div>
                <div class="metric-unit">kg/m²</div>
            </div>
            <div class="metric-item">
                <div class="metric-label">Poids Idéal</div>
                <div class="metric-value"><?= $poidsIdeal['poids_ideal'] ?></div>
                <div class="metric-unit">kg</div>
            </div>
        </div>

        <div class="objectif-info">
            <p>
                <?php if ($objectifActuel): ?>
                    <strong>Objectif:</strong> <?= esc($objectifActuel['libelle']) ?>
                    <?php if ($infoObjectif): ?>
                        <br><strong>Approche:</strong> <?= $infoObjectif ?>
                        <?php if ($ecart > 0): ?>
                            <br><strong>À faire:</strong> <?= abs($ecart) ?>kg à 
                            <?php if ($objectifActuel['id_Objectif'] == 3 && $user['poids'] > $poidsIdeal['poids_ideal']): ?>
                                perdre
                            <?php elseif ($objectifActuel['id_Objectif'] == 3): ?>
                                gagner
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <strong>⚠️</strong> Veuillez d'abord choisir un objectif pour voir les régimes recommandés.
                    <a href="/objectif" class="inline-link">Choisir un objectif →</a>
                <?php endif; ?>
            </p>
        </div>

        <?php if (!empty($regimes)): ?>
            <div class="regimes-grid">
                <?php foreach ($regimes as $index => $regime): ?>
                    <div class="regime-card-wrapper <?= $index === $regimeRecommandeIndex && count($regimes) > 1 ? 'recommended' : '' ?>">
                        <?php if ($index === $regimeRecommandeIndex && count($regimes) > 1): ?>
                            <div class="recommended-badge">⭐ Recommandé</div>
                        <?php endif; ?>
                        <div class="regime-card">
                            <div class="regime-card-header">
                                <div class="regime-title"><?= esc($regime['libelle']) ?></div>
                                <span class="regime-badge <?= $regime['variation_poids'] > 0 ? 'positive' : 'negative' ?>">
                                    <?php if ($regime['variation_poids'] > 0): ?>
                                        +<?= $regime['variation_poids'] ?>kg
                                    <?php else: ?>
                                        <?= $regime['variation_poids'] ?>kg
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div class="regime-info">
                                <div class="info-item">
                                    <div class="info-label">Prix unitaire</div>
                                    <div class="info-value"><?= number_format($regime['prix_unitaire'], 0, ',', ' ') ?> F</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Durée</div>
                                    <div class="info-value"><?= $regime['duree'] ?> jours</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Poids après</div>
                                    <div class="info-value"><?= round($user['poids'] + $regime['variation_poids'], 1) ?>kg</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Variation/jour</div>
                                    <div class="info-value"><?= round($regime['variation_poids'] / $regime['duree'], 2) ?>kg</div>
                                </div>
                            </div>

                            <div>
                                <div class="composition-heading">Composition:</div>
                                <div class="regime-composition">
                                    <div class="composition-item">
                                        <div class="composition-box viande"></div>
                                        Viande: <?= $regime['pourcentage_viande'] ?>%
                                    </div>
                                    <div class="composition-item">
                                        <div class="composition-box poisson"></div>
                                        Poisson: <?= $regime['pourcentage_poisson'] ?>%
                                    </div>
                                    <div class="composition-item">
                                        <div class="composition-box legume"></div>
                                        Légumes: <?= $regime['pourcentage_legume'] ?>%
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h3>Aucun régime disponible</h3>
                <p>Veuillez d'abord choisir un objectif pour voir les régimes disponibles.</p>
                <a href="/objectif" class="btn btn--primary">Choisir un objectif</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>

</body>

</html>
