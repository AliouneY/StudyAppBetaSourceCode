<?php

	$errorMessage = "<p></p>";

	if(isset($_POST['submit']))
	{
		include_once 'connect.php';
		
		
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
		
		
		if(!empty($username) && !empty($email) && !empty($password))
		{
			if(filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$query = "SELECT * FROM users WHERE user_email = '$email';";
				
				$results = mysqli_query($conn, $query);
						
				$resultCheck = mysqli_num_rows($results);
				
				if($resultCheck < 1)
				{
					if($password == $confirmPassword)
					{
						
						$hashedPass = password_hash($password, PASSWORD_DEFAULT);
						
						$query = "SELECT * FROM users WHERE user_password = '$hashedPass';";
						
						if($resultCheck < 1)
						{
							$query = "INSERT INTO users (user_name, user_email, user_password) VALUES ('$username', '$email', '$hashedPass');";
							
							mysqli_query($conn, $query);
							
							header("Location: ../StudyApp_SampleProject/SampleProjectLoginPage.php");
							exit();
						}
						
						else
						{
							$errorMessage = "<p style = \"color: red\">Password Already Exists</p>";
						}
					}
					
					else
					{
						$errorMessage = "<p style = \"color: red\">Passwords Don't Match</p>";
					}
				}
				
				else
				{
					$errorMessage = "<p style = \"color: red\">Email Already Exists</p>";
				}
			}
			
			else
			{
				$errorMessage = "<p style = \"color: red\">Invalid Email</p>";
			}
		}
		
		else
		{
			$errorMessage = "<p style = \"color: red\"> Empty Fields </p>";
		}
	}
	