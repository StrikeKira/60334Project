<html>
<head>
<title>Gotham City Libary System</title>
<link href='http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href="../css/main.css" rel="stylesheet">
<link href="responsive_solution.css" rel="stylesheet" media="screen and (max-width: 960px)"> 
</head>
<body><div class="wrapper">
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
		<h2>Gotham City Libary User Lookup Page</h2>
	
	<?php
	 require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);
	
	if(empty($_POST)){
	echo <<<_END
	<form action="UserLookup.php" method="post">
	<p>Enter your Username to check books you currently have rented</p>
		<input type="text" name="username" placeholder="Enter your username" required>
		<input type="submit" value="Submit">
	</form>
_END;
	}else{
		$Username = $_POST['username'];
		$CurrentDate = date('Y-m-d');
		$nextWeek = time() + (7 * 24 * 60 * 60);
		//$ReturnDate = date('Y-m-d', $nextWeek);
		
		
		
		$query = "SELECT * FROM User_Table WHERE Username='$Username'";
		$result = $conn->query($query);
		$rows = $result->num_rows;
		
		if($rows == 1){
			$row = $result->fetch_array(MYSQLI_NUM);
			echo $Username . " Currently has " . $row[4] . " Books Rented <br>";
			
			$CheckFinesQuery = "SELECT * FROM Book_Rent_Table WHERE Username LIKE '$Username'";
			$CheckFinesResult = $conn->query($CheckFinesQuery);
			$CheckFinesrows = $CheckFinesResult->num_rows;

			for($x = 0; $x < $CheckFinesrows; ++$x){
				$CheckFinesResult ->data_seek($x);
				$CheckFinesrow = $CheckFinesResult->fetch_array(MYSQLI_NUM);
				$ISBN = $CheckFinesrow[0];
				$ReturnDate = $CheckFinesrow[3];
				if($ReturnDate < $CurrentDate ){
					
					$NewReturn =date('Y-m-d', $nextWeek);

					
					$UpdateReturn = "UPDATE Book_Rent_Table SET ReturnDate = '$NewReturn' WHERE ISBN = '$ISBN'";		
					$UpdateFines = "UPDATE User_Table SET Fines_owed = Fines_owed + 5 WHERE Username = '$Username'";
					$Update = $conn->query($UpdateFines);
					$Update = $conn->query($UpdateReturn);

				}
				
			}

			
			
			$query = "SELECT * FROM User_Table WHERE Username='$Username'";
			$result = $conn->query($query);
				$row = $result->fetch_array(MYSQLI_NUM);

			echo "Fines Owed: $" . $row[3] . ".00<br>";
			echo <<<_END
			<form action='PayFines.php' method='post'>
			<input hidden type="text" name="username" value='$Username'>
			<input type="submit" value="Pay Fines">
			</form>
_END;
			
			
			
			if ($row[3] > 0){
				echo <<<_END
				Pay Fines Here: <br>
_END;
			}
			
			$query2 ="SELECT * FROM Book_Rent_Table WHERE Username = '$Username'";
			$result2 = $conn->query($query2);
			$rows2 = $result2->num_rows;
			
			
			for($j = 0; $j < $rows2; ++$j){
				$result2->data_seek($j);
				$row2 = $result2->fetch_array(MYSQLI_NUM);
				echo "<br><br>";
				echo "<form action='ReturnBook.php' method='post'>";
	
				$query3 = "SELECT * FROM Book_Table WHERE ISBN='$row2[0]'";
				$result3 = $conn->query($query3);
				$row3 = $result3->fetch_array(MYSQLI_NUM);
				

				
				$i = $j + 1;
				echo "Book " . $i . ": <br>";
				echo "TITLE: " . $row3[0] . "<br>";
				echo "Return Date: " . $row2[3] . "<br>";
				echo "<input hidden type ='text' name='ISBN' value = '$row2[0]'>";
				echo "<input hidden type ='text' name='Username' value = '$Username'>";
				echo "<input hidden type ='text' name='ReturnDate' value = '$row2[3]'>";

				echo "<input type='submit'value='Return Book'></form>";
				
			}
		}else{
			echo <<<_END
			<p>Invalid Username!
			<form action="UserLookup.php" method="post">
			<p>Enter your Username to check books you currently have rented</p>
			<input type="text" name="username" placeholder="Enter your username" required>
			<input type="submit" value="Submit">
			</form>
_END;
		}
	}
	
	?>
</body>
</html>