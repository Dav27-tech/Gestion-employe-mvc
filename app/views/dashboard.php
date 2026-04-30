<?php require __DIR__ . '/header.php'; ?>
<?php
$employees = is_array($data ?? null) ? $data : [];
$totalEmployees = count($employees);
$departments = [];
$salaryTotal = 0;

foreach ($employees as $employee) {
    $department = trim($employee['departement'] ?? 'Non assigné');
    $departments[$department] = ($departments[$department] ?? 0) + 1;
    $salaryTotal += (float) ($employee['salaire'] ?? 0);
}

$departmentCount = count($departments);
$averageSalary = $totalEmployees > 0 ? round($salaryTotal / $totalEmployees) : 0;
$newThisMonth = min($totalEmployees, 3);
$recentEmployees = array_slice($employees, 0, 5);
$currentDate = date('d/m/Y');
$esc = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$initials = function ($name) {
    $name = trim((string) $name);
    if ($name === '') {
        return 'FS';
    }

    $parts = preg_split('/\s+/', $name);
    $first = substr($parts[0] ?? 'F', 0, 1);
    $second = isset($parts[1]) ? substr($parts[1], 0, 1) : substr($parts[0] ?? 'S', 1, 1);

    return strtoupper(($first ?: 'F') . ($second ?: 'S'));
};
?>

<section class="dashboard-hero">
    <div class="hero-copy">
        <span class="eyebrow">Aujourd’hui · <?php echo $currentDate; ?></span>
        <h2>Bienvenue, gardez le pilotage RH clair et rapide.</h2>
        <p>Suivez la croissance de l’équipe, les salaires, les départements et les actions importantes depuis une interface calme et précise.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="?page=insererEmploye">Ajouter Employee</a>
            <a class="btn btn-secondary" href="?page=liste">Voir la liste</a>
        </div>
    </div>
    <div class="hero-insight">
        <span class="insight-label">Team health</span>
        <strong><?php echo $totalEmployees > 0 ? 'Stable' : 'À configurer'; ?></strong>
        <div class="insight-ring">
            <span><?php echo $totalEmployees; ?></span>
        </div>
        <p><?php echo $departmentCount; ?> départements actifs dans FlowStaff</p>
    </div>
</section>

<section class="kpi-grid" aria-label="Statistiques principales">
    <article class="kpi-card">
        <div class="kpi-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 11a4 4 0 1 0-3.5-5.94A5 5 0 1 0 9 13h6a5 5 0 0 0 1-2Zm-7 4c-3.31 0-6 1.79-6 4v1h12v-1c0-2.21-2.69-4-6-4Z"/></svg>
        </div>
        <span>Total Employees</span>
        <strong><?php echo $totalEmployees; ?></strong>
        <div class="kpi-footer"><em>+12%</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 24 C18 8, 30 28, 44 16 S72 7, 88 14 S106 22, 118 6"/></svg></div>
    </article>

    <article class="kpi-card">
        <div class="kpi-icon kpi-icon--success">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
        </div>
        <span>New This Month</span>
        <strong><?php echo $newThisMonth; ?></strong>
        <div class="kpi-footer"><em>+8%</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 20 C18 18, 22 8, 38 11 S70 22, 82 12 S102 4, 118 9"/></svg></div>
    </article>

    <article class="kpi-card">
        <div class="kpi-icon kpi-icon--warning">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16v4H4V6Zm0 8h7v4H4v-4Zm9 0h7v4h-7v-4Z"/></svg>
        </div>
        <span>Departments</span>
        <strong><?php echo $departmentCount; ?></strong>
        <div class="kpi-footer"><em>Actifs</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 16 C18 10, 34 14, 50 9 S84 8, 118 14"/></svg></div>
    </article>

    <article class="kpi-card">
        <div class="kpi-icon kpi-icon--danger">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 18h12M8 14h8M10 10h4M12 3v18"/></svg>
        </div>
        <span>Average Salary</span>
        <strong>$<?php echo number_format($averageSalary, 0, ',', ' '); ?></strong>
        <div class="kpi-footer"><em>+3%</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 22 C20 24, 32 12, 48 14 S70 18, 84 10 S104 6, 118 8"/></svg></div>
    </article>
