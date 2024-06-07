
<!DOCTYPE html>
<html lang="en">
<?php include "../pages/sidebar.php";?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href ="../style/style.css">
  <title>Profile</title>

  
<body>

<?php 
include_once "../../control/functions/usersFunctions.php";
?>
<div>
  hi
</div>
<div class ="container">
        <div class = "form-container">
          <h1>Profile</h1>
          

          <form action="" method="post">

          <div class="field input">
            <label for="first name">First name</label>
            <input type ="text" name = "firstname" value="<?php echo $_SESSION['firstname']?>" id="first name" required minlength="2">
          </div>

          <div class="field input">
            <label for="Last name">Last name</label>
            <input type ="text" name = "lastname" value="<?php echo $_SESSION['lastname']?>" id="Last name" required minlength="2">
          </div>
          
          <div class="field input" hidden>
            <label for=" Username">Username</label>
            <input type ="text" name = "Username" id="Username" value="<?php echo $_SESSION['Username']?>" required>
          </div>

          <div class="field input">
            <label for="Email">Email</label>
            <input type ="email" name = "Email" value="<?php echo $_SESSION['Email']?>" id="Email" required>
         </div>

            <div class="field input">
              <label for="password"> Password  </label>
              <input type="Password" name="password" id="password" placeholder="Password" value="<?php echo $_SESSION['password']?>" pattern=".{8,16}" title="8 or more Character" size=30 pattern="[!@#$%^&*][a-z][A-Z][0-9]" required>

           </div>

          <input type ="submit" class="but" name = "edituser" value="Update" required>
          <input type ="submit" class="but" name = "deleteuser" value="Delete" required>
      
          </form>
       
        </div>
      </div>
</body>
</html>