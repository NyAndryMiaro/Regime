<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porte-monnaie - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="/assets/js/wallet.js" defer></script>
</head>

<body>
    <?php include("navbar/navbar-wallet.html"); ?>

    <div class="container page-continue">
        <section class="hero">
            <h1>💳 Votre Porte-monnaie</h1>
            <p>Gérez votre crédit Ré-Gym</p>
        </section>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <div class="alert-icon">❌</div>
                <div class="alert-content">
                    <p><?= esc($error) ?></p>
                </div>
            </div>
        <?php elseif (!empty($success)): ?>
            <div class="alert alert-success">
                <div class="alert-icon">✅</div>
                <div class="alert-content">
                    <p><?= esc($success) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid-2">
            <section class="card card--pad">
                <div class="card-header">
                    <h2 class="card-title">💰 Votre solde</h2>
                </div>
                <div class="wallet-balance">
                    <div class="wallet-balance__value">
                        <?= esc($user['argent']) ?>
                    </div>
                    <p class="wallet-balance__unit">Ar</p>
                </div>
            </section>

            <section class="card card--pad">
                <div class="card-header">
                    <h2 class="card-title">🎟️ Code de recharge</h2>
                </div>
                <form action="/code" method="post" class="form">
                    <div class="form-group">
                        <label for="codeArgent">Entrez votre code</label>
                        <input type="password" id="codeArgent" name="codeArgent" placeholder="Votre code secret" required>
                    </div>
                    <button type="submit" class="btn btn--primary btn--full">✅ Valider le code</button>
                </form>
            </section>
        </div>

    </div>
</body>

</html>