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
            <p>Aucune regimes presente pour le moment</p>
        <?php } else { ?>

            <section class="card table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Id Regime</th>
                            <th>Nom</th>
                            <th>Objectif</th>
                            <th>Duree en heures</th>
                            <th>Variation du poids</th>
                            <th>Prix</th>
                            <th>Viande</th>
                            <th>Poisson</th>
                            <th>Legume</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($liste as $regime) { ?>
                            <tr>
                            <td><?= $regime["id_Regime"] ?></td>
                            <td><?= $regime["libelle"] ?></td>
                            <td><?= $regime["lib_objectif"] ?></td>
                            <td><?= $regime["duree"] ?></td>
                            <td><?= $regime["variation_poids"] ?></td>
                            <td><?= $regime["prix_unitaire"] ?></td>
                            <td><?= $regime["pourcentage_viande"] ?> %</td>
                            <td><?= $regime["pourcentage_poisson"] ?> %</td>
                            <td><?= $regime["pourcentage_legume"] ?> %</td>
                            <td><a class="btn btn--ghost" href="/admin/regime-delete/<?= $regime["id_Regime"] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce régime ?');">Supprimer</a>
                                <a class="btn btn--ghost" href="/admin/regime-update/<?= $regime["id_Regime"] ?>">Modifier</a>
                            </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        <?php } ?>
        <a href="/admin/regime-insert">Insérer un régime</a>
    </div>
</body>

</html>