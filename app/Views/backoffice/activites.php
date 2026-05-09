<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include("navbar-admin.html");

    if (empty($liste)) { ?>
        <p>Aucune activites presente pour le moment</p>
    <?php } else { ?>

        <table border="1">
            <tr>
                <th>Id Activite</th>
                <th>Nom</th>
                <th>Objectif</th>
                <th>Duree</th>
                <th>Variation du poids</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($liste as $activite) { ?>
                <tr>
                    <td><?= $activite["id_Activite"] ?></td>
                    <td><?= $activite["libelle"] ?></td>
                    <td><?= $activite["lib_objectif"] ?></td>
                    <td><?= $activite["duree"] ?></td>
                    <td><?= $activite["variation_poids"] ?></td>
                    <td><a href="/admin/activite-delete/<?= $activite["id_Activite"]?>">Supprimer</a> |
                        <a href="/admin/activite-update/<?= $activite["id_Activite"]?>">Modifier</a></td>
                    
                </tr>
            <?php } ?>
        </table>
        
        <a href="/admin/activite-insert">Inserer une activite</a>
    <?php } ?>

</body>

</html>