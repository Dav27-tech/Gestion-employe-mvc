<?php
include "../core/Controller.php";
include "../core/Model.php";
include "../app/controllers/EmployeController.php";
include "../app/models/Employe.php";

$employe = new EmployeController();

$page = $_GET['page'] ?? 'dashboard';
if($page == "insererEmploye"){
    $employe->displayAddEmploye();
} elseif($page == "liste"){
    $employe->displayEmploye();
} elseif($page == "insert"){
    $employe->insertEmploye();
} elseif($page == "edit"){
    $employe->displayEditEmploye();
} elseif($page == "update"){
    $employe->updateEmploye();
} elseif($page == "delete"){
    $employe->deleteEmploye();
} elseif($page == "dashboard"){
    $employe->displayDashboard();
} else {
    $employe->displayDashboard();
}
