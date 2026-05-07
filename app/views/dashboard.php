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

// calculate new hires for the current month from `created_at` if available
$newThisMonth = 0;
$now = new DateTime();
$currentMonthKey = $now->format('Y-m');
foreach ($employees as $emp) {
    if (empty($emp['created_at'])) continue;
    $dt = date_create($emp['created_at']);
    if (!$dt) continue;
    if ($dt->format('Y-m') === $currentMonthKey) $newThisMonth++;
}
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
        <h2>Bienvenue, pilotez vos équipes, sans effort .</h2>
        <p>Gardez une vue nette sur vos effectifs, vos salaires et les décisions qui avancent.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="?page=insererEmploye">Ajouter un employé</a>
            <a class="btn btn-secondary" href="?page=liste">Voir la liste</a>
        </div>
    </div>
    <div class="hero-insight">
        <span class="insight-label">Santé de l’équipe</span>
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
        <span>Total employés</span>
        <strong><?php echo $totalEmployees; ?></strong>
        <div class="kpi-footer"><em>+12%</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 24 C18 8, 30 28, 44 16 S72 7, 88 14 S106 22, 118 6"/></svg></div>
    </article>

    <article class="kpi-card">
        <div class="kpi-icon kpi-icon--success">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
        </div>
        <span>Nouveaux ce mois</span>
        <strong><?php echo $newThisMonth; ?></strong>
        <div class="kpi-footer"><em>+8%</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 20 C18 18, 22 8, 38 11 S70 22, 82 12 S102 4, 118 9"/></svg></div>
    </article>

    <article class="kpi-card">
        <div class="kpi-icon kpi-icon--warning">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16v4H4V6Zm0 8h7v4H4v-4Zm9 0h7v4h-7v-4Z"/></svg>
        </div>
        <span>Départements</span>
        <strong><?php echo $departmentCount; ?></strong>
        <div class="kpi-footer"><em>Actifs</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 16 C18 10, 34 14, 50 9 S84 8, 118 14"/></svg></div>
    </article>

    <article class="kpi-card">
        <div class="kpi-icon kpi-icon--danger">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 18h12M8 14h8M10 10h4M12 3v18"/></svg>
        </div>
        <span>Salaire moyen</span>
        <strong>$<?php echo number_format($averageSalary, 0, ',', ' '); ?></strong>
        <div class="kpi-footer"><em>+3%</em><svg viewBox="0 0 120 30" aria-hidden="true"><path d="M2 22 C20 24, 32 12, 48 14 S70 18, 84 10 S104 6, 118 8"/></svg></div>
    </article>
</section>

