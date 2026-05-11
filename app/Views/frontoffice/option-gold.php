<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre Premium Gold - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>

<body>
    <?php include("navbar/navbar-user.html"); ?>

    <div class="container page-continue">
        <section class="hero">
            <h1>✨ Offre Premium Gold</h1>
            <p>Déverrouillez toutes les fonctionnalités premium avec Ré-Gym Gold</p>
        </section>

        <section class="card card--pad gold-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">🏆 Ré-Gym Premium Gold</h2>
                    <p class="card-subtitle">Accès illimité à tous les régimes et activités</p>
                </div>
            </div>

            <div class="gold-offer-box">
                <div class="gold-offer-center">
                    <div class="gold-offer-label">Remise exclusive</div>
                    <div class="gold-offer-value">
                        <?= $parametre["remise"] * 100 ?>%
                    </div>
                    <p class="gold-offer-note">sur tous vos achats</p>
                </div>
            </div>

            <div class="gold-benefits-box">
                <h3 class="gold-benefits-title">✅ Avantages inclus :</h3>
                <ul class="gold-benefits-list">
                    <li>Accès illimité aux régimes premium</li>
                    <li>Suivi nutritionnel avancé</li>
                    <li>Coach personnel virtuel</li>
                    <li>Remise <?= $parametre["remise"] * 100 ?>% sur tous les achats</li>
                    <li>Priorité support client</li>
                    <li>Validité illimitée</li>
                </ul>
            </div>

            <div class="gold-price-wrap">
                <p class="gold-price-line">
                    <strong>Prix :</strong> <span class="gold-price-value"><?= $parametre["prix"] ?> Ar</span>
                </p>
            </div>

            <?php 
                $user = session()->get('user'); 
                $id = $user['id'];
                if ($user != null && $user['estGold']) { 
            ?>
                <div class="alert alert-success">
                    <div class="alert-icon">✅</div>
                    <div class="alert-content">
                        <strong>Vous êtes déjà un utilisateur Premium Gold !</strong>
                        <p>Profitez de tous les avantages exclusifs.</p>
                    </div>
                </div>
            <?php } else { ?>
                <a href="/devenir-gold/<?= $id ?>" class="btn btn--primary btn--full gold-cta">
                    🚀 Devenir Premium Gold Maintenant
                </a>
            <?php } ?>

            <p class="gold-bottom-note">
                Achat unique, avantages illimités
            </p>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>
</body>

</html>