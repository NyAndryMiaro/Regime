<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Personnalisé - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>

<body>
    <?php include 'navbar/navbar-user.html'; ?>

    <div class="plan-container page-continue">
        <div class="plan-header">
            <h1>🎯 Votre Plan Personnalisé</h1>
            <p>Un programme adapté à votre objectif et votre morphologie</p>
        </div>

        <div class="plan-actions">
            <button class="btn btn--primary" onclick="exportPDF()">📥 Télécharger en PDF</button>
            <a href="/regimes" class="btn btn--secondary">← Retour aux régimes</a>
        </div>

        <div id="planContent">
            <div class="plan-section">
                <h2>👤 Votre Profil</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Taille</div>
                        <div class="info-value"><?= $user['taille'] ?> cm</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Poids Actuel</div>
                        <div class="info-value"><?= $user['poids'] ?> kg</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">IMC Actuel</div>
                        <div class="info-value"><?= number_format($user['poids'] / (($user['taille'] / 100) ** 2), 1) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Poids Idéal</div>
                        <div class="info-value"><?= $poidsIdeal['poids_ideal'] ?> kg</div>
                    </div>
                </div>
            </div>

            <div class="plan-section">
                <h2>🎯 Votre Objectif</h2>
                <div class="section-content">
                    <p class="section-intro">
                        <strong><?= esc($objectif['libelle']) ?></strong>
                    </p>
                    <div class="highlight-box">
                        <h3>À atteindre</h3>
                        <p><?= abs($ecart) ?> kg</p>
                    </div>
                </div>
            </div>

            <div class="plan-section">
                <h2>🍽️ Régime Recommandé</h2>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Régime</div>
                            <div class="info-value info-value--md"><?= esc($regime['libelle']) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Variation Poids</div>
                            <div class="info-value <?= $regime['variation_poids'] >= 0 ? 'value-positive' : 'value-negative' ?>">
                                <?= $regime['variation_poids'] >= 0 ? '+' : '' ?><?= $regime['variation_poids'] ?> kg
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Prix Unitaire</div>
                            <div class="info-value"><?= number_format($regime['prix_unitaire'], 0) ?> FCFA</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Durée</div>
                            <div class="info-value"><?= $regime['duree'] ?> jours</div>
                        </div>
                    </div>

                    <h3 class="section-subtitle">Composition Nutritionnelle</h3>
                    <table class="composition-table">
                        <thead>
                            <tr>
                                <th>Composant</th>
                                <th>Pourcentage</th>
                                <th>Visualisation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>🥩 Viande</td>
                                <td><?= $regime['pourcentage_viande'] ?>%</td>
                                <td>
                                    <div class="percentage-bar">
                                        <div class="percentage-fill" style="width: <?= $regime['pourcentage_viande'] ?>%;">
                                            <?= $regime['pourcentage_viande'] ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>🐟 Poisson</td>
                                <td><?= $regime['pourcentage_poisson'] ?>%</td>
                                <td>
                                    <div class="percentage-bar">
                                        <div class="percentage-fill" style="width: <?= $regime['pourcentage_poisson'] ?>%;">
                                            <?= $regime['pourcentage_poisson'] ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>🥬 Légumes</td>
                                <td><?= $regime['pourcentage_legume'] ?>%</td>
                                <td>
                                    <div class="percentage-bar">
                                        <div class="percentage-fill" style="width: <?= $regime['pourcentage_legume'] ?>%;">
                                            <?= $regime['pourcentage_legume'] ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="highlight-box">
                        <h3>Poids Estimé Après Régime</h3>
                        <p><?= number_format($user['poids'] + $regime['variation_poids'], 1) ?> kg</p>
                    </div>
                </div>
            </div>

            <div class="plan-section">
                <h2>💪 Activité Recommandée</h2>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Activité</div>
                            <div class="info-value info-value--md"><?= esc($activite['libelle']) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Variation Poids</div>
                            <div class="info-value <?= $activite['variation_poids'] >= 0 ? 'value-positive' : 'value-negative' ?>">
                                <?= $activite['variation_poids'] >= 0 ? '+' : '' ?><?= $activite['variation_poids'] ?> kg
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Durée</div>
                            <div class="info-value"><?= $activite['duree'] ?> minutes</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Impact</div>
                            <div class="info-value"><?= abs($activite['variation_poids']) ?> kg</div>
                        </div>
                    </div>

                    <div class="highlight-box">
                        <h3>Poids Estimé Après Activité</h3>
                        <p><?= number_format($user['poids'] + $activite['variation_poids'], 1) ?> kg</p>
                    </div>
                </div>
            </div>

            <div class="plan-section">
                <h2>📅 Progression Estimée</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon">1</div>
                        <div class="timeline-content">
                            <div class="timeline-title">Démarrage</div>
                            <div class="timeline-description">Poids: <?= $user['poids'] ?> kg | IMC: <?= number_format($user['poids'] / (($user['taille'] / 100) ** 2), 1) ?></div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon">2</div>
                        <div class="timeline-content">
                            <div class="timeline-title">Après Régime (<?= $regime['duree'] ?> jours)</div>
                            <div class="timeline-description">Poids estimé: <?= number_format($user['poids'] + $regime['variation_poids'], 1) ?> kg</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon">3</div>
                        <div class="timeline-content">
                            <div class="timeline-title">Avec Activité Régulière</div>
                            <div class="timeline-description">Poids potentiel: <?= number_format($user['poids'] + $regime['variation_poids'] + $activite['variation_poids'], 1) ?> kg</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon">4</div>
                        <div class="timeline-content">
                            <div class="timeline-title">Objectif Final</div>
                            <div class="timeline-description">Poids idéal: <?= $poidsIdeal['poids_ideal'] ?> kg</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-note">
                <p>📋 Ce plan a été généré le <?= date('d/m/Y à H:i') ?></p>
                <p>⚠️ Consulter un médecin avant de commencer tout nouveau régime ou programme d'exercices</p>
                <p>💚 Ré-Gym - Votre guide de nutrition personnalisé</p>
            </div>
        </div>
    </div>

    <script>
        function exportPDF() {
            const element = document.getElementById('planContent');
            const opt = {
                margin: 10,
                filename: `plan-personnel-${new Date().getTime()}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>

</html>