<section class="dashboard-grid">
    <div class="dashboard-main">
        <article class="panel chart-panel">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Analyses</span>
                    <h3>Croissance des employés</h3>
                </div>
                <span class="pill">2026</span>
            </div>
            <div class="growth-chart" aria-label="Graphique de croissance des employés">
                <?php
                // Build a dataset: prefer 'created_at' timeline; fallback to department counts
                $hasCreated = false;
                foreach ($employees as $e) {
                    if (isset($e['created_at'])) { $hasCreated = true; break; }
                }

                $dataPoints = [];
                $labels = [];

                if ($hasCreated) {
                    // last 6 months counts
                    $now = new DateTime();
                    $months = [];
                    for ($i = 5; $i >= 0; $i--) {
                        $m = (clone $now)->modify("-{$i} months");
                        $key = $m->format('Y-m');
                        $months[$key] = 0;
                        $labels[] = $m->format('M');
                    }
                    foreach ($employees as $e) {
                        if (empty($e['created_at'])) continue;
                        $dt = date_create($e['created_at']);
                        if (!$dt) continue;
                        $k = $dt->format('Y-m');
                        if (array_key_exists($k, $months)) $months[$k]++;
                    }
                    $dataPoints = array_values($months);
                } else {
                    // fallback: use department counts (up to 6 largest)
                    arsort($departments);
                    $deptSlice = array_slice($departments, 0, 6, true);
                    foreach ($deptSlice as $d => $c) {
                        $labels[] = substr($d,0,8);
                        $dataPoints[] = $c;
                    }
                    // if empty, show total employees as single point
                    if (empty($dataPoints)) { $labels = ['Now']; $dataPoints = [$totalEmployees]; }
                }

                // normalize to SVG coords
                $w = 640; $h = 260; $padL = 40; $padR = 30; $padTop = 30; $padBottom = 30;
                $plotW = $w - $padL - $padR; $plotH = $h - $padTop - $padBottom;
                $count = count($dataPoints);
                $max = max(1, max($dataPoints));

                $points = [];
                for ($i = 0; $i < $count; $i++) {
                    $x = $padL + ($i / max(1, $count - 1)) * $plotW;
                    // invert y: larger value -> smaller y coordinate
                    $y = $padTop + ($plotH * (1 - ($dataPoints[$i] / $max)));
                    $points[] = ['x' => round($x,2), 'y' => round($y,2)];
                }

                // create paths
                $linePath = '';
                $areaPath = '';
                if (!empty($points)) {
                    $linePath = 'M' . $points[0]['x'] . ' ' . $points[0]['y'];
                    for ($i = 1; $i < count($points); $i++) {
                        // simple smooth curve using quadratic Bezier midpoint
                        $mx = ($points[$i-1]['x'] + $points[$i]['x'])/2;
                        $my = ($points[$i-1]['y'] + $points[$i]['y'])/2;
                        $linePath .= ' Q' . $points[$i-1]['x'] . ' ' . $points[$i-1]['y'] . ' ' . $mx . ' ' . $my;
                    }
                    // finish last segment to final point
                    $last = end($points);
                    $linePath .= ' T' . $last['x'] . ' ' . $last['y'];

                    // area path: from first point down to baseline, across to last point, back up
                    $areaPath = 'M' . $points[0]['x'] . ' ' . $points[0]['y'];
                    for ($i = 1; $i < count($points); $i++) {
                        $areaPath .= ' L' . $points[$i]['x'] . ' ' . $points[$i]['y'];
                    }
                    $areaPath .= ' L' . $last['x'] . ' ' . ($padTop + $plotH) . ' L' . $points[0]['x'] . ' ' . ($padTop + $plotH) . ' Z';
                }
                ?>
                <svg viewBox="0 0 640 260" role="img">
                    <defs>
                        <linearGradient id="growthFill" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="var(--primary)" stop-opacity=".28"/>
                            <stop offset="100%" stop-color="var(--primary)" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path class="chart-grid" d="M40 40H610M40 100H610M40 160H610M40 220H610"/>
                    <?php if ($areaPath): ?>
                        <path class="chart-area" d="<?php echo $areaPath; ?>" fill="url(#growthFill)" />
                    <?php endif; ?>
                    <?php if ($linePath): ?>
                        <path class="chart-line-main" d="<?php echo $linePath; ?>" fill="none" />
                    <?php endif; ?>
                    <?php foreach ($points as $p): ?>
                        <circle cx="<?php echo $p['x']; ?>" cy="<?php echo $p['y']; ?>" r="3" />
                    <?php endforeach; ?>
                </svg>
                <div class="chart-legend">
                    <?php foreach ($labels as $i => $lab): ?>
                        <span class="chart-legend-item"><?php echo htmlspecialchars($lab); ?> <strong><?php echo $dataPoints[$i] ?? 0; ?></strong></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Équipe</span>
                    <h3>Employés récents</h3>
                </div>
                <a class="text-link" href="?page=liste">Tout voir</a>
            </div>
            <div class="modern-table-wrap">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Salaire</th>
                            <th>Statut</th>
                            <th>Actions</th>
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
                    <span class="eyebrow">Raccourcis</span>
                    <h3>Actions rapides</h3>
                </div>
            </div>
            <a class="action-row" href="?page=insererEmploye">
                <span>+</span>
                <div><strong>Ajouter un employé</strong><small>Créer un nouveau profil</small></div>
            </a>
            <a class="action-row" href="?page=liste">
                <span>↓</span>
                <div><strong>Exporter les données</strong><small>Préparer les données équipe</small></div>
            </a>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Planification</span>
                    <h3>Tâches à venir</h3>
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
                    <span class="eyebrow">Activité</span>
                    <h3>Activité récente</h3>
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
