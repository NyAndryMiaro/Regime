<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Utilisateurs</title>
  <link rel="stylesheet" href="/style.css" />
</head>
<body>

<?php /** @var array $etudiant */ ?>

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

    <a href="<?= site_url("list") ?>" class="nav-item active">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Liste des notes
    </a>
    <a href="<?= site_url("form") ?>" class="nav-item">
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
      <div class="topbar-title">Gestion des utilisateurs</div>
      <div class="topbar-search">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Rechercher…" />
      </div>
      <div class="topbar-actions">
        <button class="icon-btn">
          <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          <span class="notif-dot"></span>
        </button>
        <button class="icon-btn">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
        </button>
      </div>

    </div>

    <div class="content">

      <div class="page-header">
        <div>
          <h2>Notes de <?= $etudiant['Nom'] ?? 'Étudiant'; ?> <?= $etudiant['Prenom'] ?? ''; ?></h2>
          <div class="breadcrumb">Accueil / <span>Notes (<?= $etudiant['ETU'] ?? ''; ?>)</span></div>
        </div>
      </div>

      <?php
      $sections = [
        ['title' => 'S3', 'notes' => $noteS3 ?? [], 'total' => $totalCreditsS3 ?? 0, 'moyenne' => $moyenneS3 ?? 0],
        ['title' => 'S4 option dev', 'notes' => $noteS4Dev ?? [], 'total' => $totalCreditsS4Dev ?? 0, 'moyenne' => $moyenneS4Dev ?? 0],
        ['title' => 'S4 option bddres', 'notes' => $noteS4BddRes ?? [], 'total' => $totalCreditsS4BddRes ?? 0, 'moyenne' => $moyenneS4BddRes ?? 0],
        ['title' => 'S4 option web', 'notes' => $noteS4Web ?? [], 'total' => $totalCreditsS4Web ?? 0, 'moyenne' => $moyenneS4Web ?? 0],
        ['title' => 'L2 option dev', 'notes' => $noteL2Dev ?? [], 'total' => $totalCreditsL2Dev ?? 0, 'moyenne' => $moyenneL2Dev ?? 0],
        ['title' => 'L2 option bddres', 'notes' => $noteL2BddRes ?? [], 'total' => $totalCreditsL2BddRes ?? 0, 'moyenne' => $moyenneL2BddRes ?? 0],
        ['title' => 'L2 option web', 'notes' => $noteL2Web ?? [], 'total' => $totalCreditsL2Web ?? 0, 'moyenne' => $moyenneL2Web ?? 0],
      ];
      ?>

      <?php foreach ($sections as $section) : ?>
      <div class="table-card" style="margin-bottom: 16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:16px 16px 0 16px;gap:12px;flex-wrap:wrap;">
          <h3 style="margin:0;"><?= esc($section['title']); ?></h3>
          <a href="<?= site_url('modifiernote/' . ($etudiant['ETU'] ?? '') . '/' . (str_starts_with($section['title'], 'S3') ? 1 : 2)); ?>" class="btn btn-secondary btn-sm">
            Modifier
          </a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Matière</th>
              <th>Crédits</th>
              <th>Valeur</th>
              <th>Résultat</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!empty($section['notes'])) : ?>
            <?php foreach ($section['notes'] as $n) : ?>
              <tr>
                <td><?= esc((string) ($n['nomMatiere'] ?? '')); ?></td>
                <td><?= (int) ($n['Credit'] ?? 0); ?></td>
                <td><?= (float) ($n['valeur'] ?? 0); ?></td>
                <td><?= esc((string) ($n['resultat'] ?? '-')); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" style="text-align:center;">Aucune donnée</td>
            </tr>
          <?php endif; ?>
          <tr>
            <td><strong>Total crédits <?= esc($section['title']); ?></strong></td>
            <td><strong><?= (int) $section['total']; ?></strong></td>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td><strong>Moyenne <?= esc($section['title']); ?></strong></td>
            <td><strong><?= number_format((float) $section['moyenne'], 2, ',', ' '); ?></strong></td>
            <td colspan="2"></td>
          </tr>
          </tbody>
        </table>
      </div>
      <?php endforeach; ?>

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /app -->

</body>
</html>
