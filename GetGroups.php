<?php
	
	include 'GetClasses.php';
	
	
	$advertisedGroups = array(); //an array of scripts
	$groupsJoined = array(); //array of rows from study_group_members
	$joinedGroupIds = array(); //array of ids of groups joined
	$groupClicked = array(); //this array holds a single element: the id of the group clicked
	
	//==============================================================================================================================================
	$query = "SELECT * FROM study_group_members WHERE member = '" . $user . "';";
	$outcome = mysqli_query($conn, $query);
	$numGroupsJoined = mysqli_num_rows($outcome);
	
	$jj = 0;
	
	while($joinedGroups = mysqli_fetch_assoc($outcome)) // puts all groups already joined into an array called $groupsJoined
	{
		$groupsJoined[] = $joinedGroups;
		array_push($joinedGroupIds, $groupsJoined[$jj]['group_id']);
		++$jj;
	}
	//==============================================================================================================================================
	
	$groupsOfThisClass = array();
	$rowsFetched = 0;
	$whatIdsToExclude = "";
	
	for($kk = 0; $kk < sizeof($joinedGroupIds); $kk++)
	{
		$whatIdsToExclude = $whatIdsToExclude . " AND id != '" . $joinedGroupIds[$kk] . "'";
	}
	
	
	for($j = 0; $j < sizeof($userClasses); $j++) //loops through all classes the user is taking; for each class, get all study groups whose class match that class...
	{
		$query = "SELECT * FROM study_groups WHERE class = '". $userClasses[$j]['class'] . "'" . $whatIdsToExclude . ";";
		$results = mysqli_query($conn, $query);
		$rowsFetched = mysqli_num_rows($results);
		
		
		while($groups = mysqli_fetch_assoc($results))
		{
			$groupsOfThisClass[] = $groups;  			//                   ...put all those study groups into a 2d associative array called $groupsOfThisClass
		}
	}

	for($k = 0; $k < sizeof($groupsOfThisClass); $k++) //this loops through $groupsOfThisClass array; each row retrieved is its own associative array
			{
				$query = "SELECT * FROM users WHERE user_name = '" . $groupsOfThisClass[$k]['host'] . "';"; // from here...
				$outcome = mysqli_query($conn, $query);
				$hostInfo = mysqli_fetch_assoc($outcome);                                                    // ...to here just gets information about the host for the sole purpose of getting the profile picture; otherwise it's irrelevant
				
				$end = "";
				
				if($groupsOfThisClass[$k]['end'] != NULL)
				{
					$end = $groupsOfThisClass[$k]['end'];
				}
				
				$listScript = "var advertisedGroupList = document.getElementById(\"advertisedGroupList\");
							   var div = document.createElement(\"div\");
							   div.className = \"listedInfo displayGroupInfo\";
							   
							   var hostContainer = document.createElement(\"div\");
							   hostContainer.className = \"evenDivide\";
							   
							   var btn = document.createElement(\"input\");
							   btn.type = \"submit\";
							   btn.className = \"customizeSmallButton\";
							   btn.value = \"Join\";
							   btn.style.marginTop = \"11%\";
							   btn.name = \"join" . $k . "\";
							   
							   var hostImg = document.createElement(\"img\");
							   hostImg.src = \"profilePictures/" . $hostInfo['user_profile_filename'].".".$hostInfo['profile_file_extension'] . "\";
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
							   
							   var studyClass = document.createTextNode(\" Class: " . $groupsOfThisClass[$k]['class'] . "\");
							   var start = document.createTextNode(\" Start: " . $groupsOfThisClass[$k]['start'] . "\");
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
							   
							   advertisedGroupList.appendChild(div);";
							   
							   array_push($advertisedGroups, $listScript);
							   
			}