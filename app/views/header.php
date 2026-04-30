<?php
$currentPage = $_GET['page'] ?? 'dashboard';
$pageTitles = [
    'dashboard' => ['Dashboard', 'Vue d’ensemble RH et performance équipe'],
    'liste' => ['Employés', 'Recherche, édition et gestion des profils'],
    'insererEmploye' => ['Ajouter un employé', 'Créer un nouveau profil collaborateur'],
    'edit' => ['Modifier un employé', 'Mettre à jour les informations du profil'],
];
$pageMeta = $pageTitles[$currentPage] ?? ['FlowStaff', 'Gestion moderne des employés'];

function isActivePage($currentPage, $pages) {
    return in_array($currentPage, (array) $pages, true) ? ' is-active' : '';
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowStaff</title>
    <script>
        (function () {
            const savedTheme = localStorage.getItem("flowstaff-theme");
            if (savedTheme === "light" || savedTheme === "dark") {
                document.documentElement.setAttribute("data-theme", savedTheme);
            }
        })();
    </script>
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>
</head>
<body>
<div class="app-shell" id="appShell">
    <aside class="sidebar" id="appSidebar" aria-label="Navigation principale">
        <div class="sidebar__header">
            <a class="brand" href="?page=dashboard" aria-label="Aller au dashboard">
                <span class="brand__mark">F</span>
                <span class="brand__copy">
                    <strong>FlowStaff</strong>
                    <small>People OS</small>
                </span>
            </a>
            <button class="icon-button sidebar__collapse" id="sidebarCollapse" type="button" aria-label="Réduire le menu">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
            </button>
        </div>

        <nav class="sidebar__nav">
            <span class="sidebar__label">Workspace</span>
            <a class="sidebar__link<?php echo isActivePage($currentPage, 'dashboard'); ?>" href="?page=dashboard">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13h6V4H4v9Zm10 7h6V4h-6v16ZM4 20h6v-3H4v3Z"/></svg>
                <span>Dashboard</span>
            </a>
            <a class="sidebar__link<?php echo isActivePage($currentPage, ['liste', 'edit']); ?>" href="?page=liste">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 11a4 4 0 1 0-3.5-5.94A5 5 0 1 0 9 13h6a5 5 0 0 0 1-2Zm-7 4c-3.31 0-6 1.79-6 4v1h12v-1c0-2.21-2.69-4-6-4Zm8 0c-.8 0-1.55.12-2.22.34 1.3.91 2.22 2.15 2.22 3.66v1h5v-1c0-2.21-2.24-4-5-4Z"/></svg>
                <span>Employés</span>
            </a>
            <a class="sidebar__link<?php echo isActivePage($currentPage, 'insererEmploye'); ?>" href="?page=insererEmploye">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11 5h2v6h6v2h-6v6h-2v-6H5v-2h6V5Z"/></svg>
                <span>Ajouter</span>
            </a>
        </nav>

        <div class="sidebar__panel">
            <span class="panel-kicker">Plan équipe</span>
            <strong>Gestion rapide</strong>
            <p>Accédez aux profils, salaires et départements en quelques secondes.</p>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay" hidden></div>

    <div class="workspace">
        <header class="topbar">
            <button class="icon-button topbar__menu" id="mobileSidebarToggle" type="button" aria-label="Ouvrir le menu">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <div class="topbar__title">
                <span><?php echo $pageMeta[1]; ?></span>
                <h1><?php echo $pageMeta[0]; ?></h1>
            </div>
            <div class="topbar__actions">
                <button id="themeToggle" class="theme-toggle" type="button" title="Changer de thème" aria-label="Changer de thème">
                    <span class="theme-icon">☾</span>
                </button>
            </div>
        </header>

        <main class="main-content">
