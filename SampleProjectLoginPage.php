<?php
	session_start();
	
	if(isset($_SESSION['username']))
	{
		header("Location: ../StudyApp_SampleProject/SampleProjectHomePage.php");
	}
	
	include 'Login.php';
?>

<!Doctype html>
<html>
	
	<head>
		<link href = "SampleProjectUniversalStylesheet.css" rel = "stylesheet" type = "text/css"/>
	</head>
	
	<body>
		<div id = "container">
			<div id = "logo">
				<img src = "logo.png" style = "width: 100%; height: 100%;"/>
			</div> </br> </br>
			
			<h3 style = "width: 36%; margin-left: 42%;" class = "fadeIn">Study Groups Made Easy!</h3> </br> </br>
			
			<form id = "loginContainer" action= "" method = "POST">
				<input class = "customizeInput" id = "email" type = "text" name = "email/username" placeholder = "Email/Username">
				</input> <br/> <br/>
				
				<input class = "customizeInput" id = "password" type = "password" name = "password" placeholder = "Password">
				</input> <br/> <br/>
				
				<?php echo $errorMessage; //see Login.php?> <!-- Needs a script to stop animation from executing more than once (right now it executes for every error message)-->
				
				<!--Need To Verify Emails And Have A "Forgot Password" Link-->
				
				<input value = "Login" class = "customizeButton" id = "login" type = "submit" name = "submit">
				</input> <br/> <br/>
				
				<input onclick = "location.href = 'SampleProjectCreateAccountPage.php'" value = "Create Account" class = "customizeButton" id = "createAccount" type = "button">
				</input>
			</form>
		</div>
	</body>
</html>