<!DOCTYPE html>
<html lang="en">
<?php include "../pages/sidebar.php";?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href ="../style/style.css">

  <title>Edit Appointment</title>
</head>
<body>
<div>
  hi
</div>
        <?php 
          include "../../control/functions/appointmentsFunctions.php";
        ?> 
        <div class ="container">
       
        <div class = "form-container">
          <h1>Edit Appointment</h1>
          <form action="" method="post">

          <div class="field input" hidden>
            <label for="ID"></label>
            <input type ="text" name = "ID" id="ID"
                  value="<?php echo $_GET['ID']?>">
          </div>

          <div class="field input">
              <label for="aDate"> Appointment Date</label>
              <input type = "date" name = "aDate" id = "aDate" min="<?= date('Y-m-d'); ?>" required value="<?php echo $_GET['aDate']?>">
           </div>
  
         <div class="field input">
          <input type ="submit" class="but" name = "editAppointment" id="edit" value= "Edit" required>
          <input type ="submit" class="but" name = "deleteAppointment" id="delete" value= "Delete" required>
       </div>
       
          </form>
        </div>
      </div>


</body>
</html>