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
    <nav class="navbar">
        <div class="navbar-brand">💚 MonRégime</div>
        <div class="navbar-menu">
            <a href="#accueil">Accueil</a>
            <a href="#repas">Mes Repas</a>
            <a href="#regimes">Régimes</a>
            <span class="user-welcome">Bienvenue, <?= session()->get('user')['nom'] ?? 'Utilisateur' ?></span>
            <form action="/logout" method="post" style="display: inline;">
                <button type="submit" class="btn btn-logout btn-sm">Déconnexion</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Header Section -->
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
                <canvas id="weightChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>🥗 Répartition Nutritionnelle</h3>
                <canvas id="nutritionChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>📉 Calories Cette Semaine</h3>
                <canvas id="caloriesChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>💧 Hydratation</h3>
                <canvas id="hydrationChart"></canvas>
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

    <script src="/assets/js/dashboard.js"></script>
</body>
</html>