<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Gestion des Régimes - Ré-Gym Admin</title>
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>

        <section class="hero">
            <h1>🍽️ Gestion des Régimes</h1>
            <p>Gérez tous les régimes alimentaires disponibles.</p>
        </section>

        <?php if (empty($liste)) { ?>
            <section class="card card--pad" style="text-align: center;">
                <div style="padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                    <p style="color: var(--text-secondary); font-size: 1.1rem;">Aucun régime présent pour le moment</p>
                    <a href="/admin/regime-insert" class="btn btn--primary" style="margin-top: 1.5rem;">➕ Ajouter un régime</a>
                </div>
            </section>
        <?php } else { ?>
            <section class="toolbar">
                <a href="/admin/regime-insert" class="btn btn--primary">➕ Ajouter un régime</a>
            </section>

            <section class="card table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Objectif</th>
                            <th>Durée</th>
                            <th>Poids</th>
                            <th>Prix</th>
                            <th>Composition</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($liste as $regime) { ?>
                            <tr>
                                <td><strong><?= $regime["id_Regime"] ?></strong></td>
                                <td><?= $regime["libelle"] ?></td>
                                <td><?= $regime["lib_objectif"] ?></td>
                                <td><?= $regime["duree"] ?>h</td>
                                <td><strong><?= $regime["variation_poids"] ?> kg</strong></td>
                                <td><strong><?= $regime["prix_unitaire"] ?> €</strong></td>
                                <td>
                                    <div style="font-size: 0.9rem;">
                                        🥩 <?= $regime["pourcentage_viande"] ?>% | 
                                        🐟 <?= $regime["pourcentage_poisson"] ?>% | 
                                        🥬 <?= $regime["pourcentage_legume"] ?>%
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn--ghost btn--sm" href="/admin/regime-update/<?= $regime["id_Regime"] ?>">✏️ Modifier</a>
                                        <a class="btn btn--danger btn--sm" href="/admin/regime-delete/<?= $regime["id_Regime"] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce régime ?');">🗑️ Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        <?php } ?>
    </div>
</body>

</html>