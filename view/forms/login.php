<!DOCTYPE html>
<html lang="en">
<?php include "../pages/sidebar.php";?>

<?php
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    // if(!empty($_SESSION['ID'])) {
    //     echo "<META http-equiv=\"refresh\" content=\"0;URL=../pages/home.php\"> ";
    // }
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href ="../style/style.css">
  <title>Login</title>
</head>
<body>
<div>
  hi
</div>
      <?php include_once "../../control/functions/usersFunctions.php"?>
      <div class ="container">
        <div class="form-container">
          <h1>Login</h1>
          <form action="" method="post">
           <div class="field input">
            <label for=" Username">Username</label>
            <input type ="text" name = "Username" id="Username" required>
          </div>

            <div class="field input">
              <label for="password">Password</label>
              <input type ="password" name = "password" id="password" required>
           </div>         

          <input class="but" type ="submit" name = "login" value="Login" required>
          </form>
        </div>
      </div>
</body>
</html>

















