<?php
include_once 'config/Database.php';
include_once 'class/Patient.php';

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listPatient') {
	$patient->listPatients();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getPatient') {
	$patient->id = $_POST["id"];
	$patient->getPatient();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addPatient') {	
	$patient->name = $_POST["name"];
    $patient->gender = $_POST["gender"];
    $patient->age = $_POST["age"];
	$patient->email = $_POST["email"];	
	$patient->mobile = $_POST["mobile"];
	$patient->address = $_POST["address"];
	$patient->medical_history = $_POST["history"];
	$patient->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updatePatient') {
	$patient->id = $_POST["id"];
	$patient->name = $_POST["name"];
    $patient->gender = $_POST["gender"];
    $patient->age = $_POST["age"];
	$patient->email = $_POST["email"];	
	$patient->mobile = $_POST["mobile"];
	$patient->address = $_POST["address"];
	$patient->medical_history = $_POST["history"];
	$patient->update();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deletePatient') {
	$patient->id = $_POST["id"];
	$patient->delete();
}
?>