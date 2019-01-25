<?php

	$script = "";

	if(isset($_POST['upload']))
	{	
	
		include_once 'connect.php';
		
		$identifier = $_SESSION['identifier'];
		
		$user = $_SESSION['username'];
		$pic = $_FILES['file']['name'];
		$tmpLocation = $_FILES['file']['tmp_name'];
		$size = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$type = $_FILES['file']['type'];
		$explodedFileName = explode(".", $pic);
		$extension = strtolower(end($explodedFileName));
		
		$acceptedFiles = array("jpg", "jpeg", "png", "gif");
	
		if($error === 0)
		{
			if(in_array($extension, $acceptedFiles))
			{
				if($size <= 1000000)
				{
					$fileName = $identifier . $pic;
					$permanentLocation = "profilePictures/". $fileName;
					
					move_uploaded_file($tmpLocation, $permanentLocation);
					
					$query = "UPDATE users SET user_profile_filename = '$identifier$explodedFileName[0]', profile_file_extension = '$extension' WHERE user_name = '$user';";
					
					mysqli_query($conn, $query);
					
					$getRows = "SELECT * FROM users WHERE user_name = '$user';";
					$result = mysqli_query($conn, $getRows);
					$userInfo = mysqli_fetch_assoc($result);
					
					$_SESSION['profilePic'] = $userInfo['user_profile_filename'];
					$_SESSION['picFileExtension'] = $userInfo['profile_file_extension'];
					
					$script = "alert(\"Picture successfully changed!\");";
				}
				
				else
				{
					$script = "alert(\"Sorry! This file is too large...\");";
				}
			}
			
			else
			{
				$script = "alert(\"Sorry! Files of this type are not allowed :(\");";
			}
		}
		
		else
		{
			$script = "alert(\"An error occured while loading the file...\");";
		}
	}