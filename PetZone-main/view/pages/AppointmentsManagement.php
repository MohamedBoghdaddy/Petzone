<html>
<?php include "../pages/sidebar.php";?>
<head>
<link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include_once "../../control/functions/appointmentsFunctions.php"?> 

	<div>

        <div class="operations">
            <?php
                $Atypes = [];
                if ($_SESSION['accountType'] == "Client")
                {
                    echo '<div class = "singleOperation">';
                    echo '<h4>';
                    echo '<h4><a href=\'../forms/create-appointment.php\' class="my_a">Reserve</a></h4>';
                     echo '</h4>';
                    echo '</div>';
                }
            ?>
        </div>
        <?php
                echo"<ul class=\"responsive-table\" id=\"users\">";
                echo"<li class=\"table-header\">";
                echo"<div class=\"col\">ID</div>";
                echo"<div class=\"col\">Pet Owner</div>";
                echo"<div class=\"col\">Employee Name</div>";
                echo"<div class=\"col\">Pet Name</div>";
                echo"<div class=\"col\">Price</div>";
                echo"<div class=\"col\">Appointment Date</div>";
                echo"<div class=\"col\">Edit</div>";
                echo"</li>";
                $appointmentsService = AppointmentsController::getInstance();
                $_AllAppointments = $appointmentsService->getAppointments('all');
                $_EmployeeAppointments = $appointmentsService->getAppointments('employee');
                $_ClientAppointments = $appointmentsService->getAppointments('client');

                $arr;
                if($_SESSION['accountType'] == "Admin")
                {
                    $arr = $_AllAppointments;
                }
                elseif($_SESSION['accountType'] == "Employee")
                {
                    $arr = $_EmployeeAppointments;
                }
                else
                {
                    $arr = $_ClientAppointments;
                }

                foreach($arr as $p){
                    echo '<li class="table-row">';

                            echo '<div class="col">';
                            echo $p['ID'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['petOwner'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['EmployeeName'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['petname'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['price'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo $p['aDate'];
                            echo '</div>';

                            echo '<div class="col">';
                            echo '<input type ="button" class="but" name = "editOtherUser" 
                            value="Edit" onclick="editAppointment(\''.$p['ID'].'\',\''.$p['petOwner'].
                            '\',\''.$p['EmployeeName']
                            .'\',\''.$p['petname'].'\',\''.$p['price'].'\',\''.$p['aDate'].'\')">';
                            echo '</div>';
                            echo '</li>';

                                               
                }
               echo"</ul>";
                ?>
            
    	</div>
</body>
<script>
   function editAppointment(ID, petOwner,EmployeeName,petname,price,aDate) {
        window.open(
            "../forms/edit-appointment.php?ID="+encodeURI(ID)+"&petOwner="+encodeURI(petOwner)
            +"&EmployeeName="+encodeURI(EmployeeName)+"&petname="+encodeURI(petname)+"&price="+encodeURI(price)
            +"&aDate="+encodeURI(aDate),
            "_self");
    }
</script>
</html>