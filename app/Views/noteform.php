<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Formulaire utilisateur</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="app">

  <!-- ── Sidebar ──────────────────────────────────────────────────────────── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">SysInfo</div>
        <div class="brand-sub">v2.4.0</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>

    <a href="<?= site_url("list") ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Liste des notes
    </a>
    <a href="<?= site_url("form") ?>" class="nav-item active">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Ajouter une note
    </a>

    <div class="sidebar-section">Session</div>

    <a href="<?= site_url("/") ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Déconnexion
    </a>

    <div class="sidebar-bottom">
      <a href="<?= site_url("/") ?>" class="user-row">
        <div class="avatar">🚪</div>
        <div class="user-info">
          <div class="name">Quitter</div>
        </div>
      </a>
    </div>
  </aside>

  <!-- ── Main ─────────────────────────────────────────────────────────────── -->
  <div class="main">

    <div class="topbar">
      <div class="topbar-title">Formulaire d'ajout de notes</div>
      <div class="topbar-search">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Rechercher…" />
      </div>
      <div class="topbar-actions">
        <button class="icon-btn">
          <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </button>
        <button class="icon-btn">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
        </button>
      </div>
    </div>

    <div class="content">

      <div class="page-header">
        <div>
          <h2>Ajouter une note</h2>
          <div class="breadcrumb">Accueil / Notes / <span>Nouvelle</span></div>
        </div>
        <a href="<?= site_url('list') ?>" class="btn btn-secondary btn-sm">
          <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
          Liste des notes
        </a>
      </div>

      <div class="alert alert-info">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>Les champs marqués d'un <strong>*</strong> sont obligatoires.</span>
      </div>

      <form method="POST" action="<?= site_url('notes') ?>">

        <div class="form-card section-gap">
          <div class="form-section-title">Formulaire d'ajout de notes 
          </div>
          <div class="form-grid">
            <div>
              <label class="field-label">Semestre <span class="required">*</span></label>
              <select id="semestreSelect" name="idSemestre" required onchange="updateParcours()">
                <option value="">— Sélectionner —</option>
                <?php foreach ($semestre as $s): ?>
                  <option value="<?= esc((string) ($s['idSemestre'] ?? '')); ?>">
                    <?= esc((string) ($s['libelle'] ?? '')); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="field-label">Parcours <span class="required">*</span></label>
              <select id="parcourSelect" name="idParcours" required onchange="updateMatieres()">
                <option value="">— Veuillez d'abord sélectionner un semestre —</option>
              </select>
            </div>
            <div>
              <label class="field-label">Étudiant <span class="required">*</span></label>
              <select name="idEtudiant" required>
                <option value="">— Sélectionner —</option>
                <?php foreach ($etudiant as $etu): ?>
                  <option value="<?= esc((string) ($etu['ETU'] ?? '')); ?>">
                    <?= esc((string) (($etu['Prenom'] ?? '') . ' ' . ($etu['Nom'] ?? '') . ' (' . ($etu['ETU'] ?? '') . ')')); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="field-label">Matière <span class="required">*</span></label>
              <select id="matiereSelect" name="idMatiere" required>
                <option value="">— Veuillez d'abord sélectionner un parcours —</option>
              </select>
            </div>
            <div>
              <label class="field-label">Valeur de la note <span class="required">*</span></label>
              <input type="number" name="valeur" min="0" max="20" step="0.5" placeholder="Entre 0 et 20" required />
            </div>
            <div>
              <label class="field-label">Résultat</label>
              <input type="text" name="resultat" placeholder="Automatique ou manuel" />
            </div>
          </div>
        </div>

        <!-- ── Footer boutons ─────────────────────────────────────────── -->
        <div class="form-footer">
          <a href="<?= site_url('list') ?>" class="btn btn-secondary">Annuler</a>
          <button type="button" class="btn btn-ghost">Enregistrer comme brouillon</button>
          <button type="submit" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Enregistrer la note
          </button>
        </div>

      </form>

      <script>
        const matieresByParcours = <?= $matieresByParcours ?>;
        const parcoursBySemestre = <?= $parcoursBySemestre ?>;

        function updateParcours() {
          const semestreSelect = document.getElementById('semestreSelect');
          const parcourSelect = document.getElementById('parcourSelect');
          const matiereSelect = document.getElementById('matiereSelect');
          const idSemestre = parseInt(semestreSelect.value);

          // Réinitialiser les selects
          parcourSelect.innerHTML = '<option value="">— Sélectionner —</option>';
          matiereSelect.innerHTML = '<option value="">— Veuillez d\'abord sélectionner un parcours —</option>';

          if (idSemestre && parcoursBySemestre[idSemestre]) {
            parcoursBySemestre[idSemestre].forEach(parcour => {
              const option = document.createElement('option');
              option.value = parcour.idParcours;
              option.textContent = parcour.parcours;
              parcourSelect.appendChild(option);
            });
            
            // Auto-select si S3 (Tronc commun)
            if (idSemestre === 1 && parcoursBySemestre[idSemestre].length > 0) {
              parcourSelect.value = parcoursBySemestre[idSemestre][0].idParcours;
              updateMatieres();
            }
          }
        }

        function updateMatieres() {
          const parcourSelect = document.getElementById('parcourSelect');
          const matiereSelect = document.getElementById('matiereSelect');
          const idParcours = parcourSelect.value;

          // Vider le select des matières
          matiereSelect.innerHTML = '<option value="">— Sélectionner —</option>';

          if (idParcours && matieresByParcours[idParcours]) {
            matieresByParcours[idParcours].forEach(matiere => {
              const option = document.createElement('option');
              option.value = matiere.idMatiere;
              const type = matiere.estObligatoire ? '(Obligatoire)' : '(Optionnel)';
              option.textContent = matiere.Nom + ' - ' + matiere.Credit + ' crédits ' + type;
              matiereSelect.appendChild(option);
            });
          }
        }
      </script>

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /app -->

<script src="script.js"></script>
</body>
</html>
