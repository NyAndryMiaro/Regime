<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <style>
        .activites-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .activites-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .activites-header h1 {
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

        .activites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .activite-card-wrapper {
            position: relative;
        }

        .activite-card-wrapper.recommended {
            z-index: 10;
        }

        .activite-card-wrapper.recommended .activite-card {
            border: 2px solid #ffb800;
            background: linear-gradient(to bottom, #fffbf0, white);
        }

        .recommended-badge {
            position: absolute;
            top: -12px;
            left: 20px;
            background: linear-gradient(135deg, #ffb800 0%, #ff9500 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-weight: bold;
            z-index: 20;
            font-size: 0.9rem;
        }

        .activite-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 2px solid transparent;
        }

        .activite-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .activite-card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.5rem;
        }

        .activite-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
        }

        .activite-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            color: white;
        }

        .activite-badge.positive {
            background: #10b981;
        }

        .activite-badge.negative {
            background: #ef4444;
        }

        .activite-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 8px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .detail-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: #1f2937;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #f9fafb;
            border-radius: 12px;
            border: 2px dashed #d1d5db;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            color: #888;
            font-size: 0.9rem;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 2rem;
            padding: 0.75rem 1.5rem;
            background: #e5e7eb;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #d1d5db;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include 'navbar/navbar-user.html'; ?>

    <div class="activites-container">
        <a href="/accueil" class="back-button">← Retour à l'accueil</a>

        <div class="activites-header">
            <h1>🏃 Activités</h1>
            <p>Découvrez les activités adaptées à votre objectif</p>
            <a href="/plan" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: bold; transition: all 0.3s ease;" 
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.4)'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
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

                            <div style="margin-top: auto; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                                <p style="font-size: 0.9rem; color: #666; margin: 0;">
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
                <a href="/objectif" class="back-button" style="display: inline-block; width: auto;">Choisir un objectif</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>

    <script>
        document.querySelectorAll('.activite-card').forEach((card, index) => {
            card.style.animation = `fadeInUp 0.5s ease ${index * 0.1}s`;
        });

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
