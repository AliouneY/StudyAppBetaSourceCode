<?php
	session_start();
	
	if(!isset($_SESSION['username']))
	{
		header("Location: ../StudyApp_SampleProject/SampleProjectLoginPage.php");
	}
	
	require 'AddClass.php';
	require 'Logout.php';
?>

<!Doctype html>
<html>
	<head>
		<link href = "SampleProjectUniversalStylesheet.css" rel = "stylesheet" type = "text/css"/>
		<link rel= "stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab"/>
	</head>
	
	<body>
		<div id = "container">
			<div id = "header">
				<div id = "headerLeftHalf">
					<div id = "profilePicDropdown"> 
						<img src = <?php echo "\"profilePictures/" . $_SESSION['profilePic'] . "." . $_SESSION['picFileExtension'] . "\"";?> class = "roundProfilePic" height = "95%" width = "75%"/> <input src = "dropdownArrow.png" onmouseover = "makeAppear()" onmouseout = "makeDisappear()" class = "customizeDropdown" type = "image"></input>
						<div id = "dropdownContent" style = "visibility: hidden;" onmouseover = "makeAppear()" onmouseout = "makeDisappear()">
							<form action = "" method = "POST">
							<input type="submit" value = "Logout" name = "logout" class = "dropdownContent" onclick = "location.href = 'SampleProjectLoginPage.php'"></input></br>
							<input type="button" value = "Help" class = "dropdownContent" onclick = "location.href = 'SampleProjectHelpPage.php'"></input> </br>
							<input type="button" value = "Home" class = "dropdownContent" onclick = "location.href = 'SampleProjectHomePage.php'"></input> </br>
							<input type="button" value = "Add Classes" class = "dropdownContent" onclick = "location.href = 'SampleProjectAddClassPage.php'"></input> </br>
							<input type="button" value = "Create Study Group" class = "dropdownContent" onclick = "location.href = 'SampleProjectCreateGroup.php'"></input> </br>
							<input type="button" value = "Join Study Group" class = "dropdownContent" onclick = "location.href = 'SampleProjectJoinGroup.php'"></input> </br>
							<input type="button" value = "Profile" class = "dropdownContent" onclick = "location.href = 'SampleProjectProfilePage.php'"></input>
						</form>
						</div>
					</div>
				</div>
			</div>
			
			<div id = "topHalf">
				<form id = "classSearch" action = "" method = "POST">
					<label>Class:</label></br></br><input class = "customizeInput" type = "text" placeholder = "ex. ENG102" style = "width: 8%;" name = "class"></input> </br> </br> </br>
					<label>Instructor:</label> </br> </br>
					<input class = "customizeInput" type = "text" placeholder = "First" name = "first"></input>    <input class = "customizeInput" type = "text" placeholder = "Last" name = "last"></input></br> </br>
					<input type = "radio"  value = "Male" name = "gender" checked = "checked" ></input><label>Male</label> <input type = "radio" value = "Female" name = "gender"></input><label>Female</label> </br></br></br>
					<label>Time:</label></br></br>
					<input class = "customizeInput" type = "time" style = "width: 10.5%;" name = "begin"></input> - <input class = "customizeInput" type="time" style = "width: 10.5%;" name = "end"></input> </br></br>
					<input type = "submit" class = "customizeButton" value = "+ Add" name = "addClass"></input>
				</form>
			</div>
			
			<div id = "bottomHalf">
			</div>
		</div>
		<script src = "DropDown.js"></script>
		<?php echo $messageScript; //see AddClass.php?>
	</body>
</html>