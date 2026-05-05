<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../control/services/user.service.php';

start_session();

$usersService = UsersController::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

$allowed_types = ['Admin', 'Employee', 'Client'];

$data = [
    'ID'          => isset($_POST['ID'])          ? (int)   $_POST['ID']                : -1,
    'firstname'   => isset($_POST['firstname'])   ? trim(htmlspecialchars($_POST['firstname']))   : '',
    'lastname'    => isset($_POST['lastname'])     ? trim(htmlspecialchars($_POST['lastname']))     : '',
    'Username'    => isset($_POST['Username'])     ? trim(htmlspecialchars($_POST['Username']))     : '',
    'Email'       => isset($_POST['Email'])        ? trim(filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL)) : '',
    'password'    => isset($_POST['password'])     ? $_POST['password']                 : '',
    'accountType' => isset($_POST['accountType']) && in_array($_POST['accountType'], $allowed_types)
                        ? $_POST['accountType'] : 'Client',
];

if (isset($_POST['addUser']))         $usersService->addNewUser($data);
if (isset($_POST['login']))           $usersService->login($data);
if (isset($_POST['edituser']))        $usersService->editMyUser($data);
if (isset($_POST['editOtherUser']))   $usersService->editUser($data);
if (isset($_POST['deleteuser']))      $usersService->deleteMyUser();
if (isset($_POST['deleteOtherUser'])) $usersService->deleteUser($data);
