<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <div class="page-shell stack">
        <section class="hero">
            <h1>Inscription</h1>
            <p>Créez un compte pour accéder à la gestion de la bibliothèque.</p>
        </section>


        <?php if (isset(
            $errors) && is_array($errors) && count($errors) > 0): ?>
            <section class="error-section">
                <ul style="color: red;">
                    <?php foreach ($errors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="card card--pad">
            <form id="signup" action="/showSignUp2" method="post" class="form stack">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" placeholder="RABARY" required value="<?= isset(
                        $old['nom']) ? esc($old['nom']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <input type="radio" id="male" name="genre" value="M" required <?= (isset($old['genre']) && $old['genre'] === 'M') ? 'checked' : '' ?>>
                        <label for="male" style="margin-right: 8px;">Male</label>
                        <input type="radio" id="femelle" name="genre" value="F" <?= (isset($old['genre']) && $old['genre'] === 'F') ? 'checked' : '' ?>>
                        <label for="femelle">Femelle</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="example@mg" required value="<?= isset($old['email']) ? esc($old['email']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <input id="mdp" type="password" name="password" placeholder="mot de passe" required>
                        <button id="bouton" type="button" onclick="password_action()">Afficher</button>
                    </div>
                </div>
                <button type="submit" class="btn btn--primary">Suivant</button>
            </form>
            <a href="/">Déjà un compte ? Se connecter</a>
        </section>
    </div>
    <script>
        function password_action() {
            let pass = document.getElementById("mdp");
            let bouton = document.getElementById("bouton");
            let etat = pass.type;
            if (etat === "text") {
                pass.type = "password";
                bouton.textContent = "Afficher";
            } else {
                pass.type = "text";
                bouton.textContent = "Masquer";
            }
        }
    </script>
</body>
</html>