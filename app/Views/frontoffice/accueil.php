<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Régime - Tableau de Bord</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>

<body>
    <!-- Navigation -->
    <?php include("navbar/navbar-user.html"); ?>

        <!-- Header Section -->
        <div class="header-section" id="accueil">
            <div class="tableau">
                <h1>👋 Bienvenue sur Ré-Gym</h1>
                <p>Suivez votre progression vers vos <span class="objectif"> objectifs nutritionnels </span></p>
            </div>

            <div class="user-info">
                <p><strong>Vos informations:</strong></p>
                <p>Taille: <?= $user['taille'] ?? '165' ?> cm | Poids: <?= $user['poids'] ?? '65' ?> kg</p>
                <p>IMC: <?= number_format(($user['poids'] ?? 65) / (($user['taille'] ?? 165) ** 2 / 10000), 1) ?></p>

                <!-- Objectif (grouped in header for immediate visibility) -->
                <?php if (empty($objectif)) { ?>
                    <div class="objectif-section objectif-header">
                        <h2>Commencez par choisir un objectif</h2>

                        <form action="/objectif" method="post" id="choixObj">
                            <?php if (!empty($objectifs)) {
                                foreach ($objectifs as $obj) { ?>
                                    <p class="objectif-option"> <?= $obj["libelle"] ?> <input type="radio" name="objectif" value="<?= $obj["id_Objectif"] ?>" class="objectif-radio"></p>
                            <?php }
                            } ?>
                            <button type="submit" class="btn btn-primary btn-full">Valider</button>
                        </form>

                    </div>

                <?php } else{ ?>
                    <div class="objectif-section objectif-header">
                        <p class="objectif-selected"> Votre objectif : <?= esc($objectif['libelle']) ?> </p>
                    </div>
                <?php } ?>
            </div>
        </div>

    <div class="container page-continue">
        <!-- objectif moved into header for immediate visibility -->

        <!-- Statistiques Principales -->
        <div class="section-title">📊 Vos Statistiques</div>
        <div class="grid">
            <div class="card stat-card">
                <div class="stat-label">Objectif Calorique</div>
                <div class="stat-value">2200</div>
                <div class="stat-unit">kcal/jour</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 65%"></div>
                </div>
                <p class="text-gray small">1430 / 2200 kcal aujourd'hui</p>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Protéines</div>
                <div class="stat-value">65g</div>
                <div class="stat-unit">sur 110g</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 59%"></div>
                </div>
                <button class="btn btn-primary btn-sm btn-full mt-2">+ Ajouter</button>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Hydratation</div>
                <div class="stat-value">2.1L</div>
                <div class="stat-unit">sur 2.5L</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 84%"></div>
                </div>
                <button class="btn btn-primary btn-sm btn-full mt-2">💧 Boire</button>
            </div>
        </div>

        <!-- Régimes Recommandés -->
        <div class="section-title" id="regimes">🎯 Régimes Recommandés</div>
        <div class="card">
            <div style="text-align: center; padding: 2rem;">
                <p style="color: #666; margin-bottom: 1.5rem; font-size: 1.1rem;">Découvrez nos régimes personnalisés adaptés à vos objectifs</p>
                <a href="/regimes" class="btn btn-primary" style="display: inline-block; padding: 0.75rem 2rem; text-decoration: none; border-radius: 6px;">
                    Voir tous les régimes →
                </a>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="section-title mt-4">📈 Votre Progression</div>
        <div class="charts-container">
            <div class="chart-card">
                <h3>📊 Évolution du Poids (30j)</h3>
                <p class="card-subtitle">Votre poids passe progressivement de 68 kg à 65 kg. Objectif: stabilisation autour de 64 kg.</p>
                <canvas id="weightChart"></canvas>
                <div class="mini-metrics">
                    <span>Départ: 68 kg</span>
                    <span>Actuel: 65 kg</span>
                    <span>Objectif: 64 kg</span>
                </div>
            </div>

            <div class="chart-card">
                <h3>🥗 Répartition Nutritionnelle</h3>
                <p class="card-subtitle">Votre journée idéale: 50% glucides, 30% protéines, 20% lipides.</p>
                <canvas id="nutritionChart"></canvas>
                <div class="mini-metrics">
                    <span>Glucides: 50%</span>
                    <span>Protéines: 30%</span>
                    <span>Lipides: 20%</span>
                </div>
            </div>

            <div class="chart-card">
                <h3>📉 Calories Cette Semaine</h3>
                <p class="card-subtitle">Vous êtes légèrement au-dessus de la cible les mardi, samedi et jeudi.</p>
                <canvas id="caloriesChart"></canvas>
                <div class="mini-metrics">
                    <span>Cible: 2200 kcal</span>
                    <span>Moyenne: 2229 kcal</span>
                    <span>Max: 2400 kcal</span>
                </div>
            </div>

            <div class="chart-card">
                <h3>💧 Hydratation</h3>
                <p class="card-subtitle">Votre hydratation reste proche de l'objectif de 2.5 L par jour.</p>
                <canvas id="hydrationChart"></canvas>
                <div class="mini-metrics">
                    <span>Moyenne: 2.3 L</span>
                    <span>Objectif: 2.5 L</span>
                    <span>Meilleur jour: 2.6 L</span>
                </div>
            </div>
        </div>

        <!-- Recommandations -->
        <div class="section-title mt-4">💡 Recommandations</div>
        <div class="card mb-4">
            <div class="alert alert-success">
                <div class="alert-icon">✅</div>
                <div class="alert-content">
                    <strong>Excellente hydratation!</strong>
                    <p>Gardez ce rythme, c'est parfait pour votre santé.</p>
                </div>
            </div>

            <div class="alert alert-warning">
                <div class="alert-icon">⚠️</div>
                <div class="alert-content">
                    <strong>Protéines insuffisantes</strong>
                    <p>Ajoutez du poulet, du poisson ou des œufs à votre prochain repas.</p>
                </div>
            </div>

            <div class="alert alert-info">
                <div class="alert-icon">📌</div>
                <div class="alert-content">
                    <strong>Conseil du jour</strong>
                    <p>Prenez votre petit-déjeuner 1-2h après votre réveil pour booster votre métabolisme.</p>
                </div>
            </div>
        </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 MonRégime - Votre guide de nutrition personnalisé</p>
    </footer>

    <!-- Loader Overlay for AJAX -->
    <div class="loader-overlay" id="loaderOverlay">
        <div class="loader-container">
            <img src="/assets/img/Loading_icon.gif" alt="Chargement..." class="loader-gif">
            <p class="loader-text">Mise à jour en cours...</p>
        </div>
    </div>

    <script>
        window.__dashboardData = {
            weightLabels: ['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7'],
            weightValues: [68, 67.5, 67, 66.5, 66, 65.5, 65],
            caloriesLabels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            caloriesValues: [2150, 2300, 2100, 2250, 2200, 2400, 2100],
            nutritionLabels: ['Glucides', 'Protéines', 'Lipides'],
            nutritionValues: [50, 30, 20],
            nutritionColors: ['#10b981', '#059669', '#d1fae5'],
            hydrationLabels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            hydrationValues: [2.2, 2.5, 2.1, 2.4, 2.6, 2.3, 2.1]
        };
    </script>
    <script src="/assets/js/dashboard.js"></script>
</body>

</html>