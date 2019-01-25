<?php

	//session_start();

	require 'Login.php';
	require 'UploadPic.php';
	require 'ChangeEmail.php';
	require 'ChangeUsername.php';
	require 'ChangePassword.php';
	require 'GetClasses.php';
	require 'GetGroups.php';
	require 'Logout.php';
	
	if(!isset($_SESSION['username']))
	{
		header("Location: ../StudyApp_SampleProject/SampleProjectLoginPage.php");
	}
?>

<!Doctype html>
<html>
	<head>
		<link href = "SampleProjectUniversalStylesheet.css" rel = "stylesheet" type = "text/css"/>
		<link rel= "stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab"/>
		<link rel = "icon" href = "logo.png"/>
	</head>
	
	<body>
		<div id = "container">
			<div id = "modalContainer">
				<form id = "profileModal" class = "modal" action = "" method = "POST" enctype = "multipart/form-data">
					<input type = "button" class = "exitButton" value = "X" onclick = "closeModal()"></input></br></br>
					<input type = "file" class = "customizeSmallButton" name = "file" ></input></br></br>
					<input type = "submit" class = "customizeSmallButton" name = "upload" value = "Upload"></input>
				</form>
				
				<form id = "emailModal" class = "modal" action = "" method = "POST">
					<input type = "button" class = "exitButton" value = "X" onclick = "closeModal()"></input></br></br>
					<label>New Email: </label><input type = "text" name = "new_email"></input></br></br>
					<input type = "submit" class = "customizeSmallButton" name = "change_email"></input>
				</form>
				
				<form id = "passwordModal" class = "modal" action = "" method = "POST" style = "height: 35%">
					<input type = "button" class = "exitButton" value = "X" onclick = "closeModal()"></input></br></br>
					<label>Current Password: </label><input type = "password" name = "current_password"></input></br></br>
					<label>New Password: </label><input type = "password" name = "new_password"></input></br></br>
					<label>Confirm New Password: </label><input type = "password" name = "confirm_password"></input></br></br>
					<input type = "submit" class = "customizeSmallButton" name = "change_password"></input>
				</form>
				
				<form id = "usernameModal" class = "modal" action = "" method = "POST">
					<input type = "button" class = "exitButton" value = "X" onclick = "closeModal()"></input></br></br>
					<label>New Username: </label><input type = "text" name = "new_username"></input></br></br>
					<input type = "submit" class = "customizeSmallButton" name = "change_username"></input>
				</form>
			</div>
			<div id = "header">
				<div id = "headerLeftHalf">
					<div id = "profilePicDropdown">
						<img src = <?php echo "\"profilePictures/" . $_SESSION['profilePic'] . "." . $_SESSION['picFileExtension'] . "\"";?> class = "roundProfilePic" height = "95%" width = "75%"/> <input src = "dropdownArrow.png" onmouseover = "makeAppear()" onmouseout = "makeDisappear()" class = "customizeDropdown" type = "image"></input>
						<div id = "dropdownContent" style = "visibility: hidden;" onmouseover = "makeAppear()" onmouseout = "makeDisappear()">
						<form action = "" method = "POST">
							<input type="submit" value = "Logout" name = "logout" class = "dropdownContent"></input></br>
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
				<div id = "profileLeftHalf">
					<label style = "margin-left: 2%;">Profile Picture:</label></br><img src = <?php echo "\"profilePictures/" . $_SESSION['profilePic'] . "." . $_SESSION['picFileExtension'] . "\"";?> height = "52%" width = "52%" style = "margin-left: 24%; margin-top: 2.5%;">
					<input type = "button" onclick = "openProfileModal()" class = "customizeSmallButton" value = "Change"></input> </br> </br>
					<div class = "displayProfileInfo">
						<label style = "margin-left: 2%;">Email: </label> <?php echo $_SESSION['email']; ?><input type = "button" onclick = "openEmailModal()" class = "customizeSmallButton" style = "margin-left: 32%;" value = "Change"></input> 
						<label style = "margin-left: 2%;">Username: </label> <?php echo $_SESSION['username']; ?><input type = "button" onclick = "openUsernameModal()" class = "customizeSmallButton" style = "margin-left: 32%;" value = "Change"></input>
						<label style = "margin-left: 2%;">Password: </label> <filler></filler> <input type = "button" onclick = "openPasswordModal()" class = "customizeSmallButton" style = "margin-left: 32%;" value = "Change"></input> 
					</div>
				</div> 
				<div id = "profileRightHalf">
					<form id = "profileTopRight" action = "" method = "POST">
					<div style = "width: 100%; background-color: #b3daff; position: fixed;">Classes:</div></br>
					</form>
					<form id = "profileBottomRight" action = "" method = "POST">
					<div style = "width: 100%; background-color: #b3daff; position: fixed;">Groups:</div></br>
					</form>
				</div>
			</div>
			
			<div id = "bottomHalf">
			</div>
		</div>
		<script src = "DropDown.js"></script>
		<script src = "EditModals.js"></script>
		<script>
			<?php
				$i = 0;
				
				for(; $i < $numRows; $i++)
				{
					echo "var topRight = document.getElementById(\"profileTopRight\"); 
				var div = document.createElement(\"div\"); 
				
				
				var btn = document.createElement(\"input\");
				btn.className = \"customizeSmallButton\";
				btn.type = \"submit\";
				btn.value = \"Delete\";
				btn.style.marginTop = \"11%\";
				btn.name = \"delete" . $i . "\";
				
				
				var p1 = document.createElement(\"p\");
				var p2 = document.createElement(\"p\");
				var p3 = document.createElement(\"p\");
				var p4 = document.createElement(\"p\");
				
				p1.name = \"" . $userClasses[$i]['class'] . "\";
				
				var class_added = document.createTextNode(\"Class: " . $userClasses[$i]['class'] . "\");
				var instructor = document.createTextNode(\"Instructor: " . $userClasses[$i]['instructor_first'] . " " . $userClasses[$i]['instructor_last'] . "\");
				var start = document.createTextNode(\"Start Time: " . $userClasses[$i]['start_time'] . "\");
				var end = document.createTextNode(\"End Time: " . $userClasses[$i]['end_time'] . "\");
				
				p1.appendChild(class_added);
				p2.appendChild(instructor);
				p3.appendChild(start);
				p4.appendChild(end);
				
				div.className = \"listedInfo displayClassInfo\"; 
				topRight.appendChild(div); 
				div.appendChild(p1);
				div.appendChild(p2);
				div.appendChild(p3);
				div.appendChild(p4);
				div.appendChild(btn);";
				}
				
				for($j = 0; $j < $i; $j++)
				{
					$submitValue = 'delete' . $j;
		
					if(isset($_POST[$submitValue]))
					{
						$query = "DELETE FROM classes WHERE user = '" . $userClasses[$j]['user'] . "' AND class = '" . $userClasses[$j]['class'] . "';";
						mysqli_query($conn, $query);
						header("Refresh:0");
					}
				}
				
			?>
		</script>
		<script>
		
			<?php
				$enteredGroups = array(); 
				
				for($ll = 0; $ll < sizeof($joinedGroupIds); $ll++)
				{
					$query = "SELECT * FROM study_groups WHERE id = '". $joinedGroupIds[$ll] . "';";
					$effect = mysqli_query($conn, $query);
					$rowsAcquired = mysqli_num_rows($effect);

					while($groupsEntered = mysqli_fetch_assoc($effect))
					{
						$enteredGroups[] = $groupsEntered;
					}
					
				}
				
				$ii = 0;
				
				for(; $ii < sizeof($enteredGroups); $ii++)
				{
					$infoQuery = "SELECT * FROM users WHERE user_name = '" . $enteredGroups[$ii]['host'] . "';";
					$effect0 = mysqli_query($conn, $infoQuery);
					$hostInfo0 = mysqli_fetch_assoc($effect0);
					
					if($enteredGroups[$ii]['end'] != NULL)
					{
						$end = $enteredGroups[$ii]['end'];
					}
					
					echo "var profileBottomRight = document.getElementById(\"profileBottomRight\");
						var randomDiv = document.createElement(\"div\");
						randomDiv.className = \"listedInfo displayGroupsJoinedProfile\";
						
						var hostContainer = document.createElement(\"div\");
						hostContainer.className = \"evenDivide\";
						
						var btn = document.createElement(\"input\");
						btn.type = \"submit\";
						btn.className = \"customizeSmallButton\";
						btn.value = \"Unjoin\";
						btn.style.marginTop = \"11%\";
						btn.name = \"unjoin" . $ii . "\";
						
						var hostImg = document.createElement(\"img\");
						hostImg.src = \"profilePictures/" . $hostInfo0['user_profile_filename'].".".$hostInfo0['profile_file_extension'] . "\";
						hostImg.className = \"roundProfilePic\";
						hostImg.style.height = \"65%\";
						hostImg.style.width = \"40%\";
						hostImg.style.marginTop = \"10%\";
						hostImg.style.cssFloat = \"right\";
						
						var p1 = document.createElement(\"p\");
						var p2 = document.createElement(\"p\");
						var p3 = document.createElement(\"p\");
						var p4 = document.createElement(\"p\");
							   
						var hostLabel = document.createTextNode(\" Host: \");
							   
						var studyClass = document.createTextNode(\" Class: " . $enteredGroups[$ii]['class'] . "\");
						var start = document.createTextNode(\" Start: " . $enteredGroups[$ii]['start'] . "\");
						var end = document.createTextNode(\" End: " . $end . "\");
							   
						p1.appendChild(hostLabel);
						hostContainer.appendChild(p1);
						hostContainer.appendChild(hostImg);
						
						p2.appendChild(studyClass);
						p3.appendChild(start);
						p4.appendChild(end);
						
						randomDiv.appendChild(hostContainer);
						randomDiv.appendChild(p2);
						randomDiv.appendChild(p3);
						randomDiv.appendChild(p4);
						randomDiv.appendChild(btn);
						
						profileBottomRight.appendChild(randomDiv);";
				}
				
				for($j = 0; $j < $ii; ++$j)
				{
					
					$submitVal = 'unjoin' . $j;
					
					if(isset($_POST[$submitVal]))
					{
						//when the button is unjoin button is pressed, that member is deleted for that group; if they were the host, a new host should be chosen from the remaining members; This can be done later...
						$removalQuery = "DELETE FROM study_group_members WHERE group_id = '" . $enteredGroups[$j]['id'] . "' AND member = '" . $_SESSION['username'] . "';";
						mysqli_query($conn, $removalQuery);
						header("Refresh:0");
					}
				}
			?>
		</script>
		<script>
			<?php echo $script; ?>
		</script>
	</body>
</html>