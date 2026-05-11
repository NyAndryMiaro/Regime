<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer mon Objectif - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <script src="/assets/js/dashboard.js" defer></script>
</head>
<body>
    <?php include("navbar/navbar-user.html"); ?>

    <?php
    $objectifActuel = $objectifActuel ?? null;
    $objectifs      = $objectifs      ?? [];
    ?>

    <div class="container page-shell">
        <div class="stack">

            <?php if (session()->getFlashdata('success')): ?>
            <div class="success-message">✅ <?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- ── Hero ──────────────────────────────────────────────── -->
            <div class="card card--hero">
                <p class="card--hero__eyebrow">Mon parcours</p>
                <h1 class="card--hero__title">🎯 Choisir un objectif</h1>
                <p class="card--hero__subtitle">Sélectionnez l'objectif qui correspond à votre parcours pour personnaliser votre expérience.</p>
            </div>

            <!-- ── Objectif actuel ────────────────────────────────────── -->
            <?php if ($objectifActuel): ?>
            <div class="objectif-current">
                <h3>Objectif actuel</h3>
                <p><?= (string) ($objectifActuel['libelle'] ?? '') ?></p>
            </div>
            <?php endif; ?>

            <!-- ── Formulaire ─────────────────────────────────────────── -->
            <section class="card card--pad">
                <form action="/objectif" method="post" id="choixObj" class="form-objectif-compact">
                    <div class="objectif-options">
                        <?php foreach ($objectifs as $obj): ?>
                        <?php $isSelected = $objectifActuel && $objectifActuel['id_Objectif'] == $obj['id_Objectif']; ?>
                        <label class="objectif-option-card <?= $isSelected ? 'selected' : '' ?>">
                            <div class="objectif-icon">🎯</div>
                            <h4><?= (string) ($obj['libelle'] ?? '') ?></h4>
                            <p>Sélectionnez cet objectif pour l'enregistrer.</p>
                            <input type="radio" name="objectif"
                                   value="<?= (string) ($obj['id_Objectif'] ?? '') ?>"
                                   <?= $isSelected ? 'checked' : '' ?>>
                        </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Valider mon objectif</button>
                    </div>
                </form>
            </section>

        </div>
    </div>

    <footer class="footer"><p>&copy; 2026 Ré-Gym</p></footer>

    <div class="loader-overlay" id="loaderOverlay">
        <div class="loader-container">
            <img src="/assets/img/Loading_icon.gif" alt="Chargement..." class="loader-gif">
            <p class="loader-text">Mise à jour en cours...</p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.objectif-option-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.objectif-option-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                card.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>
</body>
</html>