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
    <?php include("navbar-user.html"); ?>

    <div class="container">
        <!-- Header Section -->
        <?php if (empty($objectif)) { ?>
            <div class="objectif-section" id="Objctif">
                <h2>Commencez par choisir un objectif</h2>

                <form action="/objectif" method="post" id="choixObj">
                    <?php if (!empty($objectifs)) {
                        foreach ($objectifs as $obj) { ?>
                            <p> <?= $obj["libelle"] ?> <input type="radio" name="objectif" value="<?= $obj["id_Objectif"] ?>"></p>
                    <?php }
                    } ?>
                    <button type="submit"> Valider </button>
                </form>

            </div>

        <?php } else{ ?>
            <div class="objectif-section">
                <p> Votre objectif : <?= esc($objectif['libelle']) ?> </p>
            </div>
        <?php } ?>

        <div class="header-section" id="accueil">
            <h1>👋 Bienvenue sur votre Tableau de Bord</h1>
            <p>Suivez votre progression vers vos objectifs nutritionnels</p>
            <div class="user-info">
                <p><strong>Vos informations:</strong></p>
                <p>Taille: <?= $user['taille'] ?? '165' ?> cm | Poids: <?= $user['poids'] ?? '65' ?> kg</p>
                <p>IMC: <?= number_format(($user['poids'] ?? 65) / (($user['taille'] ?? 165) ** 2 / 10000), 1) ?></p>
            </div>
        </div>

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
                <p class="text-gray" style="font-size: 0.85rem;">1430 / 2200 kcal aujourd'hui</p>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Protéines</div>
                <div class="stat-value">65g</div>
                <div class="stat-unit">sur 110g</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 59%"></div>
                </div>
                <button class="btn btn-primary btn-sm" style="width: 100%; margin-top: 1rem;">+ Ajouter</button>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Hydratation</div>
                <div class="stat-value">2.1L</div>
                <div class="stat-unit">sur 2.5L</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 84%"></div>
                </div>
                <button class="btn btn-primary btn-sm" style="width: 100%; margin-top: 1rem;">💧 Boire</button>
            </div>
        </div>

        <!-- Régimes Recommandés -->
        <div class="section-title" id="regimes">🎯 Régimes Recommandés</div>
        <div class="card">
            <div class="regimes-grid">
                <div class="regime-card">
                    <h4>🌊 Méditerranéen</h4>
                    <p>Fruits, légumes et huile d'olive pour votre santé</p>
                    <div class="regime-calories">~1800 kcal/jour</div>
                    <button class="btn btn-primary btn-sm" style="width: 100%; background: rgba(255,255,255,0.2);">Découvrir</button>
                </div>

                <div class="regime-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <h4>⚖️ Équilibré</h4>
                    <p>Tous les nutriments essentiels pour votre santé</p>
                    <div class="regime-calories">~2200 kcal/jour</div>
                    <button class="btn btn-primary btn-sm" style="width: 100%; background: rgba(255,255,255,0.2);">Découvrir</button>
                </div>

                <div class="regime-card" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                    <h4>💪 Protéiné</h4>
                    <p>Pour le renforcement musculaire et perte de poids</p>
                    <div class="regime-calories">~1900 kcal/jour</div>
                    <button class="btn btn-primary btn-sm" style="width: 100%; background: rgba(255,255,255,0.2);">Découvrir</button>
                </div>

                <div class="regime-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    <h4>🥬 Végétarien</h4>
                    <p>Fruits, légumes et produits laitiers</p>
                    <div class="regime-calories">~1950 kcal/jour</div>
                    <button class="btn btn-primary btn-sm" style="width: 100%; background: rgba(255,255,255,0.2);">Découvrir</button>
                </div>
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

        <!-- Tableau des Repas -->
        <div class="section-title" id="repas">🍽️ Vos Repas d'Aujourd'hui</div>
        <div class="table-container mb-4">
            <table>
                <thead>
                    <tr>
                        <th>⏰ Heure</th>
                        <th>🍴 Repas</th>
                        <th>🔥 Calories</th>
                        <th>💪 Protéines</th>
                        <th>🌾 Glucides</th>
                        <th>🥑 Lipides</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>08:00</td>
                        <td>Petit-déjeuner: Œufs + Pain complet</td>
                        <td>320 kcal</td>
                        <td>15g</td>
                        <td>35g</td>
                        <td>12g</td>
                    </tr>
                    <tr>
                        <td>10:30</td>
                        <td>Snack: Pomme + Amandes</td>
                        <td>180 kcal</td>
                        <td>6g</td>
                        <td>22g</td>
                        <td>8g</td>
                    </tr>
                    <tr>
                        <td>12:30</td>
                        <td>Déjeuner: Poulet grillé + Riz</td>
                        <td>550 kcal</td>
                        <td>35g</td>
                        <td>65g</td>
                        <td>8g</td>
                    </tr>
                    <tr>
                        <td>15:00</td>
                        <td>Goûter: Yaourt grec</td>
                        <td>150 kcal</td>
                        <td>20g</td>
                        <td>8g</td>
                        <td>4g</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 MonRégime - Votre guide de nutrition personnalisé</p>
    </footer>

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