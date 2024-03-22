<?php

include_once 'config/Database.php';
include_once 'class/Specialization.php';

$database = new Database();
$db = $database->getConnection();

$specialization = new Specialization($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listSpecialization') {
	$specialization->listSpecialization();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getSpecializationDetails') {
	$specialization->id = $_POST["id"];
	$specialization->getSpecializationDetails();
}

if(!empty($_POST['action']) && $_POST['action'] == 'createSpecialization') {
	$specialization->specialization = $_POST["specialization"];	
	$specialization->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateSpecialization') {
	$specialization->id = $_POST["id"];
	$specialization->specialization = $_POST["specialization"];	
	$specialization->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteSpecialization') {
	$specialization->id = $_POST["id"];
	$specialization->delete();
}

?>