<?php

	//session_start();

	require 'GetGroups.php';
	require 'Logout.php';
	
	if(!isset($_SESSION['username']))
	{
		header("Location: ../StudyApp_SampleProject/SampleProjectLoginPage.php");
	}
	
	$user = $_SESSION['username'];
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
				<form id = "advertisedGroupList" action = "" method = "POST">
					<?php $defaultMessage = "<p class = \"defaultMessage\">No Study Groups Match The Classes You've Joined...</p>"; if(sizeof($advertisedGroups) === 0){echo $defaultMessage;} ?>
				</form>
			</div>
			
			<div id = "bottomHalf">
			</div>
		</div>
		<script src = "DropDown.js"></script>
		<script>
			<?php
				for($l = 0; $l < sizeof($advertisedGroups); $l++)
				{
					echo $advertisedGroups[$l];
				}
				
				for($m = 0; $m < $l; $m++)
				{
					$submitVal = 'join' . $m;
			
					if(isset($_POST[$submitVal]))
					{
						$query = "INSERT INTO study_group_members (group_id, member, host_status) VALUES ('" . $groupsOfThisClass[$m]['id'] . "', '" . $user . "', 0);";
						mysqli_query($conn, $query);
						echo "alert(\"Group Successfully Joined\");"; 
						header("Refresh:0");
					}
				}
			?>
		</script>
	</body>
</html>