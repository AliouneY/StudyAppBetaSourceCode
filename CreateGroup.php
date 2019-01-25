<?php

	$script = "";

	if(isset($_POST['createStudyGroup']))
	{
		include_once 'connect.php';
		
		$user = $_SESSION['username'];
		$class = mysqli_real_escape_string($conn, $_POST['class']);
		$location = mysqli_real_escape_string($conn, $_POST['location']);
		$capacity = mysqli_real_escape_string($conn, $_POST['max_capacity']);
		$date = $_POST['day'];
		$start = $_POST['begin'];
		$end = $_POST['end'];
		
		if(!empty($class) && !empty($location) && !empty($capacity) && !empty($date) && !empty($start))
		{
			$query = "SELECT * FROM study_groups WHERE host = '$user' AND date = '$date' AND start = '$start';"; //here we make sure that the user can't create multiple study groups of the same time period (develop further)
			$result = mysqli_query($conn, $query);
			$resultCheck = mysqli_num_rows($result);
			
			if($resultCheck === 0)
			{
				if(empty($end))
				{
					if(validateClassName($class))
					{
						if($_POST['location'] != "Sorry, server failure. Do file a complaint and we'll fix it as fast as we can...")
						{
							$class = filterClassName($class);
							
							$query = "INSERT INTO study_groups (class, host, location, capacity, date, start) VALUES ('$class', '$user', '$location', '$capacity', '$date', '$start');";
							
							if(mysqli_query($conn, $query))
							{
								include_once 'connect.php';
								
								$query = "SELECT * FROM study_groups WHERE host = '$user' AND date = '$date' AND start = '$start' AND end = '$end';";
								$result = mysqli_query($conn, $query);
								$resultCheck = mysqli_num_rows($result);
								
								$groupInfo = mysqli_fetch_assoc($result);
								
								$query = "INSERT INTO study_group_members (group_id, member, host_status) VALUES ('" . $groupInfo['id'] . "', '" . $groupInfo['host'] . "', 1);";
								mysqli_query($conn, $query);
							}
							
							
							$script = "alert(\"You Have Successfully Added A New Study Group\");";
						}
						
						else
						{
							$script = "alert(\"Invalid Address\");";
						}
					}
					
					else
					{
						$script = "alert(\"Invalid Class Name\");";
					}
				}
				
				else
				{
					if(validateClassName($class))
					{
						if($_POST['location'] != "Sorry, server failure. Do file a complaint and we'll fix it as fast as we can...")
						{
							$class = filterClassName($class);
							
							$query = "INSERT INTO study_groups (class, host, location, capacity, date, start, end) VALUES ('$class', '$user', '$location', '$capacity', '$date', '$start', '$end');";
							
							if(mysqli_query($conn, $query))
							{
								include_once 'connect.php';
								
								$query = "SELECT * FROM study_groups WHERE host = '$user' AND date = '$date' AND start = '$start' AND end = '$end';";
								$result = mysqli_query($conn, $query);
								$resultCheck = mysqli_num_rows($result);
								
								$groupInfo = mysqli_fetch_assoc($result);
								
								$query = "INSERT INTO study_group_members (group_id, member, host_status) VALUES ('" . $groupInfo['id'] . "', '" . $groupInfo['host'] . "', 1);";
								mysqli_query($conn, $query);
							}

							$script = "alert(\"You Have Successfully Added A New Study Group\");";
						}
						
						else
						{
							$script = "alert(\"Invalid Address\");";
						}
					}
					
					else
					{
						$script = "alert(\"Invalid Class Name\");";
					}
				}
			}
			
			else
			{
				$script = "alert(\"You Already Created A Group For This Day And Time\");";
			}
		}
		
		else
		{
			$script = "alert(\"Empty Fields!\");";
		}
	}
	
	function filterClassName($className)
	{
		for($i = 0; $i < strlen($className); $i++)
		{
			if($className[$i] === " ") // this erases the space from the class name
			{
				if($i === (strlen($className) - 1))
				{
					$className = substr($className, 0, -1);
					--$i;
				}
				
				else if($i < (strlen($className) - 1))
				{
					for($j = $i; $j < (strlen($className) - 1); $j++)         
					{
						$className[$j] = $className[$j+1];
					}
					$className = substr($className, 0, -1);
					--$i;
				}
			} 
		}
		return $className;
	}
	
	function validateClassName($className) //checks if class name is valid...should have three characters, three digits 
	{
		$isValid = false;
		$numDigits = 0;
		$numChars = 0;
		$numLettersInRow = 0;
		
		for($i = 0; $i < strlen($className); $i++)
		{
			if($className[$i] === " ") // this erases the space from the class name
			{
				if($i === (strlen($className) - 1))
				{
					$className = substr($className, 0, -1);
					--$i;
				}
				
				else if($i < (strlen($className) - 1))
				{
					for($j = $i; $j < (strlen($className) - 1); $j++)         
					{
						$className[$j] = $className[$j+1];
					}
					$className = substr($className, 0, -1);
					--$i;
				}
			} 
		}
		
		for($i = 0; $i < strlen($className); $i++)
		{
			if(ctype_digit($className[$i])) //checks if it's a digit. If so, count it
			{
				++$numDigits;
			}
			
			else if(ctype_alpha($className[$i])) //else, if it's a letter (not special character) it's to be counted as a letter
			{
				strtoupper($className[$i]);
				++$numChars;
			}
		}
		
		if(strlen($className) === 6 && $numDigits === 3 && $numChars === 3) //if letters and numbers are both 3
		{
			for($i = 0; $i < 3; $i++)
			{
				if(ctype_alpha($className[$i])) //and if the first three characters are letters (necessarily making the last three numbers)...
				{
					++$numLettersInRow;
				}
			}
			
			if($numLettersInRow === 3)
			{
				$isValid = true; //class name is valid
			}
		}
		
		return $isValid;
	}