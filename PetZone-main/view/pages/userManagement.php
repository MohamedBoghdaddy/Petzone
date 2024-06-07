<html>
<?php include "../pages/sidebar.php";?>
<head>
<link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php 
    include_once "../../control/functions/usersFunctions.php";
    ?> 
	<div>

        <div class="operations">
            <div class = "singleOperation">
                <h4><a href='../forms/profile.php' class="my_a">Edit My User</a></h4>
            </div>
            <?php
                $Atypes = [];
                if ($_SESSION['accountType'] != "Client")
                {
                    echo '<div class = "singleOperation">';
                    echo '<h4>';
                    echo '<a href=\'../forms/register.php\' class="my_a">Add New User</a>';
                     echo '</h4>';
                    echo '</div>';
                }
            ?>
        </div>
        <?php
                if ($_SESSION['accountType'] != "Client")
                {
                    echo"<ul class=\"responsive-table\" id=\"users\">";
                    echo"<li class=\"table-header\">";
                        echo"<div class=\"col\">ID</div>";
                        echo"<div class=\"col\">First Name</div>";
                        echo"<div class=\"col\">Last Name</div>";
                        echo"<div class=\"col\">Username</div>";
                        echo"<div class=\"col\">Email</div>";
                        echo"<div class=\"col\">Account Type</div>";
                        echo"<div class=\"col\">Edit</div>";
                    echo"</li>";
                    $usersService = UsersController::getInstance();
                    $_AllAcountsEC = $usersService->getUsers('employee_client');
                    $_AllAcountsC = $usersService->getUsers('client');
                    $arr;
                    if ($_SESSION['accountType'] != "Client")
                    {
                        $arr = $_AllAcountsEC;           
                    }
                    else
                    {
                        $arr = $_AllAcountsC;           
                    }
                    foreach($arr as $u){
                        echo '<li class="table-row">';

                        echo '<div class="col">';
                        echo $u['ID'];
                        echo '</div>';

                        echo '<div class="col">';
                        echo $u['firstname'];
                        echo '</div>';

                        echo '<div class="col">';
                        echo $u['lastname'];
                        echo '</div>';

                        echo '<div class="col">';
                        echo $u['Username'];
                        echo '</div>';

                        echo '<div class="col">';
                        echo $u['Email'];
                        echo '</div>';

                        echo '<div class="col">';
                        echo $u['accountType'];
                        echo '</div>';

                        echo '<div class="col" hidden>';
                        echo $u['password'];
                        echo '</div>';

                        echo '<div class="col">';
                        echo '<input type ="button" class="but" name = "editOtherUser" 
                        value="Edit" onclick="editUser(\''.$u['ID'].'\',\''.$u['firstname'].'\',\''.$u['lastname']
                        .'\',\''.$u['Username'].'\',\''.$u['Email'].'\',\''.$u['password'].
                        '\',\'' .$u['accountType'] .'\')">';
                        echo '</td>';
                        echo '</div>';
                    }                       
                }
                echo"</ul>";
        ?>
	</div>
</body>
<script>
   function editUser(ID, firstname,lastname,Username,Email,password,accountType) {
        window.open(
            "../forms/editOtherUser.php?ID="+encodeURI(ID)+"&firstname="+encodeURI(firstname)
            +"&lastname="+encodeURI(lastname)+"&Username="+encodeURI(Username)+"&password="+encodeURI(password)
            +"&Email="+encodeURI(Email)+"&accountType="+encodeURI(accountType),
            "_self");
    }
</script>
</html>