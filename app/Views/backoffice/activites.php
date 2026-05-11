<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Gestion des Activités - Ré-Gym Admin</title>
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html"); ?>

        <section class="hero">
            <h1>🏃 Gestion des Activités</h1>
            <p>Gérez tous les exercices et activités sportives disponibles.</p>
        </section>
    
        <?php if (empty($liste)) { ?>
            <section class="card card--pad" style="text-align: center;">
                <div style="padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                    <p style="color: var(--text-secondary); font-size: 1.1rem;">Aucune activité présente pour le moment</p>
                    <a href="/admin/activite-insert" class="btn btn--primary" style="margin-top: 1.5rem;">➕ Ajouter une activité</a>
                </div>
            </section>
        <?php } else { ?>
            <section class="toolbar">
                <a href="/admin/activite-insert" class="btn btn--primary">➕ Ajouter une activité</a>
            </section>

            <section class="card table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Objectif</th>
                            <th>Durée</th>
                            <th>Variation Poids</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($liste as $activite) { ?>
                            <tr>
                                <td><strong><?= $activite["id_Activite"] ?></strong></td>
                                <td><?= $activite["libelle"] ?></td>
                                <td><?= $activite["lib_objectif"] ?></td>
                                <td><?= $activite["duree"] ?>h</td>
                                <td><strong><?= $activite["variation_poids"] ?> kg</strong></td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn--ghost btn--sm" href="/admin/activite-update/<?= $activite["id_Activite"] ?>">✏️ Modifier</a>
                                        <a class="btn btn--danger btn--sm" href="/admin/activite-delete/<?= $activite["id_Activite"] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?');">🗑️ Supprimer</a>
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