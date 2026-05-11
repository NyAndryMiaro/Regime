<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <!-- Navbar -->
    <?php include 'navbar/navbar-user.html'; ?>

    <div class="activites-container">
        <a href="/accueil" class="back-button">← Retour à l'accueil</a>

        <div class="activites-header">
            <h1>🏃 Activités</h1>
            <p>Découvrez les activités adaptées à votre objectif</p>
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
                <div class="metric-value"><?= number_format($user['poids'] / (($user['taille'] / 100) ** 2), 1) ?></div>
                <div class="metric-unit">kg/m²</div>
            </div>
            <div class="metric-item">
                <div class="metric-label">Poids Idéal</div>
                <div class="metric-value"><?= number_format($poidsIdeal['poids_ideal'], 1) ?></div>
                <div class="metric-unit">kg</div>
            </div>
        </div>

        <?php if ($objectifActuel): ?>
            <div class="objectif-info">
                <p>📍 <strong><?= esc($infoObjectif) ?></strong></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($activites)): ?>
            <div class="activites-grid">
                <?php foreach ($activites as $index => $activite): ?>
                    <div class="activite-card-wrapper <?= $index === $activiteRecommandeIndex && count($activites) > 1 ? 'recommended' : '' ?>">
                        <?php if ($index === $activiteRecommandeIndex && count($activites) > 1): ?>
                            <div class="recommended-badge">⭐ Recommandée</div>
                        <?php endif; ?>
                        <div class="activite-card">
                            <div class="activite-card-header">
                                <div class="activite-title"><?= esc($activite['libelle']) ?></div>
                                <span class="activite-badge <?= $activite['variation_poids'] > 0 ? 'positive' : 'negative' ?>">
                                    <?php if ($activite['variation_poids'] > 0): ?>
                                        +<?= $activite['variation_poids'] ?>kg
                                    <?php else: ?>
                                        <?= $activite['variation_poids'] ?>kg
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div class="activite-details">
                                <div class="detail-item">
                                    <div class="detail-label">Durée</div>
                                    <div class="detail-value"><?= $activite['duree'] ?> min</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Impact</div>
                                    <div class="detail-value"><?= abs($activite['variation_poids']) ?> kg</div>
                                </div>
                            </div>

                            <div class="card-note">
                                <p>
                                    💪 Une activité efficace pour votre objectif
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🚫</div>
                <h3>Aucune activité disponible</h3>
                <p>Veuillez d'abord choisir un objectif pour voir les activités disponibles.</p>
                <a href="/objectif" class="back-button">Choisir un objectif</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>

</body>

</html>
