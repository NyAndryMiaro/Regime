<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer mon Objectif - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    
</head>

<body>
    <!-- Navigation -->
    <?php include("navbar/navbar-user.html"); ?>

    <div class="container objectif-container">
        <!-- Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="success-message">
                ✅ <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message">
                ❌ <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="objectif-header">
            <h1>🎯 Gérer votre Objectif</h1>
            <p>Choisissez l'objectif qui correspond le mieux à vos besoins nutritionnels</p>
        </div>

        <!-- Statistiques de l'utilisateur -->
        <div class="user-stats">
            <h3 style="margin-top: 0;">Vos Informations</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-label">Taille</div>
                    <div class="stat-value"><?= $user['taille'] ?? '165' ?></div>
                    <div class="stat-unit">cm</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Poids</div>
                    <div class="stat-value"><?= $user['poids'] ?? '65' ?></div>
                    <div class="stat-unit">kg</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">IMC</div>
                    <div class="stat-value"><?= number_format(($user['poids'] ?? 65) / (($user['taille'] ?? 165) ** 2 / 10000), 1) ?></div>
                    <div class="stat-unit">kg/m²</div>
                </div>
            </div>
        </div>

        <!-- Objectif Actuel -->
        <?php if ($objectifActuel): ?>
            <div class="objectif-current">
                <h3>Votre objectif actuel</h3>
                <p><?= esc($objectifActuel['libelle']) ?></p>
            </div>
        <?php else: ?>
            <div class="objectif-current" style="background-color: #ffc107; color: #333;">
                <h3>⚠️ Aucun objectif défini</h3>
                <p>Commencez par choisir un objectif ci-dessous</p>
            </div>
        <?php endif; ?>

        <!-- Formulaire de Sélection d'Objectif -->
        <form action="/objectif" method="post" id="objectifForm">
            <div class="objectif-options">
                <?php foreach ($objectifs as $obj): ?>
                    <label class="objectif-option-card <?= ($objectifActuel && $objectifActuel['id_Objectif'] == $obj['id_Objectif']) ? 'selected' : '' ?>">
                        <div class="objectif-icon">
                            <?php
                            $icons = [
                                'Perte de' => '📉',
                                'Prise' => '📈',
                                'Maintien' => '⚖️',
                                'Définition' => '💪',
                                'Musculation' => '🏋️',
                                'Santé' => '❤️',
                                'Équilibré' => '🥗',
                                'Végétarien' => '🥬',
                                'Protéiné' => '🍗',
                                'default' => '🎯'
                            ];

                            $icon = '🎯';
                            foreach ($icons as $key => $value) {
                                if (strpos($obj['libelle'], $key) !== false) {
                                    $icon = $value;
                                    break;
                                }
                            }
                            echo $icon;
                            ?>
                        </div>
                        <h4><?= esc($obj['libelle']) ?></h4>
                        <p>Optez pour cet objectif pour améliorer votre progression</p>
                        <input type="radio" name="objectif" value="<?= $obj['id_Objectif'] ?>" <?= ($objectifActuel && $objectifActuel['id_Objectif'] == $obj['id_Objectif']) ? 'checked' : '' ?>>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Valider mon Objectif</button>
                <a href="/accueil" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Ré-Gym - Votre guide de nutrition personnalisé</p>
    </footer>

    <script>
        // Ajouter une classe 'selected' au clic sur une carte
        document.querySelectorAll('.objectif-option-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.objectif-option-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });

        // Activer le form submit en AJAX pour meilleure UX
        document.getElementById('objectifForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const selectedObjectif = formData.get('objectif');

            if (!selectedObjectif) {
                alert('Veuillez sélectionner un objectif');
                return;
            }

            // Utiliser la méthode choixObjectif pour traiter le changement
            fetch('/objectif', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher un message de succès
                    window.location.href = '/accueil';
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                // Fallback: soumettre le formulaire normalement
                this.submit();
            });
        });
    </script>
</body>

</html>
