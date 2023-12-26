<html>
<?php include "../pages/sidebar.php";?>
<head>
<link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include_once "../../control/functions/appointmentsFunctions.php"?> 
	<div>
        hi
    </div>
	<div>
        <?php
                echo"<ul class=\"responsive-table\" id=\"users\">";
                echo"<li class=\"table-header\">";
                echo"<div class=\"col\">ID</div>";
                echo"<div class=\"col\">Pet Owner</div>";
                echo"<div class=\"col\">Employee Name</div>";
                echo"<div class=\"col\">Pet Name</div>";
                echo"<div class=\"col\">Price</div>";
                echo"<div class=\"col\">Appointment Date</div>";
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
                            echo '</li>';
                }
               echo"</ul>";
                ?>
            
    	</div>
</body>
</html>