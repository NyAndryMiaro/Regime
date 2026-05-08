<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-brand">👑 MonRégime - Admin</div>
        <div class="navbar-menu">
            <a href="#dashboard">Tableau de Bord</a>
            <a href="#utilisateurs">Utilisateurs</a>
            <a href="#statistiques">Statistiques</a>
            <span class="user-welcome">Admin: <?= session()->get('user')['nom'] ?? 'Admin' ?></span>
            <form action="/logout" method="post" style="display: inline;">
                <button type="submit" class="btn btn-logout btn-sm">Déconnexion</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Header Section -->
        <div class="header-section" id="dashboard">
            <h1>🛡️ Tableau de Bord Administrateur</h1>
            <p>Gérez les utilisateurs et consultez les statistiques du système</p>
            <div class="user-info">
                <p><strong>Vous êtes connecté en tant qu'administrateur</strong></p>
                <p>Vous avez accès à la gestion complète du système</p>
            </div>
        </div>

        <!-- Statistiques Rapides -->
        <div class="section-title">📊 Statistiques du Système</div>
        <div class="grid">
            <div class="card stat-card">
                <div class="stat-label">Total Utilisateurs</div>
                <div class="stat-value"><?= count($users) ?? 5 ?></div>
                <div class="stat-unit">utilisateurs actifs</div>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Utilisateurs Hommes</div>
                <div class="stat-value"><?= count(array_filter($users ?? [], fn($u) => $u['genre'] == 'M')) ?></div>
                <div class="stat-unit">M</div>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Utilisateurs Femmes</div>
                <div class="stat-value"><?= count(array_filter($users ?? [], fn($u) => $u['genre'] == 'F')) ?></div>
                <div class="stat-unit">F</div>
            </div>

            <div class="card stat-card">
                <div class="stat-label">Poids Moyen</div>
                <div class="stat-value">
                    <?php 
                    $poids = array_filter($users ?? [], fn($u) => $u['poids'] ?? 0);
                    echo $poids ? number_format(array_sum(array_column($poids, 'poids')) / count($poids), 1) : '0';
                    ?>
                </div>
                <div class="stat-unit">kg</div>
            </div>
        </div>

        <!-- Graphiques d'Administration -->
        <div class="section-title mt-4">📈 Analyse des Données</div>
        <div class="charts-container">
            <div class="chart-card">
                <h3>👥 Distribution par Genre</h3>
                <canvas id="genderChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>⚖️ Distribution du Poids</h3>
                <canvas id="weightDistributionChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>📏 Distribution de la Taille</h3>
                <canvas id="heightDistributionChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>📊 IMC des Utilisateurs</h3>
                <canvas id="imcChart"></canvas>
            </div>
        </div>

        <!-- Gestion des Utilisateurs -->
        <div class="section-title mt-4" id="utilisateurs">👥 Gestion des Utilisateurs</div>
        <div class="card mb-4">
            <div class="flex-between mb-2">
                <h3>Liste de tous les utilisateurs</h3>
                <button class="btn btn-primary">+ Ajouter un utilisateur</button>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Genre</th>
                            <th>Taille (cm)</th>
                            <th>Poids (kg)</th>
                            <th>IMC</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach($users as $user): 
                                $imc = $user['poids'] / (($user['taille'] / 100) ** 2);
                                $statut = $user['estAdmin'] ? 'Admin' : 'Utilisateur';
                                $couleur = $user['estAdmin'] ? 'style="color: #f59e0b;"' : '';
                            ?>
                            <tr>
                                <td><?= $user['id_Utilisateur'] ?></td>
                                <td><strong><?= esc($user['nom']) ?></strong></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= $user['genre'] == 'M' ? '👨 Homme' : '👩 Femme' ?></td>
                                <td><?= $user['taille'] ?></td>
                                <td><?= $user['poids'] ?></td>
                                <td><?= number_format($imc, 1) ?></td>
                                <td><span <?= $couleur ?>><?= $statut ?></span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm">✏️</button>
                                    <button class="btn btn-logout btn-sm">🗑️</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center" style="padding: 2rem;">Aucun utilisateur trouvé</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistiques Détaillées -->
        <div class="section-title mt-4" id="statistiques">📉 Statistiques Détaillées</div>
        <div class="grid-2">
            <div class="card">
                <h3>📋 Résumé</h3>
                <div style="margin-top: 1.5rem;">
                    <p class="mb-2"><strong>Total d'utilisateurs:</strong> <span class="text-green"><?= count($users) ?? 0 ?></span></p>
                    <p class="mb-2"><strong>Administrateurs:</strong> <span class="text-green"><?= count(array_filter($users ?? [], fn($u) => $u['estAdmin'])) ?></span></p>
                    <p class="mb-2"><strong>Utilisateurs normaux:</strong> <span class="text-green"><?= count(array_filter($users ?? [], fn($u) => !$u['estAdmin'])) ?></span></p>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" style="width: 100%;">📥 Exporter les données</button>
                </div>
            </div>

            <div class="card">
                <h3>⚙️ Paramètres</h3>
                <div style="margin-top: 1.5rem;">
                    <div class="alert alert-info">
                        <div class="alert-icon">ℹ️</div>
                        <div class="alert-content">
                            <strong>Maintenance du système</strong>
                            <p>Tous les systèmes fonctionnent correctement.</p>
                        </div>
                    </div>
                    <button class="btn btn-primary" style="width: 100%; margin-top: 1rem;">🔧 Paramètres système</button>
                </div>
            </div>
        </div>

        <!-- Alertes Administrateur -->
        <div class="section-title mt-4">🚨 Alertes et Notifications</div>
        <div class="card">
            <div class="alert alert-success">
                <div class="alert-icon">✅</div>
                <div class="alert-content">
                    <strong>Système opérationnel</strong>
                    <p>Tous les services fonctionnent normalement.</p>
                </div>
            </div>

            <div class="alert alert-info">
                <div class="alert-icon">ℹ️</div>
                <div class="alert-content">
                    <strong>Mise à jour disponible</strong>
                    <p>Une nouvelle version du système est disponible. <?= count($users) > 10 ? 'Veuillez envisager une mise à jour.' : '' ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 MonRégime - Panneau d'administration</p>
    </footer>

    <script>window.__users = <?= json_encode($users ?? []) ?>;</script>
    <script src="/assets/js/accueilAdmin.js"></script>
</body>
</html>
