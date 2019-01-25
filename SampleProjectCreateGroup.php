<?php
	
	session_start();
	
	if(!isset($_SESSION['username']))
	{
		header("Location: ../StudyApp_SampleProject/SampleProjectLoginPage.php");
	}
	
	include 'CreateGroup.php';
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
				<form id = "createGroup" action = "" method = "POST">
					<label>Class:</label></br></br><input class = "customizeInput" type = "text" placeholder = "ex. ENG102" style = "width: 8%;" name = "class"></input> </br> </br> </br>
					<label>Location:</label></br></br><input id = "location" type = "text" placeholder = "ex. Hayden Library, 300 E Orange St, Tempe, AZ 85287, USA" name = "location"></input><!--<input type = "submit" name = "verify_location" style = "visibility: hidden;"><!--This is a sad, temporary fix to the problem of making it possible to search for locations; we should use ajax--></input> </br> </br> 
					<div id = "map"></div> </br> </br> </br>
					<label>Max. Capacity: </label></br></br><input class = "customizeInput" type = "number" min = "2" style = "width: 12%;" name = "max_capacity"></input></br> </br> </br>
					<label>Date:</label></br></br><input id = "day" class = "customizeInput" type = "date" min = <?php echo "\"".date("Y-m-d")."\"";?> value = <?php echo "\"".date("Y-m-d")."\"";?> style = "width: 16%;" required = "required" name = "day"></br></br></br>
					<label>Time:</label></br></br><input class = "customizeInput" type = "time" style = "width: 10.5%;" name = "begin"></input> - <input class = "customizeInput" type= "time" style = "width: 10.5%;" name = "end"></input> <p style = "font-family: Roboto Slab;"><em>(end time optional)</em></p></br></br> </br> 
					<input type = "submit" class = "customizeButton" style = "width: 15%;" value = "Create Study Group" name = "createStudyGroup"></input> </br></br></br></br></br></br></br>
				</form>
			</div>
			
			<div id = "bottomHalf">
			</div>
		</div>
		<script src = "DropDown.js"></script>
		<script>
		  var map;
		  var locationInput = document.getElementById('location');
		  
		  function initMap() // callback function
		  {
			map = new google.maps.Map(document.getElementById('map'), {
																		center: {lat: 33.418950, lng: -111.934539},
																		zoom: 18
																	  });
																	  
			var geocoder = new google.maps.Geocoder();
			
			map.setOptions({draggableCursor: 'default'});
			
			/* The following event listener makes it so that when the user clicks, we add a marker, get that location, reverse geocode it, and put it in the location input*/
			google.maps.event.addListener(map, 'click', function(event) 
			                                            {
															updateLocation({lat:event.latLng.lat(), lng:event.latLng.lng()}); 
															var coord = {lat:event.latLng.lat(), lng:event.latLng.lng()};
															
															geocoder.geocode({'location':coord}, function(results, status)
																								{
																									console.log(status + " " + event.latLng.lat() + ", " + event.latLng.lng());
																									if(status === 'OK')
																									{
																										if(results[0])
																										{
																											if(results[0].formatted_address == null)
																											{
																												locationInput.value = event.latLng.lat() + ", " + event.latLng.lng();
																											}
																											
																											else
																											{
																												locationInput.value = results[0].formatted_address;
																											}
																										}
																										
																										else
																										{
																											console.log("No results");
																										}
																									}
																									else
																									{
																										console.log("Failed due to " + status);
																										locationInput.value = event.latLng.lat() + ", " + event.latLng.lng();
																									}
																								});
														});			
			//new script here (this comment is for debugging purposes)
			
			locationInput.onkeypress = function(e)
												 {
													 var key = e.keyCode;
													 if(key == 13)
													 {
														 geocoder.geocode({'address': locationInput.value}, function(results, status)
																										   {
																											   if(status === 'OK')
																											   {
																												   if(results[0])
																												   {
																														map.setCenter(results[0].geometry.location);
																														updateLocation(results[0].geometry.location);
																												   }
																												   
																											   }
																											   
																											   else
																											   {
																												   console.log("Failed due to " + status);
																												   locationInput.value = "Sorry, server failure. Do file a complaint and we'll fix it as fast as we can...";
																											   }
																										   });
																										   
														 e.preventDefault();
													 }
												 }

			var markers = new Array();
			
			function updateLocation(coord)
			{
				var marker = new google.maps.Marker({position:coord, map:map});
				markers.push(marker);
				
				if(markers.length > 1)
				{
					markers[0].setMap(null);					//setMap places the marker on a map whose name goes in the parenthesis. Here we are saying set the map to nothing (MAKE THE MARKER DISAPPEAR)
					markers[0] = markers[1];
					markers.pop();
				}
			}
		  }
		</script>
		<!--<script src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyAKBoF7WH8D_y9Gg4lKQt55W7uIXyYyJis&callback=initMap"></script>-->
		<!--<script src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDi0n3nInlneUKNf1pSbeYeNOb--KePi4Q&callback=initMap"></script> the free one that worked-->
		<!--<script src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCdkSh8ZdP-vTcNVn6v-kCkt9Hv6wjQPC4&callback=initMap"></script>  Chrystian's Key-->
		<script src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyAe4Y4_tzZjyrTr21BpIKoRRZwa_TzrIOw&callback=initMap"></script>
		<script>
			<?php echo $script; ?>
		</script>
	</body>
</html>