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
		<h2>Gotham City Libary Website Book Return Page</h2>
	<?php
	require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);

		$Username = $_POST['Username'];
		$ISBN = $_POST['ISBN'];
		
		$DeleteQuery = "DELETE FROM Book_Rent_Table WHERE ISBN ='$ISBN'";
		$InStockQuery = "UPDATE Book_Table SET InStock = '0' WHERE ISBN = '$ISBN'";
		$ReturnQuery	 = "UPDATE User_Table SET Current_Rented = Current_Rented - 1 WHERE Username = '$Username'";
		$result = $conn->query($DeleteQuery);
		$result = $conn->query($InStockQuery);
		$result = $conn->query($ReturnQuery);
	
	
		echo "Your Book has been returned";
		
	
	?>


</body>
</html>