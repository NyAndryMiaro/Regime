<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
        $user = session()->get('user'); 
        $id = $user['id'];

        if ($user != null) {
            var_dump($user['id']);
        }
    ?>

    <h1>Informations</h1>

    <p>Obtenez un remise de <?= $parametre["remise"] * 100 ?> % sur tout vos achats </p>
    <p>Payable une seule fois et illimite a vis</p>
    <p>Prix : <?= $parametre["prix"] ?></p>

    <?php if ($user['estGold']) { ?>
        <p>Vous etre deja un utilisateur gold</p>
    <?php } else { ?>
        <a href="/devenir-gold/<?= $id ?>">Devenir Gold</a>
    <?php }  ?>

</body>

</html>