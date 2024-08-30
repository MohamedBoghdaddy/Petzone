<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();
include_once "../../dbh.inc.php";
include_once "../../control/services/user.service.php";

$usersService = UsersController::getInstance();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
  if(isset($_POST['ID'])){$ID = htmlspecialchars($_POST['ID']);}else{$ID = "-1";}
  if(isset($_POST['firstname'])){$firstname = htmlspecialchars($_POST['firstname']);}else{$firstname = "";}
  if(isset($_POST['lastname'])){$lastname = htmlspecialchars($_POST['lastname']);}else{$lastname = "";}
  if(isset($_POST['Username'])){$Username = htmlspecialchars($_POST['Username']);}else{$Username = "";}
  if(isset($_POST['Email'])){$Email = htmlspecialchars($_POST['Email']);}else{$Email = "";}
  if(isset($_POST['password'])){$password = htmlspecialchars($_POST['password']);}else{$password = "";}
  if(isset($_POST['accountType'])){$accountType = htmlspecialchars($_POST['accountType']);}else{$accountType = "";}
  
  $user = new User($ID,$firstname,$lastname,$Username,$Email,$password,$accountType);

  if (isset($_POST['addUser']))
  {
    $usersService->addNewUser($user);
  }
  if(isset($_POST['login']))
  {
    $usersService->login($user); 
  }
  if (isset($_POST['edituser'])) 
  {
    $usersService->editMyUser($user);
  }
  if (isset($_POST['editOtherUser'])) {
    $usersService->editUser($user);
  }
  if (isset($_POST['deleteuser'])) 
  {
    $usersService->deleteMyUser($user);    
  }
  if (isset($_POST['deleteOtherUser'])) 
  {
    $usersService->deleteUser($user);    
  }
}
?>