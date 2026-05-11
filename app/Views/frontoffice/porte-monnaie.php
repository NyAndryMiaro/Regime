<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porte-monnaie - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body>
    <?php include("navbar/navbar-user.html"); ?>

    <?php $user = $user ?? []; ?>

    <div class="container page-shell">
        <div class="stack">

            <?php if (!empty($error)): ?>
            <div class="error-message">❌ <?= esc($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
            <div class="success-message">✅ <?= esc($success) ?></div>
            <?php endif; ?>

            <!-- ── Hero ──────────────────────────────────────────────── -->
            <div class="card card--hero">
                <p class="card--hero__eyebrow">Mon compte</p>
                <h1 class="card--hero__title">💳 Votre porte-monnaie</h1>
                <p class="card--hero__subtitle">Consultez votre solde et rechargez votre compte en saisissant un code.</p>
            </div>

            <!-- ── Solde + formulaire ─────────────────────────────────── -->
            <section class="card card--pad">
                <div class="card-header">
                    <h2 class="card-title">Solde disponible</h2>
                </div>

                <div class="wallet-balance">
                    <span class="wallet-balance__value"><?= esc((string) ($user['argent'] ?? 0)) ?></span>
                    <span class="wallet-balance__unit">Ar</span>
                </div>

                <p class="wallet-note">Le code saisi sera envoyé à l'administration pour validation.</p>

                <form action="/code" method="post" class="mt-3">
                    <div class="form-group">
                        <label for="codeArgent">Entrer un code</label>
                        <input type="text" id="codeArgent" name="codeArgent"
                               placeholder="Entrez un code" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Envoyer le code</button>
                </form>
            </section>

        </div>
    </div>

    <footer class="footer"><p>&copy; 2026 Ré-Gym</p></footer>
</body>
</html>