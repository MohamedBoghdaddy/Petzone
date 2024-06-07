<html>
<?php include "../pages/sidebar.php";?>
<head>
<link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php 
        include "../../control/functions/patientsFunctions.php";
    ?> 

	<div>

        <div class="operations">
        <?php
                $Atypes = [];
                if ($_SESSION['accountType'] == "Client")
                {
                    echo '<div class = "singleOperation">';
                    echo '<h4>';
                    echo '<h4><a href=\'../forms/create-patient.php\' class="my_a">Add New Patient</a></h4>';
                    echo '</h4>';
                    echo '</div>';
                }
            ?>
        </div>
        <?php
                echo"<ul class=\"responsive-table\" id=\"users\">";
                echo"<li class=\"table-header\">";
                echo"<div class=\"col\">ID</div>";
                echo"<div class=\"col\">Added By</div>";
                echo"<div class=\"col\">Pet Name</div>";
                echo"<div class=\"col\">Species</div>";
                echo"<div class=\"col\">Age</div>";
                echo"<div class=\"col\">Weight</div>";
                echo"<div class=\"col\">Edit</div>";
                echo"</li>";
                $patientsService = PatientsController::getInstance();
                $_AllPatients = $patientsService->getPatients('all');
                $_MyPatients = $patientsService->getPatients("my");
                $arr;
                if($_SESSION['accountType'] == "Admin")
                {
                    $arr = $_AllPatients;
                }
                else
                {
                    $arr = $_MyPatients;
                }

                foreach($arr as $p){
                    echo '<li class="table-row">';

                            echo '<div class="col">';
                            echo $p['ID'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['addedBy'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['petname'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['species'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['age'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['weight'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo '<input type ="button" class="but" name = "editOtherUser" 
                            value="Edit" onclick="editPatient(\''.$p['ID'].'\',\''.$p['addedBy'].'\',\''.$p['petname']
                            .'\',\''.$p['species'].'\',\''.$p['age'].'\',\''.$p['weight'].'\')">';
                            echo '</td>';
                            echo '</li>';

                                               
                }
               echo"</ul>";
                ?>
            
    	</div>
</body>
<script>
   function editPatient(ID, addedBy,petname,species,age,weight) {
        window.open(
            "../forms/edit-patient.php?ID="+encodeURI(ID)+"&addedBy="+encodeURI(addedBy)
            +"&petname="+encodeURI(petname)+"&species="+encodeURI(species)+"&age="+encodeURI(age)
            +"&weight="+encodeURI(weight),
            "_self");
    }
</script>
</html>