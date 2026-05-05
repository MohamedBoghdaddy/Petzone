<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../control/services/patient.service.php';

start_session();

$patientsService = PatientsController::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

$data = [
    'ID'      => isset($_POST['ID'])      ? (int)   $_POST['ID']                       : -1,
    'addedBy' => isset($_POST['addedBy']) ? trim(htmlspecialchars($_POST['addedBy']))   : ($_SESSION['Username'] ?? ''),
    'petname' => isset($_POST['petname']) ? trim(htmlspecialchars($_POST['petname']))   : '',
    'species' => isset($_POST['species']) ? trim(htmlspecialchars($_POST['species']))   : '',
    'breed'   => isset($_POST['breed'])   ? trim(htmlspecialchars($_POST['breed']))     : null,
    'gender'  => isset($_POST['gender'])  ? htmlspecialchars($_POST['gender'])          : 'Unknown',
    'age'     => isset($_POST['age'])     ? (int)   $_POST['age']                       : 0,
    'weight'  => isset($_POST['weight'])  ? (float) $_POST['weight']                   : 0.0,
    'color'   => isset($_POST['color'])   ? trim(htmlspecialchars($_POST['color']))     : null,
    'notes'   => isset($_POST['notes'])   ? trim(htmlspecialchars($_POST['notes']))     : null,
];

if (isset($_POST['addPatient']))    $patientsService->addNewPatient($data);
if (isset($_POST['editPatient']))   $patientsService->editPatient($data);
if (isset($_POST['deletePatient'])) $patientsService->deletePatient($data['ID']);
