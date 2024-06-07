<html>
<head>
<title>Home</title>
<link rel="stylesheet" href="../style/style.css">
</head>
<body>
	<h1>Welcome <?php session_status() === PHP_SESSION_ACTIVE ?: session_start();?></h1>
	<META http-equiv="refresh" content="0;URL=../forms/login.php"> 
	<!-- <a href='../forms/login.php'>Login</a>
	<br>
	<br><a href='../forms/register.php'>Signup</a> -->
</body>
</html>