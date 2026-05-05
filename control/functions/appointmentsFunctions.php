<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../control/services/appointment.service.php';

start_session();

$appointmentsService = AppointmentsController::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

$data = [
    'ID'           => isset($_POST['ID'])           ? (int)   $_POST['ID']                             : -1,
    'petOwner'     => isset($_POST['petOwner'])     ? trim(htmlspecialchars($_POST['petOwner']))       : ($_SESSION['Username'] ?? ''),
    'EmployeeName' => isset($_POST['EmployeeName']) ? trim(htmlspecialchars($_POST['EmployeeName']))   : '',
    'petname'      => isset($_POST['petname'])      ? trim(htmlspecialchars($_POST['petname']))        : '',
    'service_type' => isset($_POST['service_type']) ? trim(htmlspecialchars($_POST['service_type']))   : null,
    'aDate'        => isset($_POST['aDate'])        ? $_POST['aDate']                                  : '',
    'price'        => isset($_POST['price'])        ? (float) $_POST['price']                          : 0.0,
    'status'       => isset($_POST['status'])       ? htmlspecialchars($_POST['status'])               : 'Pending',
    'notes'        => isset($_POST['notes'])        ? trim(htmlspecialchars($_POST['notes']))           : null,
];

if (isset($_POST['addAppointment']))    $appointmentsService->addNewAppointment($data);
if (isset($_POST['editAppointment']))   $appointmentsService->editAppointment($data);
if (isset($_POST['deleteAppointment'])) $appointmentsService->deleteAppointment($data['ID']);
if (isset($_POST['updateStatus']))      $appointmentsService->updateStatus($data['ID'], $data['status']);
