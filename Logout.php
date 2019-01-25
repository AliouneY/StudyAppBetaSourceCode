<?php
 //always put this file below all the others when including it
	if(isset($_POST['logout']))
	{
		//session_unset();                                                  study this function.............
		session_destroy();
		
		header("Location: ../StudyApp_SampleProject/SampleProjectLoginPage.php");
	}