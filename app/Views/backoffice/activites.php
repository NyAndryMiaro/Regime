<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <title>Document</title>
</head>

<body>
    <div class="page-shell stack">
        <?php include("navbar/navbar-admin.html");

        if (empty($liste)) { ?>
            <p>Aucune activites presente pour le moment</p>
        <?php } else { ?>

            <section class="card table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Id Activite</th>
                            <th>Nom</th>
                            <th>Objectif</th>
                            <th>Duree en heures</th>
                            <th>Variation du poids</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <<?php foreach ($liste as $activite) { ?>
                            <tr>
                            <td><?= $activite["id_Activite"] ?></td>
                            <td><?= $activite["libelle"] ?></td>
                            <td><?= $activite["lib_objectif"] ?></td>
                            <td><?= $activite["duree"] ?></td>
                            <td><?= $activite["variation_poids"] ?></td>
                            <td><a class="btn btn--ghost" href="/admin/activite-delete/<?= $activite["id_Activite"] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activite ?');">Supprimer</a>
                                <a class="btn btn--ghost" href="/admin/activite-update/<?= $activite["id_Activite"] ?>">Modifier</a>
                            </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        <?php } ?>
        <a href="/admin/activite-insert">Inserer une activite</a>
    </div>
</body>

</html>