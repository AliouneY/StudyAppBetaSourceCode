<?php //session can be started in including file

	if(!isset($_SESSION))
	{
		session_start();
	}

	include_once 'connect.php';
	
	$user = $_SESSION['username'];
	$query = "SELECT * FROM classes WHERE user = '" . $_SESSION['username'] . "';"; //we get all rows from the classes database that are of the user's username
	$result = mysqli_query($conn, $query);
	$numRows = mysqli_num_rows($result);
	$userClasses = array();
	
	while($rows = mysqli_fetch_assoc($result)) //this loop puts those rows in an array (called userClasses). Each row is, of course, an array of column names, so this is a 2d array
	{
		$userClasses[] = $rows;
	}
	
	
	
	