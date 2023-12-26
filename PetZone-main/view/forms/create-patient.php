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
        include "../../control/functions/patientsFunctions.php";
        ?> 
        <div class ="container">
       
        <div class = "form-container">
          <h1>Add a patient</h1>
          <form action="" method="post">
            
          <div class="field input" hidden>
            <label for="addedBy">Added By</label>
            <input type ="addedBy" name = "addedBy" id="addedBy" 
                  value="<?php echo $_SESSION['Username']?>">
          </div>

           <div class="field input">
            <label for="petname">Name</label>
            <input type ="text" name = "petname" id="petname" required minlength="2">
          </div>

          <div class="field input">
              <label for="species"> Species</label>
              <input type = "text" name = "species" id = "species" required minlength="2">
           </div> 

           <div class="field input">
              <label for="age">Age </label>
              <input type="text" pattern="\d*"  name = "age" id="age" required minlength="1" maxlength="2">
           </div>

           <div class="field input">
            <label for="weight">Weight</label>
            <input type="text" pattern="\d*" name = "weight" id="weight" required minlength="1" maxlength="2">
          </div>
  
         <div class="field input">
          <input type ="submit" class="but" name = "addPatient" value= "Submit" required>
       </div>
       
          </form>
        </div>
      </div>


</body>
</html>