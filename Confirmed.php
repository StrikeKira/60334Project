<html>
<head>
<title>Gotham City Libary System</title>
<link href='http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href="../css/main.css" rel="stylesheet">
<link href="responsive_solution.css" rel="stylesheet" media="screen and (max-width: 960px)"> 
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
		<h2>Gotham City Libary Confirmation Page</h2>

	<?php
	require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);
	
	$Username = $_POST['username'];
	$Password = $_POST['password'];
	$ISBN = $_POST['ISBN'];
	$nextWeek = time() + (7 * 24 * 60 * 60);
	$ReturnDate = date('Y-m-d', $nextWeek);
	
	$query = "SELECT * FROM User_Table WHERE Username Like '$Username'";
	$result = $conn->query($query);
	$row = $result->fetch_array(MYSQLI_NUM);



	if($Password == $row[1]){
		if($row[4] > 3 && $row[2] == "Student"){
			echo "<p>You currently have to many books rented.<br>
			A Student is only alloweed to rent 3 books at any given time.<br>
			Please return one if you wish to rent this book.";
		} elseif($row[4] > 5 && $row[2] == "Teacher"){
			echo "<p>You currently have to many books rented.<br>
			A Teacher is only alloweed to rent 3 books at any given time.<br>
			Please return one if you wish to rent this book.";
		}else{
			if($row[3] > 20){
				echo "You currently have to many fines on your accoutnt.<br>
				Users cannot rent books if they owe more than $20.00";
				echo <<<_END
			<form action='PayFines.php' method='post'>
			<input hidden type="text" name="username" value='$row[0]'>
			<input type="submit" value="Pay Fines">
			</form>
_END;
			}else{
			
			$query = "UPDATE User_Table SET Total_Rented = Total_Rented + 1 WHERE Username LIKE '$Username'";
			$result = $conn->query($query);
			$query = "UPDATE User_Table SET Current_Rented = Current_Rented + 1 WHERE Username LIKE '$Username'";
			$result = $conn->query($query);

			$query = "UPDATE `Book_Table` SET `InStock` = '1' WHERE `Book_Table`.ISBN = '$ISBN'";
			$result = $conn->query($query);
			
			
			$query = "INSERT INTO `Book_Rent_Table` (`ISBN`, `Username`,`ReturnInt`, `ReturnDate`) VALUES ('$ISBN', '$Username','$nextWeek' ,'$ReturnDate')";
			$result = $conn->query($query);
				
			echo "The book has been rented by: " .$Username . "</br>";
			echo "You have until " . $ReturnDate . "to return the book before being fined.<br>";
			}
		}
	}else{
		echo <<<_END
		<p>Invalid Username or Password. Please try again</p>
		<form action="Confirmed.php" method="post">
		<input type="text" name="username" placeholder="Enter your username" required>
		<input type="password" name="password" placeholder="Enter your password" required>
		<input hidden type="text" name="ISBN" value=$ISBN>
		<input type="submit" value="Submit">
	</form>
_END;
	}
?>
</body>
</html>