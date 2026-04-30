<?php
class EmployeController extends Controller{
    public function displayDashboard(){
        $employe = new Employe();
        $data = $employe->getAllEmployee();

        $this->view("dashboard", $data);
    }

    public function displayEmploye(){
        $employe = new Employe();
        $data['employes'] = $employe->getAllEmployee();

        $this->view("listeEmploye", $data['employes']);
    }

    public function displayAddEmploye(){
        $this->view("addEmploye");
    }

    public function insertEmploye(){
        $nom = $_POST["nom"];
        $poste = $_POST["poste"];
        $salaire= $_POST["salaire"];
        $departement = $_POST["departement"];
        $email = $_POST["email"];
        $employe = new Employe();
        $employe->addEmployee($nom, $poste, $salaire, $departement, $email);

        header("Location: ?page=liste");
    }

    public function displayEditEmploye() {
        $id = $_GET["id"];
        $employe = new Employe();
        $data = $employe->getEmployeeById($id);
        $this->view("edit", $data);
    }

    public function updateEmploye() {
        $id=$_POST["id"];
        $nom = $_POST["nom"];
        $poste = $_POST["poste"];
        $salaire= $_POST["salaire"];
        $departement = $_POST["departement"];
        $email = $_POST["email"];
        $employe = new Employe();
        $employe->updateEmployee($id, $nom, $poste, $salaire, $departement, $email);

        header("Location: ?page=liste");
    }

    public function deleteEmploye() {
        $id = $_GET["id"];
        $employe = new Employe();
        $employe->deleteEmployee($id);

        header("Location: ?page=liste");
    }
}