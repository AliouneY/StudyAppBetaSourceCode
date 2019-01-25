<?php
	require 'CreateAccount.php';
?>

<!Doctype html>
<html>
	<head>
		<link href = "SampleProjectUniversalStylesheet.css" rel = "stylesheet" type = "text/css"/>
	</head>
	
	<body>
		<div id = "container">
			<form id = "createAccountContainer" action = "" method = "POST">
				<input type = "text" class = "customizeInput" placeholder = "Username" name = "username"></input> <br/> <br/>
				
				<input type = "text" class = "customizeInput" placeholder = "Email" name = "email"></input> <br/> <br/>
				
				<input type = "password" class = "customizeInput" placeholder = "Password" name = "password"></input> <br/> <br/>
				
				<input type = "password" class = "customizeInput" placeholder = "Confirm Password" name = "confirmPassword"></input> <br/> <br/>
				
				<?php echo $errorMessage; //see CreateAccount.php ?>
				
				<input type = "submit" class = "customizeButton" value = "Create Account" name = "submit"></input> <br/> <br/>
				
				<input type = "button" class = "customizeButton" onclick = "location.href = 'SampleProjectLoginPage.php'" value = "Cancel"></input>
			</form>
		</div>
	</body>
</html>

