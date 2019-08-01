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
		<h2>Gotham City Libary Rent Page</h2>

<?php

	require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);
	
	$ISBN = $_POST['ISBN'];

	$query = "SELECT * FROM Book_Table WHERE ISBN LIKE '$ISBN'";
	$result =  $conn->query($query);
	$row = $result->fetch_array(MYSQLI_NUM);
	
	
	$Title = $row[0];
	$Auther = $row[1];
	$Genre = $row[2];
	$Year = $row[3];
	$ReturnDate = date("Y-m-d", strtotime("+1 week"));

	$test = time() + 7*24*60*60;

	
	
	echo <<<_END
		<table>
		<p>Book Rent information:
		<br>Title: $Title
		<br>Auther: $Auther
		<br>Genre: $Genre
		<br>Year: $Year
		<br>Expected Return Date: $ReturnDate
		<br>Login to Confirm rental
		</p>
		
		<form action="Confirmed.php" method="post">
		<input type="text" name="username" placeholder="Enter your username" required>
		<input type="password" name="password" placeholder="Enter your password" required>
		<input hidden type="text" name="ISBN" value=$ISBN>
		<input type="submit" value="Submit">
	</form>
		
_END;


	

?>
</html>