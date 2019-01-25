<?php
	
	$messageScript = ""; //message script: script that outputs alerts based on the error or success of the user's actions
	
	if(isset($_POST['addClass']))
	{
		include_once 'connect.php';
		
		$user = $_SESSION['username'];
		$class = mysqli_real_escape_string($conn, $_POST['class']);
		$first = mysqli_real_escape_string($conn, $_POST['first']);
		$last = mysqli_real_escape_string($conn, $_POST['last']);
		$gender = $_POST['gender'];
		$begin = $_POST['begin'];
		$end = $_POST['end'];
		
		if(!empty($class) && !empty($first) && !empty($last) && !empty($begin) && !empty($end))
		{
			if(validateClassName($class))
			{
				$class = filterClassName($class);
				$query = "INSERT INTO classes (user, class, instructor_first, instructor_last, gender, start_time, end_time) VALUES ('$user', '$class', '$first', '$last', '$gender', '$begin', '$end');";
				
				mysqli_query($conn, $query);
				
				$messageScript = "<script>alert(\"Class Successfully Added!\");</script>";
			}
			
			else
			{
				$messageScript = "<script>alert(\"Error Occurred: Invalid Class Name\");</script>";
			}
		}
		
		else
		{
			$messageScript = "<script>alert(\"Error Occurred: Empty Fields\");</script>";
		}
	}
	
	function filterTime() //this should eventually display the time in a way that the user can understand (with am, pm, and 12 hour cycles)
	{
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
	