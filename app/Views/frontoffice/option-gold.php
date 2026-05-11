<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre Premium Gold - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
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
                <div class="alert alert-success" id="gold-success">
                    <div class="alert-icon">✅</div>
                    <div class="alert-content">
                        <strong>Vous êtes déjà un utilisateur Premium Gold !</strong>
                        <p>Profitez de tous les avantages exclusifs.</p>
                    </div>
                </div>
            <?php } else { ?>
                <button id="gold-ajax-btn" class="btn btn--primary btn--full gold-cta" data-id="<?= $id ?>">
                    🚀 Devenir Premium Gold Maintenant
                </button>
                <div id="gold-ajax-feedback" style="margin-top:1em;"></div>
            <?php } ?>

            <p class="gold-bottom-note">
                Achat unique, avantages illimités
            </p>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('gold-ajax-btn');
        if (btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                btn.disabled = true;
                const feedback = document.getElementById('gold-ajax-feedback');
                feedback.innerHTML = '<span class="loader"></span> Traitement...';
                fetch('/gold-ajax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: 'id_Utilisateur=' + encodeURIComponent(btn.dataset.id)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        feedback.innerHTML = '<div class="alert alert-success"><div class="alert-icon">✅</div><div class="alert-content"><strong>' + data.message + '</strong><p>Profitez de tous les avantages exclusifs.</p></div></div>';
                        btn.style.display = 'none';
                    } else {
                        feedback.innerHTML = '<div class="alert alert-danger"><div class="alert-icon">❌</div><div class="alert-content"><strong>' + data.message + '</strong></div></div>';
                        btn.disabled = false;
                    }
                })
                .catch(() => {
                    feedback.innerHTML = '<div class="alert alert-danger"><div class="alert-icon">❌</div><div class="alert-content"><strong>Erreur lors de la requête.</strong></div></div>';
                    btn.disabled = false;
                });
            });
        }
    });
    </script>
</body>

</html>