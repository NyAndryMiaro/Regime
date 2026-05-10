<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Personnalisé - Ré-Gym</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        .plan-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        .plan-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .plan-header h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .plan-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .btn-export {
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-back {
            padding: 0.75rem 1.5rem;
            background: #e5e7eb;
            color: #333;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background: #d1d5db;
        }

        #planContent {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .plan-section {
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .plan-section:last-child {
            border-bottom: none;
        }

        .plan-section h2 {
            font-size: 1.8rem;
            color: #667eea;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-content {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .info-label {
            font-size: 0.85rem;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
        }

        .composition-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .composition-table th {
            background: #667eea;
            color: white;
            padding: 0.75rem;
            text-align: left;
            font-weight: 600;
        }

        .composition-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .composition-table tr:hover {
            background: #f9fafb;
        }

        .percentage-bar {
            width: 100%;
            height: 24px;
            background: #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .percentage-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .highlight-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
            text-align: center;
        }

        .highlight-box h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.2rem;
        }

        .highlight-box p {
            margin: 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .timeline {
            margin-top: 1.5rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem 0;
        }

        .timeline-icon {
            width: 32px;
            height: 32px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            flex-shrink: 0;
        }

        .timeline-content {
            flex-grow: 1;
        }

        .timeline-title {
            font-weight: bold;
            color: #333;
        }

        .timeline-description {
            font-size: 0.9rem;
            color: #666;
        }

        .footer-note {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f0f0f0;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        @media print {
            .plan-actions {
                display: none;
            }
            .btn-back {
                display: none;
            }
            #planContent {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <?php include 'navbar/navbar-user.html'; ?>

    <div class="plan-container">
        <div class="plan-header">
            <h1>🎯 Votre Plan Personnalisé</h1>
            <p>Un programme adapté à votre objectif et votre morphologie</p>
        </div>

        <div class="plan-actions">
            <button class="btn-export" onclick="exportPDF()">📥 Télécharger en PDF</button>
            <a href="/regimes" class="btn-back">← Retour aux régimes</a>
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
                    <p style="font-size: 1.1rem; color: #333; margin: 0;">
                        <strong><?= esc($objectif['libelle']) ?></strong>
                    </p>
                    <div class="highlight-box" style="margin-top: 1rem;">
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
                            <div class="info-value" style="font-size: 1.2rem;"><?= esc($regime['libelle']) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Variation Poids</div>
                            <div class="info-value" style="color: <?= $regime['variation_poids'] >= 0 ? '#10b981' : '#ef4444' ?>;">
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

                    <h3 style="margin-top: 1.5rem; color: #333;">Composition Nutritionnelle</h3>
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
                            <div class="info-value" style="font-size: 1.2rem;"><?= esc($activite['libelle']) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Variation Poids</div>
                            <div class="info-value" style="color: <?= $activite['variation_poids'] >= 0 ? '#10b981' : '#ef4444' ?>;">
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
