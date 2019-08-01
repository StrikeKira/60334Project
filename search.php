<html>
<head>
<title>Gotham City Libary System</title>
<link href='http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href="../css/main.css" rel="stylesheet">
<link href="responsive_solution.css" rel="stylesheet" media="screen and (max-width: 960px)"> 
	<script src = "../js/search.js"></script>
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
		<h2>Gotham City Libary Search Page</h2>
<section id="col1">
	<?php
	require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);
	
	$query = "SELECT * FROM Book_Table";
	$result = $conn->query($query);
    if (!$result) die ("Database access failed: " . $conn->error);
	
    $rows = $result->num_rows;
	
	echo <<<_END
		
		Search for a book Title: <input type="text" id="myInput" onkeyup="myFunction()">
	
	
	<table id="myTable">
	<thead><tr>
		<th>Title</th>
		<th>Auther</th>
		<th>Genre</th>
		<th>Year</th>
		<th>ISBN</th>
		<th>Rent</th>
		</tr></thead>
_END;


  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
	<form action="RentPage.php" method="post">
	<tr>
	<td>$row[0]</td>
	<td>$row[1]</td>
	<td>$row[2]</td>
	<td>$row[3]</td>
	<td>$row[4]</td>
_END;
	if($row[5]==0){
		echo <<<_END
			<input hidden type="text" name="ISBN" value=$row[4]>
	<td><input type="submit" value="Rent" class="link-button"></td>
_END;
	}else{
		echo "<td>Not in Stock</td>";
	}
	echo <<<_END
	
	</tr>
	</pre></form>
_END;
  }
	echo '</table>';

?>
</section>

</body>
</html>