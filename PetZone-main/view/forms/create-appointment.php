<!DOCTYPE html>
<html lang="en">
<?php include "../pages/sidebar.php";?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href ="../style/style.css">

  <title>Create Patient</title>
</head>
<body>
<div>
  hi
</div>
        <?php 
        include "../../control/functions/appointmentsFunctions.php";
        include "../../control/functions/patientsFunctions.php";
        include_once "../../control/functions/usersFunctions.php";
        ?> 
        <div class ="container">
       
        <div class = "form-container">
          <h1>Reserve</h1>
          <form action="" method="post">
            
          <div class="field input" hidden>
            <label for="petOwner">petOwner</label>
            <input type ="petOwner" name = "petOwner" id="petOwner" placeholder="Pet Owner"
                  value="<?php echo $_SESSION['Username']?>">
          </div>

           <div class="field input">
            <label for="petname">Choose one of your pets</label>
            <select name = "petname" id="petname" required>
              <?php
                $patientsService = PatientsController::getInstance();
                $_MyPatients = $patientsService->getPatients("my");
                foreach($_MyPatients as $p){
                  echo"<option value='". $p['petname'] ."'>". $p['petname'] ."</option>";
                }
              ?>
            </select>
          </div>
          <div class="field input">
            <label for="EmployeeName">Choose an employee</label>
            <select name = "EmployeeName" id="EmployeeName" required>
              <?php
                $usersService = UsersController::getInstance();
                $_AllAcountsE = $usersService->getUsers('employee');
                foreach($_AllAcountsE as $p){
                  echo"<option value='". $p['Username'] ."'>". $p['Username'] ."</option>";
                }
              ?>
            </select>
          </div>

          <div class="field input">
              <label for="aDate"> Appointment Date</label>
              <input type = "date" name = "aDate" id = "aDate" min="<?= date('Y-m-d'); ?>" required>
           </div> 

           <div class="field input">
              <label for="price">Appointment Type and Price </label>
              <select name = "price" id="price" required>
                <option value="100">Public health 100EGP</option>
                <option value="150">Regulatory medicines 150EGP</option>
                <option value="300">Small animals 300EGP</option>
                <option value="350">Bones 350EGP</option>
              </select>
           </div>
  
         <div class="field input">
          <input type ="submit" class="but" name = "addAppointment" value= "Submit" required>
       </div>
       
          </form>
        </div>
      </div>


</body>
</html>