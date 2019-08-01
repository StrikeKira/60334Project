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
	
	<?php
	
	if(empty($_POST)){
	echo <<<_END
	<form action="Return.php" method="post">
		<input type="text" name="username" placeholder="Enter your username" required>
		<input type="password" name="password" placeholder="Enter your password" required>
		<input type="submit" value="Submit">
	</form>
_END;
	}else{
		echo "1234";
	}
	
	?>
</body>
</html>