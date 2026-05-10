<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="page-shell stack">
        <section class="hero">
            <h1>👋 Bienvenue sur Ré-Gym</h1>
            <p>Connectez-vous pour gérer votre régime alimentaire et suivre vos objectifs fitness.</p>
        </section>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <div class="alert-icon">❌</div>
                <div class="alert-content">
                    <strong>Erreur de connexion</strong>
                    <p><?= esc($error) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <section class="card card--pad" style="max-width: 500px; margin: 0 auto;">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Se connecter</h2>
                    <p class="card-subtitle">Accédez à votre tableau de bord personnel</p>
                </div>
            </div>

            <form action="/login" method="post" class="form">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" value="Alice@gmail.com" placeholder="votre@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" value="aaaaaaaa" placeholder="Votre mot de passe" required>
                </div>

                <button type="submit" class="btn btn--primary btn--full">Se connecter</button>
            </form>

            <div style="text-align: center; padding-top: 1rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-secondary); margin-bottom: 0.75rem;">Pas encore de compte ?</p>
                <a href="/showSignUp1" class="btn btn--secondary btn--full">Créer un nouveau compte</a>
            </div>
        </section>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>