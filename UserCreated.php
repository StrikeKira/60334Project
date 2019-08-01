<html>
<head>
<title>Gotham City Libary System</title>
<link href='http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href="../css/main.css" rel="stylesheet">
<link href="responsive_solution.css" rel="stylesheet" media="screen and (max-width: 960px)"> 
</head>
<body>
<div class="wrapper">
	<header><h1>Gotham City Libary System<h1></header>
	<nav>
		<ul>
		 <li><a class="nav-link" href="main.html">Main</a></li>
		 <li class="nav-item"><a class="nav-link" href="search.php">Search for Book</a></li>
		 <li class="nav-item"><a class="nav-link" href="UserLookup.php">Lookup User Information</a></li>
		 <li class="nav-item"><a class="nav-link" href="CreateUser.php">Create User</a></li>
		 <li class="nav-item"><a class="nav-link" href="admin.php">Admin Page</a></li>
		</ul>
	</nav>
	</div>
		<br>
		<h2>Gotham City Libary User Creation Page</h2>
<?php
	require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);
	
	$Username = $_POST['Username'];
	$Password = $_POST['Password'];
	$Role = $_POST['Usertype'];
	
	
	
	$query = "SELECT * FROM User_Table WHERE Username='$Username'";
	$result = $conn->query($query);
	$rows = $result->num_rows;
	
	if($Password==""){
		echo "TEST";
	}
		
	if($rows == 0){
		if($Password==""){
			echo 'User account creation was succsessful!';
			$query = "INSERT INTO User_Table VALUES" .
			"('$Username', 'pass123', '$Role',0)";
			$result = $conn->query($query);		
		}else{
			echo 'User account creation was succsessful!';
			$query = "INSERT INTO User_Table VALUES" .
			"('$Username', '$Password', '$Role',0)";
			$result = $conn->query($query);
		}
	}else{
		echo "<p>Username has been taken. Please try another Username</p>";
	echo <<<_END
	<form action="UserCreated.php" method="post"><pre>
		User Name: <input type="text" name="Username">
		Password: <input type="password" name="Password">
		Role: <select name="Usertype">
			<option value="Student">Student</option>
			<option value="Teacher">Teacher</option>
		<input type="submit" value"submit">
	</form></pre>
_END;
	}
	
	$result->close();
    $conn->close();

	
?>
</body>
</html>