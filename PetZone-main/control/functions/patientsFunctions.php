<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();
include_once "../../dbh.inc.php";
include_once "../../control/services/patient.service.php";

$patientsService = PatientsController::getInstance();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(isset($_POST['ID'])){$ID = htmlspecialchars($_POST['ID']);}else{$ID = "-1";}
    if(isset($_POST['petname'])){$petname = htmlspecialchars($_POST['petname']);}else{$petname = "";}
    if(isset($_POST['addedBy'])){$addedBy = htmlspecialchars($_POST['addedBy']);}else{$addedBy = "";}
    if(isset($_POST['species'])){$species = htmlspecialchars($_POST['species']);}else{$species = "";}
    if(isset($_POST['age'])){$age = htmlspecialchars($_POST['age']);}else{$age = "";}
    if(isset($_POST['weight'])){$weight = htmlspecialchars($_POST['weight']);}else{$weight = "";}

    $patient = new Patient($ID,$addedBy,$petname,$species,$age,$weight);

    if (isset($_POST['addPatient']))
    {
        $patientsService->addNewPatient($patient);
    }
    if (isset($_POST['editPatient']))
    {
        $patientsService->editPatient($patient);
    }
    if (isset($_POST['deletePatient']))
    {        
        $patientsService->deletePatient($patient);
    }
}
?>