<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Régime - Porte-monnaie</title>
    <link rel="stylesheet" href="/assets/css/wallet.css">
    <script src="/assets/js/wallet.js" defer> </script>
</head>

<body class="wallet-page">
    <?php include("navbar/navbar-wallet.html"); ?>

    <main class="wallet-shell">
        <section class="wallet-compact">
            <p class="wallet-label">Porte-monnaie</p>
            <h1> Votre argent : <?= esc($user['argent']) ?> Ar</h1>
            <?php if(!empty($error)){ ?>
                <p><?= esc($error) ?></p>
            <?php } else if(!empty($success)){ ?>
                <p><?= esc($success) ?></p>
            <?php } ?>

            <div class="wallet-actions" >
                <button type="button" class="wallet-link" id="btn-toggle">Entrer un code</button>
                <form action="/code" id="code" method="post">
                    <input type="password" name="codeArgent" placeholder="Entrez votre code">
                    <button type="submit">Valider</button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>