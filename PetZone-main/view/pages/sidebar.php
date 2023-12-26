<html>
<?php
    session_start();
    // if(empty($_SESSION['ID'])) {
    //     echo "<META http-equiv=\"refresh\" content=\"0;URL=../forms/login.php\"> ";
    // }
?>
<head>
<link rel="stylesheet" href="../style/sidebar.css">
</head>
<body>
    <nav class="menu" id="nav">  
        <div class="wrapper">
            <div class="logo">
                <a href='../pages/home.php'>
                    PET ZONE
                </a>
            </div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn">Close</i></label>
                <li>
                    <?php
                    if(!empty($_SESSION['ID']))
                    {
                        echo "<a href='../pages/userManagement.php'>Users Management</a>";
                    }
                    else
                    {
                        echo "<a href='../forms/login.php'>Users Management</a>";
                    }
                    ?>
                </li>
                <li>
                    <?php
                    if(!empty($_SESSION['ID']))
                    {
                        echo "<a href='../pages/patientsManagement.php'>Patients Management</a>";
                    }
                    else
                    {
                        echo "<a href='../forms/login.php'>Patients Management</a>";
                    }
                    ?>
                </li>
                <li>
                    <?php
                    if(!empty($_SESSION['ID']))
                    {
                        echo " <a href='../pages/AppointmentsManagement.php'>Appointments Management</a> ";
                    }
                    else
                    {
                        echo "<a href='../forms/login.php'>Appointments Management</a>";
                    }
                    ?>
                    
                </li>
                <li>
                    <?php
                    if(!empty($_SESSION['ID']))
                    {
                        echo " <a href='../pages/store.php'>Store</a> ";
                    }
                    else
                    {
                        echo " <a href='../pages/store.php'>Store</a> ";
                    }
                    ?>
                </li>
                <li>
                    <?php
                        echo " <a href='../pages/shop.php'>Shops</a> ";
                    ?>
                    
                </li>
                <li>
                    <?php
                    if(!empty($_SESSION['ID']))
                    {
                        echo " <a href='../pages/notifications.php'>Notifications</a> ";
                    }
                    else
                    {
                    }
                    ?>
                </li>
                <?php
                    if(!empty($_SESSION['ID']))
                    {
                        echo "<li>";
                        echo " <a href='../../control/functions/signout.php'>Signout</a>";
                        echo "</li>";
                    }
                    else
                    {
                        echo "<li>";
                        echo " <a href='../../view/forms/login.php'>Login</a>";
                        echo "</li>";
                        echo "<li>";
                        echo " <a href='../../view/forms/register.php'>Signup</a>";
                        echo "</li>";
                    }
                ?>
            </ul>
            <label for="menu-btn" class="btn menu-btn">MENU</label>
        </div>
    </nav>
</body>
</html>