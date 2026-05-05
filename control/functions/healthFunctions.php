<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../control/services/health.service.php';

start_session();

$healthService = HealthController::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

$data = [
    'pet_id'          => isset($_POST['pet_id'])          ? (int) $_POST['pet_id']                                : 0,
    'petname'         => isset($_POST['petname'])         ? trim(htmlspecialchars($_POST['petname']))             : '',
    'addedBy'         => $_SESSION['Username'] ?? '',
    'record_type'     => isset($_POST['record_type'])     ? htmlspecialchars($_POST['record_type'])               : 'Other',
    'title'           => isset($_POST['title'])           ? trim(htmlspecialchars($_POST['title']))               : '',
    'description'     => isset($_POST['description'])     ? trim(htmlspecialchars($_POST['description']))         : null,
    'vet_name'        => isset($_POST['vet_name'])        ? trim(htmlspecialchars($_POST['vet_name']))            : null,
    'visit_date'      => isset($_POST['visit_date'])      ? $_POST['visit_date']                                  : '',
    'next_visit_date' => isset($_POST['next_visit_date']) ? $_POST['next_visit_date']                             : null,
    'ID'              => isset($_POST['ID'])              ? (int) $_POST['ID']                                    : -1,
];

if (isset($_POST['addRecord']))    $healthService->addRecord($data);
if (isset($_POST['deleteRecord'])) $healthService->deleteRecord($data['ID']);
