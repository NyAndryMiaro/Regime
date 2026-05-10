<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porte-monnaie - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/style.css">
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
                <div style="text-align: center; padding: 2rem 0;">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">
                        <?= esc($user['argent']) ?>
                    </div>
                    <p style="color: var(--text-secondary); font-size: 1.05rem;">Ar</p>
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

        <footer class="footer" style="margin-top: 3rem;">
            <p>Besoin d'aide ? <a href="/support" style="color: var(--primary); text-decoration: none; font-weight: 600;">Contactez-nous</a></p>
        </footer>
    </div>
</body>

</html>