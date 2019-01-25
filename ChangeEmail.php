<?php
	
	$script = "";
	
	if(isset($_POST['change_email']))
	{
		include_once 'connect.php';
		
		$user = $_SESSION['username'];
		$newEmail = mysqli_real_escape_string($conn, $_POST['new_email']);
		
		if(filter_var($newEmail, FILTER_VALIDATE_EMAIL))
		{
			$query = "SELECT * FROM users WHERE user_email = '$newEmail';";
			$result = mysqli_query($conn, $query);
			$resultCheck = mysqli_num_rows($result);
			
			if($resultCheck < 1)
			{
				$query = "UPDATE users SET user_email = '$newEmail' WHERE user_name = '$user';";
				
				mysqli_query($conn, $query);
				
				$query = "SELECT * FROM users WHERE user_name = '$user';";
				$result = mysqli_query($conn, $query);
				$userInfo = mysqli_fetch_assoc($result);
				
				$_SESSION['email'] = $userInfo['user_email'];
			
				$script = "alert(\"Email successfully changed!\");";
			}
			
			else
			{
				$script = "alert(\"Email Already Exists\");";
			}
		}
			
		else
		{
			$script = "alert(\"Invalid Email\");";
		}
		
	}