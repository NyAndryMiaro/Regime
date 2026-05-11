<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>

        <?php
        $users = $users ?? [];
        $codesEnAttente = $codesEnAttente ?? [];
        ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <div class="alert-icon">✅</div>
                <div class="alert-content">
                    <strong>Opération réussie</strong>
                    <p><?= session()->getFlashdata('success') ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <div class="alert-icon">❌</div>
                <div class="alert-content">
                    <strong>Erreur détectée</strong>
                    <p><?= session()->getFlashdata('error') ?></p>
                </div>
            </div>
        <?php endif; ?>

        <header class="hero">
            <h1>🛡️ Tableau de bord administrateur</h1>
            <p>Vue globale pour gérer les utilisateurs et traiter les codes de recharge en attente.</p>
        </header>

        <h2 class="section-title mt-4">📊 Statistiques du système</h2>
        <div class="user-metrics">
            <div class="metric-item">
                <div class="metric-label">Total utilisateurs</div>
                <div class="metric-value">
                    <?= count($users) ?> <span class="metric-unit">comptes</span>
                </div>
            </div>

            <div class="metric-item">
                <div class="metric-label">Codes en attente</div>
                <div class="metric-value" style="color: #b7791f;">
                    <?= count($codesEnAttente) ?> <span class="metric-unit">à valider</span>
                </div>
            </div>
        </div>

        <h2 class="section-title mt-4" id="codes">🎟️ Demandes de codes</h2>
        <section class="card card--pad">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Montant</th>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($codesEnAttente)): ?>
                            <?php foreach ($codesEnAttente as $code): ?>
                                <tr>
                                    <td><strong><?= esc($code['code'] ?? '') ?></strong></td>
                                    <td><strong><?= number_format($code['montant'] ?? 0, 0, ',', ' ') ?> Ar</strong></td>
                                    <td><?= esc($code['nom_utilisateur'] ?? '') ?></td>
                                    <td><?= esc($code['email_utilisateur'] ?? '') ?></td>
                                    <td><span class="badge-role badge-role--admin">En attente</span></td>
                                    <td>
                                        <div class="actions">
                                            <form action="/admin/code-accept/<?= $code['idCode'] ?>" method="post" style="display:inline;">
                                                <button type="submit" class="btn btn--primary btn--sm">✅ Accepter</button>
                                            </form>
                                            <form action="/admin/code-reject/<?= $code['idCode'] ?>" method="post" style="display:inline;">
                                                <button type="submit" class="btn btn-logout btn--sm">❌ Refuser</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center table-empty">Aucune demande de code en attente</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <h2 class="section-title mt-4" id="utilisateurs">👥 Utilisateurs enregistrés</h2>
        <section class="card card--pad">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Genre</th>
                            <th>Taille</th>
                            <th>Poids</th>
                            <th>IMC</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user):
                                $tailleM = ($user['taille'] ?? 170) / 100;
                                $poids = $user['poids'] ?? 0;
                                $imc = $tailleM > 0 ? ($poids / ($tailleM ** 2)) : 0;
                                $isAdmin = !empty($user['estAdmin']) && $user['estAdmin'];
                                $statut = $isAdmin ? 'Admin' : 'Membre';
                                $couleurBadge = $isAdmin ? 'badge-role badge-role--admin' : 'badge-role';
                            ?>
                                <tr>
                                    <td><?= esc($user['id_Utilisateur'] ?? '') ?></td>
                                    <td><strong><?= esc($user['nom'] ?? '') ?></strong></td>
                                    <td><?= esc($user['email'] ?? '') ?></td>
                                    <td><?= ($user['genre'] ?? 'M') == 'M' ? '👨 Homme' : '👩 Femme' ?></td>
                                    <td><?= esc($user['taille'] ?? '') ?> cm</td>
                                    <td><?= esc($user['poids'] ?? '') ?> kg</td>
                                    <td><strong><?= number_format($imc, 1) ?></strong></td>
                                    <td><span class="<?= $couleurBadge ?>"><?= $statut ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center table-empty">Aucun utilisateur trouvé dans la base</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="footer footer--spaced">
            <p>&copy; 2026 Ré-Gym - Espace Admin</p>
        </footer>
    </div>
</body>

</html>