<?php

include_once 'config/Database.php';
include_once 'class/Doctor.php';

$database = new Database();
$db = $database->getConnection();

$doctor = new Doctor($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listDoctors') {
	$doctor->listDoctors();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getDoctor') {
	$doctor->id = $_POST["id"];
	$doctor->getDoctor();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addDoctor') {	
	$doctor->name = $_POST["name"];
    $doctor->fee = $_POST["fee"];
    $doctor->specialization = $_POST["specialization"];
	$doctor->mobile = $_POST["mobile"];
	$doctor->address = $_POST["address"];
	$doctor->email = $_POST["email"];	
	$doctor->insert();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateDoctor') {
	$doctor->id = $_POST["id"];
	$doctor->name = $_POST["name"];
    $doctor->fee = $_POST["fee"];
    $doctor->specialization = $_POST["specialization"];
	$doctor->mobile = $_POST["mobile"];
	$doctor->address = $_POST["address"];
	$doctor->email = $_POST["email"];	
	$doctor->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteDoctor') {
	$doctor->id = $_POST["id"];
	$doctor->delete();
}
?>