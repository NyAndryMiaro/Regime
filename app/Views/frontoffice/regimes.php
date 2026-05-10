<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Régimes - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <style>
        .regimes-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .regimes-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .regimes-header h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .user-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
        }

        .metric-item {
            text-align: center;
        }

        .metric-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }

        .metric-unit {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .objectif-info {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 8px;
        }

        .objectif-info p {
            margin: 0;
            color: #333;
            font-size: 1.1rem;
        }

        .regimes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .regime-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .regime-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .regime-card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .regime-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            flex: 1;
        }

        .regime-badge {
            background: #667eea;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            white-space: nowrap;
        }

        .regime-badge.positive {
            background: #10b981;
        }

        .regime-badge.negative {
            background: #ef4444;
        }

        .regime-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1.5rem 0;
            padding: 1.5rem 0;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            flex-grow: 1;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .info-value {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
        }

        .regime-composition {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            flex-wrap: wrap;
        }

        .composition-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #f3f4f6;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #1f2937;
            font-weight: 500;
        }

        .composition-box {
            width: 16px;
            height: 16px;
            border-radius: 3px;
        }

        .viande {
            background: #ef4444;
        }

        .poisson {
            background: #3b82f6;
        }

        .legume {
            background: #10b981;
        }

        .regime-actions {
            display: flex;
            gap: 1rem;
            margin-top: auto;
        }

        .btn {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5568d3;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #f9fafb;
            border-radius: 12px;
            margin-top: 2rem;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 1.5rem;
        }

        .recommended-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #fbbf24;
            color: #92400e;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .regime-card-wrapper {
            position: relative;
        }

        .regime-card-wrapper.recommended {
            border: 2px solid #fbbf24;
        }

        .regime-card-wrapper.recommended .regime-card {
            box-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include("navbar/navbar-user.html"); ?>

    <div class="container regimes-container">
        <!-- Header -->
        <div class="regimes-header">
            <h1>🎯 Régimes Personnalisés</h1>
            <p>Trouvez le régime parfait pour atteindre vos objectifs</p>
        </div>

        <!-- Métriques de l'utilisateur -->
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

        <!-- Info Objectif -->
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
                    <a href="/objectif" style="margin-left: 1rem; color: #667eea; text-decoration: none; font-weight: bold;">Choisir un objectif →</a>
                <?php endif; ?>
            </p>
        </div>

        <!-- Liste des Régimes -->
        <?php if (!empty($regimes)): ?>
            <div class="regimes-grid">
                <?php foreach ($regimes as $index => $regime): ?>
                    <div class="regime-card-wrapper <?= $index === 0 && count($regimes) > 1 ? 'recommended' : '' ?>">
                        <?php if ($index === 0 && count($regimes) > 1): ?>
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
                                <div style="font-weight: bold; color: #666; margin-bottom: 0.8rem; font-size: 0.9rem;">Composition:</div>
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
                <a href="/objectif" class="btn btn-primary" style="display: inline-block; width: auto;">Choisir un objectif</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>

    <script>
        // Animation au chargement
        document.querySelectorAll('.regime-card').forEach((card, index) => {
            card.style.animation = `fadeInUp 0.5s ease ${index * 0.1}s`;
        });

        // Ajouter les styles d'animation globaux
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
