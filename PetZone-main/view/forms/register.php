<!DOCTYPE html>
<html lang="en">
<?php include "../pages/sidebar.php";?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href ="../style/style.css">
  <title>Add New User</title>

  
<body>

<?php include_once "../../control/functions/usersFunctions.php";?>
<div>
  hi
</div>
<div class ="container">
        <div class = "form-container" style="margin-top: 40px">
          <h1>User Register</h1>
          <form action="" method="post">

          <div class="field input">
            <label for="first name">First name</label>
            <input type ="text" name = "firstname" id="first name" required minlength="2">
          </div>

          <div class="field input">
            <label for="Last name">Last name</label>
            <input type ="text" name = "lastname" id="Last name" required minlength="2">
          </div>

          <div class="field input">
            <label for=" Username">Username</label>
            <input type ="text" name = "Username" id="Username" required minlength="8">
          </div>
          
          <div class="field input">
            <label for="Email">Email</label>
            <input type ="email" name = "Email" id="Email" required>
         </div>

            <div class="field input">
              <label for="password"> Password  </label>
              <input type="Password" name="password" id="password" placeholder="Password" pattern=".{8,16}" title="8 or more Character" size=30 pattern="[!@#$%^&*][a-z][A-Z][0-9]" required>
            </div>
          
           <div class="field input">
              <label for="accountType">Account Type </label>
              <select name = "accountType" id="accountType" required>
                <?php
                    $Atypes = [];
                    if ($_SESSION['accountType'] == "Admin")
                    {
                      $Atypes = ['Admin', 'Employee', 'Client'];
                    }
                    elseif ($_SESSION['accountType'] == "Employee")
                    {
                      $Atypes = ['Employee', 'Client'];
                    }
                    else
                    {
                      $Atypes = ['Client'];
                    }
                    
                    foreach($Atypes as $item){
                      echo '<option value="' . $item . '">' . $item . '</option>';
                    }                  
                ?>
              </select>
              
           </div>

          <input type ="submit"class="but" name = "addUser" value="Add" required>
          </form>
        </div>
      </div>
</body>
</html>