<?php
	require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	$query = "SELECT Genre, count(*) as number FROM Book_Table GROUP BY Genre";  
	$result = mysqli_query($conn, $query);  
	
	$query2 = "SELECT User_level, count(*) as number FROM User_Table GROUP BY User_level";  
	$result2 = mysqli_query($conn, $query2);  
	 ?>  

<html>
<head>
<title>Gotham City Libary System</title>
<link href='http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href="../css/main.css" rel="stylesheet">
<link href="responsive_solution.css" rel="stylesheet" media="screen and (max-width: 960px)"> 

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
           <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
		   google.charts.setOnLoadCallback(drawChart2);  

           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Genre', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo "['".$row["Genre"]."', ".$row["number"]."],";  
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'Percentage of Genre',    
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
		   
		    function drawChart2()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['User_level', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result2))  
                          {  
                               echo "['".$row["User_level"]."', ".$row["number"]."],";  
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'User Distibution',    
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));  
                chart.draw(data, options);  
           }  
		   
		   
		   
           </script>  
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
		<h2>Gotham City Libary Website Admin Page</h2>
	
	<?php
	
	if(empty($_POST)){
		echo <<<_END
		<form action="admin.php" method="post">
		<p>Enter your Username and Password of an Admin account<br>
		<i> Admin: pass123</p>
		<input type="text" name="username" placeholder="Enter Admin username" required>
		<input type="text" name="password" placeholder="Enter Admin Password" required>
		<input type="submit" value="Submit">
	</form>
		
_END;
	}else{
		$Username = $_POST['username'];
		$Password = $_POST['password'];
		
		if($Password == "pass123" && $Username == "Admin"){
			echo "<div id='piechart' style='width: 900px; height: 500px;'></div>";
			echo "<div id='piechart2' style='width: 900px; height: 500px;'></div>";
		}else{
		echo <<<_END
		<form action="admin.php" method="post">
		<p>Invalid Username or Password<br>
		<i> Admin: pass123</p>
		<input type="text" name="username" placeholder="Enter Admin username" required>
		<input type="text" name="password" placeholder="Enter Admin Password" required>
		<input type="submit" value="Submit">
	</form>
		
_END;
			
		}
	}
	
?>

</body>
</html>
