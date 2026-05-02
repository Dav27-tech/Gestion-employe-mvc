<?php require __DIR__ . '/header.php'; ?>
<?php $esc = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); ?>
<section class="table-card">
    <h2>Liste des employés</h2>
    <div class="table-toolbar">
        <div class="search-field">
            <input id="employeeSearch" type="search" placeholder="Rechercher un employé..." aria-label="Rechercher un employé">
        </div>
        <a href="?page=insererEmploye" class="btn btn-primary">Ajouter</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Poste</th>
                    <th>Sexe</th>
                    <th>Département</th>
                    <th>Salaire</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($data)){
                    foreach($data as $employe){  
                        $id = $esc($employe['id'] ?? '');
                        echo'<tr class="employee-row"> 
                        <td>'.$esc($employe['nom'] ?? '').'</td>
                        <td>'.$esc($employe['poste'] ?? '').'</td>
                        <td>'.$esc($employe['sexe'] ?? '').'</td>
                        <td>'.$esc($employe['departement'] ?? '').'</td>
                        <td>$'.$esc($employe['salaire'] ?? '').'</td>
                        <td>'.$esc($employe['email'] ?? '').'</td>
                        <td class="action-cell">'
                        .'<a class="icon-btn icon-edit" href="?page=edit&id='.$id.'" title="Modifier">✎</a>'
                        .'<form class="delete-form" method="POST" onsubmit="return confirm(\'Êtes-vous sûr?\')">'
                        .'<input type="hidden" name="page" value="delete">'
                        .'<input type="hidden" name="id" value="'.$id.'">'
                        .'<button class="icon-btn icon-delete" type="submit" title="Supprimer">🗑</button>'
                        .'</form>'
                        .'</td>
                        </tr>';
                    }
                    echo'<tr id="noSearchResult" class="empty-row" hidden><td colspan="7">Aucun employé ne correspond à votre recherche.</td></tr>';
                }else{
                    echo'<tr class="empty-row"><td colspan="7">Aucun employé!</td></tr>';    
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
