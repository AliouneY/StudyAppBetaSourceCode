<?php
	
	//session_start();
	
	include 'GetGroups.php';
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
							<input type="div" value = "Help" class = "dropdownContent" onclick = "location.href = 'SampleProjectHelpPage.php'"></input> </br>
							<input type="div" value = "Home" class = "dropdownContent" onclick = "location.href = 'SampleProjectHomePage.php'"></input> </br>
							<input type="div" value = "Add Classes" class = "dropdownContent" onclick = "location.href = 'SampleProjectAddClassPage.php'"></input> </br>
							<input type="div" value = "Create Study Group" class = "dropdownContent" onclick = "location.href = 'SampleProjectCreateGroup.php'"></input> </br>
							<input type="div" value = "Join Study Group" class = "dropdownContent" onclick = "location.href = 'SampleProjectJoinGroup.php'"></input> </br>
							<input type="div" value = "Profile" class = "dropdownContent" onclick = "location.href = 'SampleProjectProfilePage.php'"></input>
						</form>
						</div>
					</div>
				</div>
			</div>
			
			<div id = "topHalf">
				<div id = "dotContainer">
					<div id = "rightSlide" onclick = "goToSlide2()" class = "clickableDot" style = "float: right;">
					</div> 
					<div id = "leftSlide" onclick = "goToSlide1()" class = "clickableDot">
					</div>
				</div>
				
				<?php
					$enteredGroupsHome = array(); //an array of scripts
					$groupsListed = array(); // array of listed groups
					
					for($j = 0; $j < sizeof($joinedGroupIds); $j++)
					{
						$groupsQuery = "SELECT * FROM study_groups WHERE id = '" . $joinedGroupIds[$j] . "';";
						$payoff = mysqli_query($conn, $groupsQuery);
						
						while($groupsEnteredHome = mysqli_fetch_assoc($payoff))
						{
							$groupsListed[] = $groupsEnteredHome;
						}
					}
					
					$b = 0;
					
					for(; $b < sizeof($groupsListed); $b++)
					{
						$hostInfoQuery = "SELECT * FROM users WHERE user_name = '" . $groupsListed[$b]['host'] . "';";
						$effect1 = mysqli_query($conn, $hostInfoQuery);
						$hostInfo1 = mysqli_fetch_assoc($effect1);
					
						if($groupsListed[$b]['end'] != NULL)
						{
							$end = $groupsListed[$b]['end'];
						}
						
						$groupListerScript = "
							var slide1 = document.getElementById(\"slide1\");
							
							var div = document.createElement(\"div\");
							
							div.className = \"displayGroupsJoinedHome\";
							div.style.marginTop = \"1.5%\";
							
							var btn = document.createElement(\"input\");
							btn.type = \"submit\";
							btn.className = \"customizeSmallButton\";
							btn.value = \"View This Group\";
							btn.style.marginTop = \"11%\";
							btn.style.width = \"115px\";
							btn.name = \"group" . $b . "\";
							
							var hostContainer = document.createElement(\"div\");
							hostContainer.className = \"evenDivide\";
							
							var hostImg = document.createElement(\"img\");
							hostImg.src = \"profilePictures/" . $hostInfo1['user_profile_filename'].".".$hostInfo1['profile_file_extension'] . "\";
							hostImg.className = \"roundProfilePic\";
							hostImg.style.height = \"70%\";
							hostImg.style.width = \"45%\";
							hostImg.style.marginTop = \"5%\";
							hostImg.style.marginRight = \"10%\";
							hostImg.style.cssFloat = \"right\";
							
							var p1 = document.createElement(\"p\");
							var p2 = document.createElement(\"p\");
							var p3 = document.createElement(\"p\");
							var p4 = document.createElement(\"p\");
								   
							var hostLabel = document.createTextNode(\" Host: \");
								   
							var studyClass = document.createTextNode(\" Class: " . $groupsListed[$b]['class'] . "\");
							var start = document.createTextNode(\" Start: " . $groupsListed[$b]['start'] . "\");
							var end = document.createTextNode(\" End: " . $end . "\");
								   
							p1.appendChild(hostLabel);
							hostContainer.appendChild(p1);
							hostContainer.appendChild(hostImg);
							
							p2.appendChild(studyClass);
							p3.appendChild(start);
							p4.appendChild(end);
							
							div.appendChild(hostContainer);
							div.appendChild(p2);
							div.appendChild(p3);
							div.appendChild(p4);
							div.appendChild(btn);
							
							slide1.appendChild(div);
						";
						
						array_push($enteredGroupsHome, $groupListerScript);
					}
				
				?>
				
				<div id = "slideContainer">
					<form id = "slide1" action = "" method = "POST" >
						<?php $noGroupsMessage = "<p class = \"defaultMessage\"><em>You Haven't Joined Any Study Groups Yet...</em></p>"; if(sizeof($enteredGroupsHome) === 0){echo $noGroupsMessage;} ?>
					</form>
					<div id = "slide2">
						<p class = "defaultMessage"><em>Chatroom Coming Soon...</em></p>
					</div>
					<div id = "slide3">
						test
					</div>
				</div>
			</div>
			
			<div id = "bottomHalf">
			</div>
		</div>
		<script src = "DropDown.js"></script>
		<script src = "HomepageSlides.js"></script>
		<script>
		<?php
			for($m = 0; $m < sizeof($enteredGroupsHome); $m++)
			{
				echo $enteredGroupsHome[$m];
			}
		?>
		</script>
		<script>
		var slide1 = document.getElementById("slide1");
							var slide3 = document.getElementById("slide3");
						
							slide3.style.display = "block";
							slide1.style.display = "none";
							
							
							var button = document.createElement("button");
							button.className = "customizeSmallButton";
							button.innerHTML = "Back";
							
							slide3.appendChild(button);
							button.onclick = function()
											 {
												location.href = 'SampleProjectHomePage.php';
											 }
							
							var p1 = document.createElement("p");
							var p2 = document.createElement("p");
							 br(1);
							 slide3.appendChild(document.createTextNode("Class: Random"));
							 br(2);
							 slide3.appendChild(document.createTextNode("Location: Locaation"));
							
							/*p1.appendChild(groupClass);
							p2.appendChild(location);*/
							
							var map = document.createElement("div");
							map.style.width = "50%";
							map.style.height = "50%";
							map.style.backgroundColor = "blue";
							slide3.appendChild(map);
							
							//br(1);
							//slide3.appendChild(button);
							//br(1);
							//slide3.appendChild(p1);
							//br(2);
							//slide3.appendChild(p2);
							//br(2);
							//slide3.appendChild(map);
							
							
							function br(numBr)
							{
								for(var i = 0; i < numBr; i++)
								{
									slide3.appendChild(document.createElement("br"));
								}
							}
			<?php for($n = 0; $n < $b; $n++)
					{
						$viewVal = "group" . $n;
						if(isset($_POST[$viewVal]))
						{
					$n = 0;
							echo "
							var slide1 = document.getElementById(\"slide1\");
							var slide3 = document.getElementById(\"slide3\");
						
							slide3.style.display = \"block\";
							slide1.style.display = \"none\";
							
							
							var button = document.createElement(\"button\");
							button.className = \"customizeSmallButton\";
							button.value = \"Back\";
							button.onclick = function()
											 {
												\"location.href = 'SampleProjectHomePage.php'\";
											 }
							
							var p1 = document.createElement(\"p\");
							var p2 = document.createElement(\"p\");
							
							var groupClass = document.createTextNode(\"Class: " . $groupsListed[$n]['class']. "\");
							var location = document.createTextNode(\"Location: " . $groupsListed[$n]['location'] . "\");
							
							p1.appendChild(groupClass);
							p2.appendChild(location);
							
							var map = document.createElement(\"div\");
							map.style.width = \"50%\";
							map.style.height = \"50%\";
							map.style.backgroundColor = \"blue\";
							
							br(1);
							slide3.appendChild(button);
							br(1);
							slide3.appendChild(p1);
							br(2);
							slide3.appendChild(p2);
							br(2);
							slide3.appendChild(map);
							
							
							function br(numBr)
							{
								for(var i = 0; i < numBr; i++)
								{
									slide3.appendChild(document.createElement(\"br\"));
								}
							}
							
							";
						}
					}?>
		</script>
	</body>
</html>