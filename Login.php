<?php
	$errorMessage = "<p></p>"; //error message: changes based on the error and is output on the screen
	
	if(isset($_POST['submit']))
	{
		include_once 'connect.php';
		
		$username_email = mysqli_real_escape_string($conn, $_POST['email/username']); //mysqli_real_escape_string protects from XSS attack (well, it would in a perfect world, but professional hackers can probably get around this somehow...)
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		
		if(!empty($username_email) && !empty($password)) //if the fields aren't empty
		{
			if(filter_var($username_email, FILTER_VALIDATE_EMAIL)) //if email is valid
			{
				$query = "SELECT * FROM users WHERE user_email = '$username_email';"; //this is a query that grabs all user emails that match the one entered
				$result = mysqli_query($conn, $query); //query this in the database
				$resultCheck = mysqli_num_rows($result); //the number of matching rows (which shouldn't be more than one) is put in $resultCheck variable
				$userInfo = mysqli_fetch_assoc($result); //this takes the information and puts it in an array ($userInfo), accessible by name (very convenient)

				if($resultCheck == 1) //if there is an email matching that which was entered
				{
					$passwordCheck = password_verify($password, $userInfo['user_password']); //check if the password matches the password of the user associated with the email
					
					if($passwordCheck) //if the passwords match
					{
						session_start();
						
						$_SESSION['identifier'] = $userInfo['user_id'];
						$_SESSION['username'] = $userInfo['user_name'];
						$_SESSION['email'] = $userInfo['user_email'];
						$_SESSION['profilePic'] = $userInfo['user_profile_filename'];
						$_SESSION['picFileExtension'] = $userInfo['profile_file_extension'];
						
						header("Location: ../StudyApp_SampleProject/SampleProjectHomePage.php"); //go to this page
						/*
							We still need:
							1. email verification
							2. to handle session states (for example, what happens when session times out)
							3. to update the database design so that it tracks the time that each user does something, especially login or logout (I shall study timestamps)
						*/
					}
					
					else
					{
						$errorMessage = "<p style = \"color: red\"> Invalid Email/Username or Password </p>"; //this error message gives hackers no information about the potential existence of username or password they entered
					}
				}
			
			}
			
			else //this whole thing is the same as above, but if the user enters username instead of email
			{
				$query = "SELECT * FROM users WHERE user_name = '$username_email';";
				$result = mysqli_query($conn, $query);
				$resultCheck = mysqli_num_rows($result);
				$userInfo = mysqli_fetch_assoc($result);
				
				if($resultCheck == 1)
				{
					$passwordCheck = password_verify($password, $userInfo['user_password']);
					
					if($passwordCheck)
					{
						session_start();
						
						$_SESSION['identifier'] = $userInfo['user_id'];
						$_SESSION['username'] = $userInfo['user_name'];
						$_SESSION['email'] = $userInfo['user_email'];
						$_SESSION['profilePic'] = $userInfo['user_profile_filename'];
						$_SESSION['picFileExtension'] = $userInfo['profile_file_extension'];
						
						header("Location: ../StudyApp_SampleProject/SampleProjectHomePage.php");
					}
					
					else
					{
						$errorMessage = "<p style = \"color: red\"> Invalid Email/Username or Password </p>";
					}
				}
				
				else
				{
					$errorMessage = "<p style = \"color: red\"> Invalid Email/Username or Password</p>";
				}
			}
		}
		
		else
		{
			$errorMessage = "<p style = \"color: red\"> Empty Fields </p>";
		}
	}