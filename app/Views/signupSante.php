<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étape 2 - Informations Santé - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="page-shell stack">
        <section class="hero">
            <h1>📊 Étape 2 - Vos Informations Santé</h1>
            <p>Entrez vos données physiques pour un régime adapté.</p>
        </section>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <div class="alert-icon">❌</div>
                <div class="alert-content">
                    <strong>Erreur</strong>
                    <p><?= esc($error) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <section class="card card--pad" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Finalisez votre inscription</h2>
                    <p class="card-subtitle">Renseignez votre taille et votre poids pour un suivi optimal</p>
                </div>
            </div>

            <form action="/register" method="post" class="form">
                <?= csrf_field() ?>
                <input type="hidden" name="nom" value="<?= esc($infos['nom']) ?>">
                <input type="hidden" name="genre" value="<?= esc($infos['genre']) ?>">
                <input type="hidden" name="email" value="<?= esc($infos['email']) ?>">
                <input type="hidden" name="password" value="<?= esc($infos['password']) ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="taille">📏 Taille (cm)</label>
                        <input type="number" id="taille" name="taille" value="165" min="100" max="250" placeholder="Ex: 165" required>
                    </div>
                    <div class="form-group">
                        <label for="poids">⚖️ Poids (kg)</label>
                        <input type="number" id="poids" name="poids" value="70" min="40" max="160" step="0.1" placeholder="Ex: 70" required>
                    </div>
                </div>

                <div style="padding: 1rem; background: rgba(15, 139, 102, 0.08); border-radius: var(--radius-md); margin: 1.5rem 0;">
                    <p style="margin: 0; color: var(--text-secondary); font-size: 0.95rem;">
                        💡 <strong>Conseil:</strong> Avec ces informations, nous calculerons votre IMC (Indice de Masse Corporelle) pour vous proposer un régime personnalisé.
                    </p>
                </div>

                <button type="submit" class="btn btn--primary btn--full">✅ Compléter l'inscription</button>
            </form>

            <div style="text-align: center; padding-top: 1rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-secondary); margin-bottom: 0.75rem; font-size: 0.9rem;">Besoin d'aide ?</p>
                <a href="/" class="btn btn--ghost btn--full">← Retour</a>
            </div>
        </section>
    </div>
</body>
</html>