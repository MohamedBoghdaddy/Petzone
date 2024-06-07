<!DOCTYPE html>
<html lang="en">
<?php include "../pages/sidebar.php";?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href ="../style/style.css">

  <title>Edit Patient</title>
</head>
<body>
<div>
  hi
</div>
        <?php 
        include "../../control/functions/patientsFunctions.php";
        ?> 
        <div class ="container">
       
        <div class = "form-container">
          <h1>Edit patient</h1>
          <form action="" method="post">
            
          <div class="field input" hidden>
            <label for="addedBy">Added By</label>
            <input type ="text" name = "addedBy" id="addedBy"
                  value="<?php echo $_GET['Username']?>">
          </div>

          <div class="field input" hidden>
            <label for="ID">Added By</label>
            <input type ="text" name = "ID" id="ID"
                  value="<?php echo $_GET['ID']?>">
          </div>

           <div class="field input">
            <label for="petname">Pet Name</label>
            <input type ="text" name = "petname" id="petname" required value="<?php echo $_GET['petname']?>" minlength="2">
          </div>

          <div class="field input">
              <label for="species"> Species</label>
              <input type = "text" name = "species" id = "species" required value="<?php echo $_GET['species']?>" minlength="2">
           </div> 

           <div class="field input">
              <label for="age">Age </label>
              <input type="text" pattern="\d*" name = "age" id="age" required value="<?php echo $_GET['age']?>" minlength="1" maxlength="2">
           </div>

           <div class="field input">
            <label for="weight">Weight</label>
            <input type="text" pattern="\d*" name = "weight" id="weight" required value="<?php echo $_GET['weight']?>" minlength="1" maxlength="2">
          </div>
  
         <div class="field input">
          <input type ="submit" class="but" name = "editPatient" id="edit" value= "Edit" required>
          <input type ="submit" class="but" name = "deletePatient" id="delete" value= "Delete" required>
       </div>
       
          </form>
        </div>
      </div>


</body>
</html>