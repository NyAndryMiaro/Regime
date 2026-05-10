<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre Premium Gold - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <?php include("navbar/navbar-user.html"); ?>

    <div class="container page-continue">
        <section class="hero">
            <h1>✨ Offre Premium Gold</h1>
            <p>Déverrouillez toutes les fonctionnalités premium avec Ré-Gym Gold</p>
        </section>

        <section class="card card--pad" style="max-width: 700px; margin: 2rem auto;">
            <div class="card-header">
                <div>
                    <h2 class="card-title">🏆 Ré-Gym Premium Gold</h2>
                    <p class="card-subtitle">Accès illimité à tous les régimes et activités</p>
                </div>
            </div>

            <div style="margin: 2rem 0; padding: 2rem; background: linear-gradient(135deg, rgba(15, 139, 102, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%); border-radius: var(--radius-md); border: 2px solid rgba(15, 139, 102, 0.2);">
                <div style="text-align: center;">
                    <div style="font-size: 1.1rem; color: var(--text-secondary); margin-bottom: 0.5rem;">Remise exclusive</div>
                    <div style="font-size: 3.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">
                        <?= $parametre["remise"] * 100 ?>%
                    </div>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">sur tous vos achats</p>
                </div>
            </div>

            <div style="margin: 2rem 0; padding: 1.5rem; background: rgba(15, 139, 102, 0.05); border-radius: var(--radius-md); border-left: 4px solid var(--primary);">
                <h3 style="margin-top: 0; color: var(--primary);">✅ Avantages inclus :</h3>
                <ul style="margin: 1rem 0; padding-left: 1.5rem; color: var(--text-secondary);">
                    <li>Accès illimité aux régimes premium</li>
                    <li>Suivi nutritionnel avancé</li>
                    <li>Coach personnel virtuel</li>
                    <li>Remise {{$parametre["remise"] * 100}}% sur tous les achats</li>
                    <li>Priorité support client</li>
                    <li>Validité illimitée</li>
                </ul>
            </div>

            <div style="margin: 2rem 0; text-align: center;">
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                    <strong>Prix :</strong> <span style="font-size: 1.35rem; color: var(--text-primary); font-weight: 700;"><?= $parametre["prix"] ?> Ar</span>
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
                <a href="/devenir-gold/<?= $id ?>" class="btn btn--primary btn--full" style="font-size: 1.05rem; padding: 1rem;">
                    🚀 Devenir Premium Gold Maintenant
                </a>
            <?php } ?>

            <p style="text-align: center; color: var(--text-secondary); font-size: 0.9rem; margin-top: 1.5rem;">
                Achat unique, avantages illimités
            </p>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>
</body>

</html>