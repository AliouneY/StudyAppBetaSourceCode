<?php

	$script = "";

	if(isset($_POST['change_password']))
	{
		include_once 'connect.php';
		
		$user = $_SESSION['username'];
		$currentPassword = mysqli_real_escape_string($conn, $_POST['current_password']);
		$newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
		$confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
		
		$query = "SELECT * FROM users WHERE user_name = '$user';";
		$result = mysqli_query($conn, $query);
		$userInfo = mysqli_fetch_assoc($result);
		
		if(!empty($currentPassword) && !empty($currentPassword) && !empty($currentPassword))
		{
			$passwordCheck = password_verify($currentPassword, $userInfo['user_password']);
			
			if($passwordCheck)
			{
				if($newPassword == $confirmPassword)
				{
					$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
					
					$query = "SELECT * FROM users WHERE user_password = '$hashedPassword';";
					$results = mysqli_query($conn, $query);
					$resultCheck = mysqli_num_rows($results);
					
					if($resultCheck < 1)
					{
						$query = "UPDATE users SET user_password = '$hashedPassword' WHERE user_name = '$user';";
							
						mysqli_query($conn, $query);
					}
					
					else
					{
						$script = "alert(\"Password Already Exists\");";
					}
				}
				
				else
				{
					$script = "alert(\"Passwords Don't Match\");";
				}
			}
			
			else
			{
				$script = "alert(\"Current Password Entered Doesn't Exist\");";
			}
		}
		
		else
		{
			$script = "alert(\"Empty Fields!\");";
		}
	}