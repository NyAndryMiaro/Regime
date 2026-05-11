<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Régimes - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body>
    <?php include("navbar/navbar-user.html"); ?>

    <div class="container page-shell">
        <div class="stack">

            <!-- ── Hero ──────────────────────────────────────────────── -->
            <div class="card card--hero">
                <p class="card--hero__eyebrow">Nutrition</p>
                <h1 class="card--hero__title">🥗 Régimes personnalisés</h1>
                <p class="card--hero__subtitle">Trouvez le régime parfait pour atteindre vos objectifs.</p>
            </div>

            <!-- ── Métriques + objectif ───────────────────────────────── -->
            <section class="card card--pad">
                <div class="card-header card-header--tight">
                    <h2 class="card-title">📊 Vos métriques</h2>
                    <a href="/plan" class="btn btn-primary btn-sm">Voir mon plan</a>
                </div>

                <div class="user-metrics">
                    <div class="metric-item">
                        <div class="metric-label">Taille</div>
                        <div class="metric-value"><?= $user['taille'] ?></div>
                        <div class="metric-unit">cm</div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-label">Poids actuel</div>
                        <div class="metric-value"><?= $user['poids'] ?></div>
                        <div class="metric-unit">kg</div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-label">IMC</div>
                        <div class="metric-value"><?= number_format(($user['poids']) / (($user['taille']) ** 2 / 10000), 1) ?></div>
                        <div class="metric-unit">kg/m²</div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-label">Poids idéal</div>
                        <div class="metric-value"><?= $poidsIdeal['poids_ideal'] ?></div>
                        <div class="metric-unit">kg</div>
                    </div>
                </div>

                <?php if ($objectifActuel): ?>
                <div class="objectif-info mt-2">
                    <strong>Objectif :</strong> <?= esc($objectifActuel['libelle']) ?>
                    <?php if ($infoObjectif): ?>
                        &nbsp;·&nbsp;<strong>Approche :</strong> <?= $infoObjectif ?>
                        <?php if ($ecart > 0): ?>
                            &nbsp;·&nbsp;<strong>À faire :</strong> <?= abs($ecart) ?>kg à
                            <?= ($objectifActuel['id_Objectif'] == 3 && $user['poids'] > $poidsIdeal['poids_ideal']) ? 'perdre' : 'gagner' ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="objectif-info mt-2">
                    ⚠️ Veuillez d'abord choisir un objectif pour voir les régimes recommandés.
                    <a href="/objectif" class="inline-link">Choisir un objectif →</a>
                </div>
                <?php endif; ?>
            </section>

            <!-- ── Régimes ────────────────────────────────────────────── -->
            <?php if (!empty($regimes)): ?>
            <section class="card card--pad">
                <div class="card-header card-header--tight">
                    <h2 class="card-title">🥗 Régimes disponibles</h2>
                </div>
                <div class="regimes-grid">
                    <?php foreach ($regimes as $index => $regime): ?>
                    <?php $recommended = $index === $regimeRecommandeIndex && count($regimes) > 1; ?>
                    <div class="regime-card-wrapper <?= $recommended ? 'recommended' : '' ?>">
                        <?php if ($recommended): ?>
                        <div class="recommended-badge">⭐ Recommandé</div>
                        <?php endif; ?>
                        <div class="regime-card">
                            <div class="regime-card-header">
                                <div class="regime-title"><?= esc($regime['libelle']) ?></div>
                                <span class="regime-badge <?= $regime['variation_poids'] > 0 ? 'positive' : 'negative' ?>">
                                    <?= $regime['variation_poids'] > 0 ? '+' : '' ?><?= $regime['variation_poids'] ?>kg
                                </span>
                            </div>
                            <div class="regime-info">
                                <div class="info-item">
                                    <div class="info-label">Prix</div>
                                    <div class="info-value"><?= number_format($regime['prix_unitaire'], 0, ',', ' ') ?> Ar</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Durée</div>
                                    <div class="info-value"><?= $regime['duree'] ?> jours</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Poids après</div>
                                    <div class="info-value"><?= round($user['poids'] + $regime['variation_poids'], 1) ?> kg</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Variation/jour</div>
                                    <div class="info-value"><?= round($regime['variation_poids'] / $regime['duree'], 2) ?> kg</div>
                                </div>
                            </div>
                            <div>
                                <div class="composition-heading">Composition</div>
                                <div class="regime-composition">
                                    <span class="composition-item">
                                        <span class="composition-box viande"></span>
                                        Viande : <?= $regime['pourcentage_viande'] ?>%
                                    </span>
                                    <span class="composition-item">
                                        <span class="composition-box poisson"></span>
                                        Poisson : <?= $regime['pourcentage_poisson'] ?>%
                                    </span>
                                    <span class="composition-item">
                                        <span class="composition-box legume"></span>
                                        Légumes : <?= $regime['pourcentage_legume'] ?>%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h3>Aucun régime disponible</h3>
                <p>Veuillez d'abord choisir un objectif pour voir les régimes disponibles.</p>
                <a href="/objectif" class="btn btn-primary">Choisir un objectif</a>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <footer class="footer"><p>&copy; 2026 Ré-Gym</p></footer>
</body>
</html>