</section>

<section class="dashboard-grid">
    <div class="dashboard-main">
        <article class="panel chart-panel">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Analytics</span>
                    <h3>Employee growth</h3>
                </div>
                <span class="pill">2026</span>
            </div>
            <div class="growth-chart" aria-label="Graphique de croissance des employés">
                <svg viewBox="0 0 640 260" role="img">
                    <defs>
                        <linearGradient id="growthFill" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="var(--primary)" stop-opacity=".28"/>
                            <stop offset="100%" stop-color="var(--primary)" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path class="chart-grid" d="M40 40H610M40 100H610M40 160H610M40 220H610"/>
                    <path class="chart-area" d="M40 205 C115 180, 125 145, 190 154 S285 195, 350 132 S455 82, 610 62 L610 230 L40 230 Z"/>
                    <path class="chart-line-main" d="M40 205 C115 180, 125 145, 190 154 S285 195, 350 132 S455 82, 610 62"/>
                    <circle cx="350" cy="132" r="5"/>
                    <circle cx="610" cy="62" r="5"/>
                </svg>
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">People</span>
                    <h3>Recent employees</h3>
                </div>
                <a class="text-link" href="?page=liste">Tout voir</a>
            </div>
            <div class="modern-table-wrap">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentEmployees)) : ?>
                            <?php foreach ($recentEmployees as $employee) : ?>
                                <tr>
                                    <td><span class="avatar"><?php echo $esc($initials($employee['nom'] ?? 'Flow Staff')); ?></span></td>
                                    <td>
                                        <strong><?php echo $esc($employee['nom'] ?? 'Employé'); ?></strong>
                                        <small><?php echo $esc($employee['email'] ?? ''); ?></small>
                                    </td>
                                    <td><?php echo $esc($employee['poste'] ?? 'Non défini'); ?></td>
                                    <td>$<?php echo number_format((float) ($employee['salaire'] ?? 0), 0, ',', ' '); ?></td>
                                    <td><span class="status-badge">Actif</span></td>
                                    <td><a class="row-menu" href="?page=edit&id=<?php echo $esc($employee['id'] ?? ''); ?>" aria-label="Modifier">•••</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="6" class="empty-state">Aucun employé pour le moment.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination-ui">
                <button type="button" disabled>Précédent</button>
                <span>Page 1 sur 1</span>
                <button type="button" disabled>Suivant</button>
            </div>
        </article>
    </div>

    <aside class="dashboard-side">
        <article class="panel quick-actions">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Shortcuts</span>
                    <h3>Quick actions</h3>
                </div>
            </div>
            <a class="action-row" href="?page=insererEmploye">
                <span>+</span>
                <div><strong>Add Employee</strong><small>Créer un nouveau profil</small></div>
            </a>
            <a class="action-row" href="?page=liste">
                <span>↓</span>
                <div><strong>Export Data</strong><small>Préparer les données équipe</small></div>
            </a>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Planning</span>
                    <h3>Upcoming tasks</h3>
                </div>
            </div>
            <div class="task-list">
                <label><input type="checkbox"> Vérifier les nouveaux profils</label>
                <label><input type="checkbox"> Mettre à jour les salaires</label>
                <label><input type="checkbox"> Préparer le rapport RH</label>
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Activity</span>
                    <h3>Recent activity</h3>
                </div>
            </div>
            <div class="activity-feed">
                <div><span></span><p><strong>Profil ajouté</strong><small>Nouvel employé synchronisé</small></p></div>
                <div><span></span><p><strong>Liste consultée</strong><small>Gestion des employés ouverte</small></p></div>
                <div><span></span><p><strong>Données prêtes</strong><small>Tableau mis à jour</small></p></div>
            </div>
        </article>
    </aside>
</section>

<?php require __DIR__ . '/footer.php'; ?>
