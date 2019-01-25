<?php

	$script = "";

	if(isset($_POST['change_username']))
	{
		include_once 'connect.php';
		
		$user = $_SESSION['username'];
		$newUsername = mysqli_real_escape_string($conn, $_POST['new_username']);
		
		if(!empty($newUsername))
		{
			$query = "SELECT * FROM users WHERE user_name = '$newUsername';";
			$result = mysqli_query($conn, $query);
			$resultCheck = mysqli_num_rows($result);
			
			if($resultCheck < 1)
			{
				$query = "UPDATE users SET user_name = '$newUsername' WHERE user_name = '$user';";
				
				mysqli_query($conn, $query);
				
				$query = "UPDATE classes SET user = '$newUsername' WHERE user = '$user';";
				
				mysqli_query($conn, $query);
				
				$user = $newUsername;
				
				$query = "SELECT * FROM users WHERE user_name = '$user';";
				$result = mysqli_query($conn, $query);
				$userInfo = mysqli_fetch_assoc($result);
				
				$_SESSION['username'] = $userInfo['user_name'];
				
				$script = "alert(\"Username Successfully Changed!\");";
			}
			
			else
			{
				$script = "alert(\"Username Already Exists\");";
			}
		}
		
		else
		{
			$script = "alert(\"Empty Field!\");";
		}
	}