<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="page-shell stack">
        <section class="hero">
            <h1>🚀 Rejoignez Ré-Gym</h1>
            <p>Créez votre compte pour commencer votre parcours fitness et nutrition.</p>
        </section>

        <?php if (isset($errors) && is_array($errors) && count($errors) > 0): ?>
            <div class="alert alert-danger">
                <div class="alert-icon">⚠️</div>
                <div class="alert-content">
                    <strong>Erreurs détectées</strong>
                    <ul style="margin: 0.5rem 0 0 1rem; padding-left: 1rem;">
                        <?php foreach ($errors as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <section class="card card--pad" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Étape 1 - Informations de base</h2>
                    <p class="card-subtitle">Remplissez vos informations personnelles</p>
                </div>
            </div>

            <form id="signup" action="/showSignUp2" method="post" class="form">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="nom">Nom complet</label>
                    <input type="text" id="nom" name="nom" placeholder="Ex: RABARY" required value="<?= isset($old['nom']) ? esc($old['nom']) : '' ?>">
                </div>

                <div class="form-group">
                    <label>Genre</label>
                    <div style="display: flex; gap: 2rem; align-items: center;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: 500;">
                            <input type="radio" id="male" name="genre" value="M" required <?= (isset($old['genre']) && $old['genre'] === 'M') ? 'checked' : '' ?>>
                            <span>Masculin</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: 500;">
                            <input type="radio" id="femelle" name="genre" value="F" <?= (isset($old['genre']) && $old['genre'] === 'F') ? 'checked' : '' ?>>
                            <span>Féminin</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" placeholder="exemple@domaine.com" required value="<?= isset($old['email']) ? esc($old['email']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div style="display: flex; gap: 0.75rem; align-items: flex-end;">
                        <div style="flex: 1;">
                            <input id="mdp" type="password" name="password" placeholder="Créez un mot de passe sécurisé" required style="margin: 0;">
                        </div>
                        <button id="bouton" type="button" onclick="password_action()" class="btn btn--ghost btn--sm" style="margin-bottom: 0;">👁️</button>
                    </div>
                </div>

                <button type="submit" class="btn btn--primary btn--full">Suivant →</button>
            </form>

            <div style="text-align: center; padding-top: 1rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-secondary); margin-bottom: 0.75rem;">Vous avez déjà un compte ?</p>
                <a href="/" class="btn btn--secondary btn--full">Se connecter</a>
            </div>
        </section>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>