<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();
include_once "../../dbh.inc.php";
include_once "../../control/services/appointment.service.php";

$appointmentsService = AppointmentsController::getInstance();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(isset($_POST['ID'])){$ID = htmlspecialchars($_POST['ID']);}else{$ID = "-1";}
    if(isset($_POST['petOwner'])){$petOwner = htmlspecialchars($_POST['petOwner']);}else{$petOwner = "";}
    if(isset($_POST['EmployeeName'])){$EmployeeName = htmlspecialchars($_POST['EmployeeName']);}else{$EmployeeName = "";}
    if(isset($_POST['petname'])){$petname = htmlspecialchars($_POST['petname']);}else{$petname = "";}
    if(isset($_POST['aDate'])){$aDate = htmlspecialchars($_POST['aDate']);}else{$aDate = "";}
    if(isset($_POST['price'])){$price = htmlspecialchars($_POST['price']);}else{$price = "";}
    
    $appointment = new Appointment($ID,$petOwner,$EmployeeName,$petname,$aDate,$price);

    if (isset($_POST['addAppointment']))
    {
        $appointmentsService->addNewAppointment($appointment);
    }
    if (isset($_POST['editAppointment']))
    {
        $appointmentsService->editAppointment($appointment);
    }
    if (isset($_POST['deleteAppointment']))
    {
        $appointmentsService->deleteAppointment($appointment);
    }
}
?>