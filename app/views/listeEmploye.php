<?php require __DIR__ . '/header.php'; ?>
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
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Poste</th>
                    <th>Département</th>
                    <th>Salaire</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($data)){
                    foreach($data as $employe){  
                        echo'<tr class="employee-row"> 
                        <td>'.$employe['id'].'</td>
                        <td>'.$employe['nom'].'</td>
                        <td>'.$employe['poste'].'</td>
                        <td>'.$employe['departement'].'</td>
                        <td>$'.$employe['salaire'].'</td>
                        <td>'.$employe['email'].'</td>
                        <td class="action-cell">'
                        .'<a class="icon-btn icon-edit" href="?page=edit&id='.$employe['id'].'" title="Modifier">✎</a>'
                        .'<a class="icon-btn icon-delete" href="?page=delete&id='.$employe['id'].'" onclick="return confirm(\'Êtes-vous sûr?\')" title="Supprimer">🗑</a>'
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
