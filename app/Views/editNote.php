<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Modification des notes</title>
  <link rel="stylesheet" href="/style.css" />
</head>
<body>

<?php
$nom = $etudiant['Nom'] ?? 'Étudiant';
$prenom = $etudiant['Prenom'] ?? '';
$etu = $etudiant['ETU'] ?? '';
$successMessage = session()->getFlashdata('success');
$errorMessage = session()->getFlashdata('error');
?>

<?php /** @var array $sections */ ?>
<?php /** @var int $idSemestre */ ?>

<div class="app">
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

    <a href="<?= site_url('list') ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Liste des étudiants
    </a>
    <a href="<?= site_url('notes/' . $etu) ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      Vue des notes
    </a>
    <a href="<?= site_url('form') ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Ajouter une note
    </a>

    <div class="sidebar-section">Session</div>

    <a href="<?= site_url('/') ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Déconnexion
    </a>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Modification des notes</div>
      <div class="topbar-search">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Rechercher…" />
      </div>
      <div class="topbar-actions">
        <button class="icon-btn" type="button">
          <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </button>
        <button class="icon-btn" type="button">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
        </button>
      </div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Notes de <?= esc(trim($nom . ' ' . $prenom)); ?></h2>
          <div class="breadcrumb">Accueil / Notes / <span>Semestre <?= (int) $idSemestre; ?></span></div>
        </div>
        <a href="<?= site_url('notes/' . $etu) ?>" class="btn btn-secondary btn-sm">
          <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
          Retour
        </a>
      </div>

      <div class="alert alert-info">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>Modifiez la valeur puis cliquez sur <strong>Modifier</strong>. Pour supprimer une note, elle est simplement remise à <strong>0</strong>.</span>
      </div>

      <?php if (is_string($successMessage)): ?>
        <div class="alert alert-success"><?= esc($successMessage); ?></div>
      <?php endif; ?>

      <?php if (is_string($errorMessage)): ?>
        <div class="alert alert-danger"><?= esc($errorMessage); ?></div>
      <?php endif; ?>

      <?php foreach ($sections as $section): ?>
        <div class="table-card" style="margin-bottom: 16px;">
          <h3 style="padding:16px 16px 0 16px;"><?= esc((string) ($section['title'] ?? '')); ?></h3>
          <table>
            <thead>
              <tr>
                <th>Matière</th>
                <th>Note</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($section['notes'])): ?>
                <?php foreach ($section['notes'] as $note): ?>
                  <tr>
                    <td><?= esc((string) ($note['nomMatiere'] ?? '')); ?></td>
                    <td style="min-width: 180px;">
                      <form method="post" action="<?= site_url('modifiernote/' . $etu . '/' . $idSemestre); ?>" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                        <input type="hidden" name="idMatiere" value="<?= esc((string) ($note['idMatiere'] ?? '')); ?>" />
                        <input type="hidden" name="idParcours" value="<?= esc((string) ($note['idParcours'] ?? '')); ?>" />
                        <input type="number" name="valeur" min="0" max="20" step="0.5" value="<?= esc((string) ($note['valeur'] ?? 0)); ?>" style="max-width:120px;" required />
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                        <button type="submit" class="btn btn-ghost btn-sm" formaction="<?= site_url('supprimernote/' . $etu . '/' . $idSemestre); ?>" onclick="this.form.querySelector('[name=valeur]').value = 0;">
                          Supprimer
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="3" style="text-align:center;">Aucune donnée</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

</body>
</html>
