<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regime - Inscription</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <div class="page-shell stack">
        <section class="hero">
            <h1>Inscription</h1>
            <p>Entrez vos données pour savoir votre régime</p>
        </section>

        <?php if (isset($error)): ?>
            <section class="error-section">
                <p><?= esc($error) ?></p>
            </section>
        <?php endif; ?>

        <section class="card card--pad">
            <form action="/register" method="post" class="form stack">
                <?= csrf_field() ?>
                <input type="hidden" name="nom" value="<?= esc($infos['nom']) ?>">
                <input type="hidden" name="genre" value="<?= esc($infos['genre']) ?>">
                <input type="hidden" name="email" value="<?= esc($infos['email']) ?>">
                <input type="hidden" name="password" value="<?= esc($infos['password']) ?>">
                
                <div class="form-group">
                    <label for="taille"> Taille (cm) </label>
                    <input type="number" id="taille" name="taille" value="100" min="100" max="250" required>
                </div>
                <div class="form-group">
                    <label for="poids"> Poids (kg) </label>
                    <input type="number" id="poids" name="poids" value="60" min="40" max="160" required>
                </div>
                <button type="submit" class="btn btn--primary">Validez les données</button>
            </form>
              
        </section>
    </div>
</body>
</html>