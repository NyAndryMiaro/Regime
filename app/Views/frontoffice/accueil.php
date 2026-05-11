<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <script src="/assets/js/dashboard.js" defer></script>
</head>

<body>
    <?php include("navbar/navbar-user.html"); ?>

    <?php
    $user      = $user      ?? [];
    $objectifs = $objectifs ?? [];
    $objectif  = $objectif  ?? null;
    $regimes   = $regimes   ?? [];
    $activites = $activites ?? [];
    ?>

    <div class="container page-shell">
        <div class="stack">

            <!-- ── Hero ──────────────────────────────────────────────── -->
            <div class="card card--hero">
                <p class="card--hero__eyebrow">Tableau de bord</p>
                <h1 class="card--hero__title">
                    Bonjour, <span class="card--hero__name"><?= esc($user['nom'] ?? 'Champion') ?></span> 👋<br>
                    Bienvenue sur Ré-Gym
                </h1>
                <p class="card--hero__subtitle">
                    Votre parcours vers un mode de vie plus sain continue aujourd'hui.
                    Chaque effort compte — continuez sur votre lancée.
                </p>
                <div class="card--hero__pills">
                    <span class="card--hero__pill">🥗 Régimes disponibles</span>
                    <span class="card--hero__pill">🏃 Activités à explorer</span>
                    <span class="card--hero__pill">🎯 Objectif en cours</span>
                </div>
            </div>

            <!-- ── Informations utilisateur ──────────────────────────── -->
            <section class="card card--pad">
                <div class="card-header">
                    <h2 class="card-title">📋 Vos informations</h2>
                </div>
                <div class="user-stats">
                    <div class="stat">
                        <div class="stat-label">Taille</div>
                        <div class="stat-value"><?= (string) ($user['taille'] ?? '165') ?> <small>cm</small></div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">Poids</div>
                        <div class="stat-value"><?= (string) ($user['poids'] ?? '65') ?> <small>kg</small></div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">IMC</div>
                        <div class="stat-value"><?= number_format(($user['poids'] ?? 65) / (($user['taille'] ?? 165) ** 2 / 10000), 1) ?></div>
                    </div>
                </div>
            </section>

            <!-- ── Objectif ───────────────────────────────────────────── -->
            <?php if (empty($objectif)): ?>
            <section class="card card--pad">
                <div class="card-header">
                    <h2 class="card-title">🎯 Choisir un objectif</h2>
                </div>
                <p class="text-muted">Sélectionnez votre objectif pour personnaliser votre parcours.</p>
                <form action="/objectif" method="post" id="choixObj" class="form-objectif-compact">
                    <div class="objectif-list">
                        <?php foreach ($objectifs as $obj): ?>
                        <label class="objectif-item">
                            <input type="radio" name="objectif" value="<?= (string) ($obj['id_Objectif'] ?? '') ?>">
                            <span class="objectif-label"><?= (string) ($obj['libelle'] ?? '') ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider mon objectif</button>
                </form>
            </section>
            <?php else: ?>
            <section class="card card--pad">
                <div class="card-header">
                    <h2 class="card-title">🎯 Votre objectif</h2>
                </div>
                <p class="objectif-current-text"><?= (string) ($objectif['libelle'] ?? '') ?></p>
            </section>
            <?php endif; ?>

            <!-- ── Régimes ────────────────────────────────────────────── -->
            <?php if (!empty($regimes)): ?>
            <section class="card card--pad">
                <div class="card-header card-header--tight">
                    <h2 class="card-title">🥗 Régimes disponibles</h2>
                    <a class="btn btn-primary btn-sm" href="/regimes">Voir les régimes</a>
                </div>
                <div class="regimes-grid">
                    <?php foreach (array_slice($regimes, 0, 3) as $regime): ?>
                    <?php $variation = (float) ($regime['variation_poids'] ?? 0); ?>
                    <div class="regime-card-wrapper">
                        <div class="regime-card">
                            <div class="regime-card-header">
                                <div class="regime-title"><?= esc((string) ($regime['libelle'] ?? $regime['nom'] ?? 'Régime')) ?></div>
                                <span class="regime-badge <?= $variation >= 0 ? 'positive' : 'negative' ?>">
                                    <?= $variation >= 0 ? '+' : '' ?><?= esc((string) $variation) ?> kg
                                </span>
                            </div>
                            <div class="regime-info">
                                <div class="detail-item">
                                    <div class="detail-label">Durée</div>
                                    <div class="detail-value"><?= esc((string) ($regime['duree'] ?? 0)) ?> jours</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Prix</div>
                                    <div class="detail-value"><?= esc((string) ($regime['prix_unitaire'] ?? 0)) ?> Ar</div>
                                </div>
                            </div>
                            <div class="regime-composition">
                                <span class="composition-item">
                                    <span class="composition-box viande"></span>
                                    <?= esc((string) ($regime['pourcentage_viande'] ?? 0)) ?>% viande
                                </span>
                                <span class="composition-item">
                                    <span class="composition-box legume"></span>
                                    <?= esc((string) ($regime['pourcentage_legume'] ?? 0)) ?>% légumes
                                </span>
                                <span class="composition-item">
                                    <span class="composition-box poisson"></span>
                                    <?= esc((string) ($regime['pourcentage_poisson'] ?? 0)) ?>% poisson
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- ── Activités ──────────────────────────────────────────── -->
            <?php if (!empty($activites)): ?>
            <section class="card card--pad">
                <div class="card-header card-header--tight">
                    <h2 class="card-title">🏃 Activités disponibles</h2>
                    <button type="button" class="btn btn-primary btn-sm"
                            id="toggleActivitiesButton"
                            aria-controls="extraActivities"
                            aria-expanded="false">Voir plus</button>
                </div>
                <div class="activites-grid">
                    <?php foreach (array_slice($activites, 0, 3) as $activite): ?>
                    <?php $variation = (float) ($activite['variation_poids'] ?? 0); ?>
                    <div class="activite-card-wrapper">
                        <div class="activite-card">
                            <div class="activite-card-header">
                                <div class="activite-title"><?= esc((string) ($activite['libelle'] ?? $activite['nom'] ?? 'Activité')) ?></div>
                                <span class="activite-badge <?= $variation >= 0 ? 'positive' : 'negative' ?>">
                                    <?= $variation >= 0 ? '+' : '' ?><?= esc((string) $variation) ?> kg
                                </span>
                            </div>
                            <div class="activite-details">
                                <div class="detail-item">
                                    <div class="detail-label">Durée</div>
                                    <div class="detail-value"><?= esc((string) ($activite['duree'] ?? 0)) ?> min</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Statut</div>
                                    <div class="detail-value">Disponible</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($activites) > 3): ?>
                <div class="extra-activities is-hidden" id="extraActivities">
                    <p class="section-subtitle">Autres activités</p>
                    <div class="activites-grid">
                        <?php foreach (array_slice($activites, 3) as $activite): ?>
                        <?php $variation = (float) ($activite['variation_poids'] ?? 0); ?>
                        <div class="activite-card-wrapper">
                            <div class="activite-card">
                                <div class="activite-card-header">
                                    <div class="activite-title"><?= esc((string) ($activite['libelle'] ?? $activite['nom'] ?? 'Activité')) ?></div>
                                    <span class="activite-badge <?= $variation >= 0 ? 'positive' : 'negative' ?>">
                                        <?= $variation >= 0 ? '+' : '' ?><?= esc((string) $variation) ?> kg
                                    </span>
                                </div>
                                <div class="activite-details">
                                    <div class="detail-item">
                                        <div class="detail-label">Durée</div>
                                        <div class="detail-value"><?= esc((string) ($activite['duree'] ?? 0)) ?> min</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Statut</div>
                                        <div class="detail-value">Disponible</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </section>
            <?php endif; ?>

        </div><!-- /.stack -->
    </div><!-- /.container -->

    <footer class="footer">
        <p>&copy; 2026 Ré-Gym</p>
    </footer>

    <div class="loader-overlay" id="loaderOverlay">
        <div class="loader-container">
            <img src="/assets/img/Loading_icon.gif" alt="Chargement..." class="loader-gif">
            <p class="loader-text">Mise à jour en cours...</p>
        </div>
    </div>
</body>

</html>