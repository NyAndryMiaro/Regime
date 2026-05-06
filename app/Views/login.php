<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <div class="page-shell stack">
        <section class="hero">
            <h1>Connexion</h1>
            <p>Connectez-vous pour acceder a la gestion de la bibliotheque.</p>
        </section>

        <?php if (isset($error)): ?>
            <section class="error-section">
                <p><?= esc($error) ?></p>
            </section>
        <?php endif; ?>

        <section class="card card--pad">
            <form action="/login" method="post" class="form stack">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="admin@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" value="admin" required>
                </div>
                <button type="submit" class="btn btn--primary">Se connecter</button>
            </form>
              
            <a href="/showSignUp">Creer un nouveau compte</a>
        </section>
    </div>
</body>
</html>