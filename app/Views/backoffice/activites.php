<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Activités - Ré-Gym Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>

        <section class="activites-header">
            <h1>🏃 Gestion des Activités</h1>
            <p>Visualisez, configurez, modifiez ou supprimez les exercices physiques disponibles sur la plateforme.</p>
        </section>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <div class="alert-icon">✅</div>
                <div class="alert-content">
                    <strong>Succès</strong>
                    <p><?= session()->getFlashdata('success') ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($liste)): ?>
            <section class="card card--pad empty-panel">
                <div class="empty-content">
                    <div class="empty-icon">📭</div>
                    <p class="empty-text">Aucune activité n'est enregistrée pour le moment.</p>
                    <a href="/admin/activite-insert" class="btn btn--primary mt-2">➕ Ajouter une activité</a>
                </div>
            </section>
        <?php else: ?>
            
            <section class="toolbar">
                <span class="text-gray small"><strong><?= count($liste) ?></strong> activité(s) trouvée(s)</span>
                <a href="/admin/activite-insert" class="btn btn--primary">➕ Ajouter une activité</a>
            </section>

            <section class="card card--pad">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom de l'Activité</th>
                                <th>Objectif Ciblé</th>
                                <th>Durée Standard</th>
                                <th>Variation Poids</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($liste as $activite): ?>
                                <tr>
                                    <td><?= esc($activite['id_Activite'] ?? '') ?></td>
                                    <td><strong><?= esc($activite['libelle'] ?? '') ?></strong></td>
                                    <td>
                                        <span class="badge-role">
                                            🎯 <?= esc($activite['objectif_libelle'] ?? 'Tous objectifs') ?>
                                        </span>
                                    </td>
                                    <td><strong><?= esc($activite['duree'] ?? '0') ?></strong> h</td>
                                    <td>
                                        <?php 
                                            $val = $activite['variation_poids'] ?? 0;
                                            $class = $val >= 0 ? 'value-positive' : 'value-negative';
                                            $prefix = $val >= 0 ? '+' : '';
                                        ?>
                                        <span class="<?= $class ?>" style="font-weight: 800;">
                                            <?= $prefix . esc($val) ?> kg
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="/admin/activite-update/<?= $activite['id_Activite'] ?>" class="btn btn--secondary btn--sm">
                                                ✏️ Modifier
                                            </a>
                                            <a href="/admin/activite-delete/<?= $activite['id_Activite'] ?>" class="btn btn-logout btn--sm" onclick="return confirm('Voulez-vous vraiment supprimer cette activité ?');">
                                                🗑️ Supprimer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php endif; ?>

        <footer class="footer footer--spaced">
            <p>&copy; 2026 Ré-Gym - Gestion des Activités</p>
        </footer>
    </div>
</body>

</html>