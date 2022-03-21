<!DOCTYPE html>
<html lang="en">
<head>
	<!-- TITLE PAGE -->
	<title>Short Movie</title>
	<!-- Character Encoding -->
	<meta charset="utf-8">
	<!-- Boostrap Relative Layout -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Boostrap Css Framework-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- End of Boostrap Css Framework-->

	<link rel="shortcut icon" href="media/images/favicon.ico">
	 
	<style>
		
		* {box-sizing: border-box;}
		.container {
		  position: relative;
		 
		}
		
		
		.video{
			
			object-fit:cover;
			object-position:center;
		}

		.overlay {
		  position: absolute; 
		  height: 220px;
		  width: 220px;
		  top: 0; 
		  bottom: 0; 
		  color: #f1f1f1; 
		  color: white;
		  text-align: center;
		  box-shadow: 10px 10px 5px #ccc;
		  -moz-box-shadow: 10px 10px 5px #ccc;
		  -webkit-box-shadow: 10px 10px 5px #ccc;
		  -khtml-box-shadow: 10px 10px 5px #ccc;		  
		}

	
		.btn {
		  background-color: DodgerBlue;
		  border: none;
		  color: white;
		  padding: 2px 16px;
		  font-size: 16px;
		  cursor: pointer;
		}

		/* Darker background on mouse-over */
		.btn:hover {
		  background-color: RoyalBlue;
		}
	</style>
	
	
</head>

<body>
	<?php 
		//get frame id from previous page by POST
		$frame = $_POST['frame'];
		
		//start session
		session_start();
		
		//check if they have previous unique ID, if not, create one unique ID
		if(!isset($_SESSION['uniqID'])){
			$uniqID = uniqid('', true);
			$_SESSION['uniqID'] = $uniqID;	
		}
		else
			$uniqID = $_SESSION['uniqID'];
		
	?>
	<p></p>
	
	
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
			
				<!-- Title -->
				<h3><p id="caption">Sample Movie</p></h3>
				
				<!-- Sample movie Frame -->
				<div class="container">
					<video id="video" width="220" height="220" class="video" preload="metadata" onloadstart="this.volume=0.5" webkit-playsinline playsinline onended="resetAudioButton()">
						<source src="http://153.127.70.212/media/templates/sample.mp4#t=0.01" type="video/mp4" id="videosrc">
					</video>
					<div class="overlay"><img src="media/templates/<?php echo $frame?>.png" alt="Avatar" class="image" width="220" height="220"></div>
				</div>
				<!-- ------------->
				
				<br> <br>
			</div>
		   
			<div class="col-sm-auto">
			
			<!-- Form Html for Posting Data -->
			<form id="form" method="POST" enctype="multipart/form-data" >
			
				<p></p> <br> <br>
				
				<!-- File Uploading -->
				<input id="fileupload" type="file" name="file" onChange="uploadFile()" required>
				
				
				<p></p>
				<!-- Radio button 1 -->
				<div>
					<input type="radio" id="music1" name="option" value="music1" checked>
					<label for="music1"> Music A </label>
					<button class="btn" onclick="playVid('1')" type="button"><i class="fa fa-play" id="1"></i></button> Listen <br>
				</div>
				<br>
				<!-- Radio button 2 -->
				<div>
					<input type="radio" id="music2" name="option" value="music2">
					<label for="music2"> Music B </label>
					<button class="btn" onclick="playVid('2')" type="button"><i class="fa fa-play" id="2"></i></button> Listen <br>
				</div>
				<br>
				<!-- Radio button 3 -->
				<div>
					<input type="radio" id="music3" name="option" value="music3">
					<label for="music3"> Music C </label>
					<button class="btn" onclick="playVid('3')" type="button"><i class="fa fa-play" id="3"></i></button> Listen <br>
				</div>
				
				
				<!-- Hidden data -->
				<input type="hidden" id="uniqid" name="uniqid" value="<?php echo $uniqID?>">
				<input type="hidden" id="frame" name="frame" value="<?php echo $frame?>">
				
				
				
			</div>
		</div>
	</div>
	
	<!-- Save / Submit Video -->
	<h3><center><button type="submit" class="btn btn-outline-secondary" name="submit" value="Upload">Save New Movie</button></center></h3>
				
	</form>
	<!-- End of Form -->
	<center> <div id="info"> </div> </center>
	<center><img id="loading" src="media/images/loading.gif" width="100" height="100" style="visibility:hidden;"/></center>
	
	
	
	<!-- Audio Player -->
	<audio id="audio" loop>
		<source src="media/music/music1.wav" />
	</audio>
	
	
	<script>
		//this is to get the form ID
		var myForm = document.getElementById('form');
		
		//this is a variable to check if submit button has clicked
		var subActive = false;
		
		//this used for timer purpose
		var timer;

		//function to check if the file is exist, this aims to check if video has been processed
		function doesFileExist(urlToFile) {
			var xhr = new XMLHttpRequest();
			xhr.open('HEAD', urlToFile, false);
			xhr.send();
			 
			if (xhr.status == "404") {
				return false;
			} else {
				return true;
			}
		}

		//a callback function that will be called if the video is convertig (convert.php is called)
		function callAPI() {
			//console.log("waiting");
			
			//get unique directory value for file checking purpose
			var uniqueID = document.getElementById('uniqid').value;
			
			//make full path of file
			var pathFile = "uploads/"+uniqueID+"/result.mp4";
			
			//check if the file of result.mp4 is exist, if yes, it will be true, if no, it will be else	
			var result = doesFileExist(pathFile);
			
			//check if result.mp4 file is exist, then process has been completed, for other else if, it only used for progression purpose (0-100)
			if(result){
				document.getElementById("info").innerText = "Completed";
				//go to resutlt.php
				location.replace("result.php")
			}
			else if(doesFileExist("uploads/"+uniqueID+"/fade.mp4")){
				document.getElementById("info").innerText = "Processing Video 80 / 100";
			}
			else if(doesFileExist("uploads/"+uniqueID+"/framevideo.mp4")){
				document.getElementById("info").innerText = "Processing Video 60 / 100";
			}
			else if(doesFileExist("uploads/"+uniqueID+"/scale.mp4")){
				document.getElementById("info").innerText = "Processing Video 60 / 100";
			}
			else if(doesFileExist("uploads/"+uniqueID+"/crop2.mp4")){
				document.getElementById("info").innerText = "Processing Video 20 / 100";
			}
			
		}
		
		//to check submit button
		myForm.onsubmit = function(e) {
			
			e.preventDefault();
			$.ajax({
				
				url: "upload.php",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend : function()
				{
					if(subActive){
						//console.log("Video is Processed, Please Wait");
						//stop if the video is already submitted or processed, this to stop multiple submit
						return;
					}
					else
						subActive=true;
					
					//show text message for uploading process
					document.getElementById("info").innerText = "Please Wait, Uploading Video";
					document.getElementById("loading").style.visibility = "visible";
				},
				success: function(data)
				{
					
					
					//show the progress
					document.getElementById("info").innerText = "Processing Video 0 / 100";
					
					//call function callAPI for callback to wait the video process completed
					timer = setInterval(callAPI, 1000);
					
					
				},
				error: function(e) 
				{
					//alert(e);
					document.getElementById("info").innerText = "Status : " + e;
				}          
			});
		}
		
		//reset all button of audo player to play button	
		function resetAudioButton(){
			//button change layout effect
			for (i = 1; i <= 3 ; i++) {
				btnPlay = document.getElementById(i);
				btnPlay.className="fa fa-play";
			}
		}
		
		//get audio and video element in HTML
		var vid = document.getElementById("video"); 
		var aud = document.getElementById("audio"); 
		
		
		//variable to handle playing music url
		var musicUrl;
		
		function playVid(music) { 
			
			btnPlay = document.getElementById(music);
			
			//reset all button that makes all button icon become play button
			resetAudioButton();
			
			//check if the button clicked is playing a audio, therefore we pause audio
			if(musicUrl==music && !aud.paused){
				
				vid.pause();
				aud.pause();
			}
			else{
				
				//button change layout effect
				btnPlay = document.getElementById(music);
				btnPlay.className="fa fa-stop";
				
				//save the current music url
				musicUrl = music;
				
				//pause audio and video
				vid.pause();
				aud.pause();
				
				//load the music
				aud.setAttribute('src', "media/music/music"+music+".wav");
				aud.load();
				
				//play the video and audio
				vid.currentTime=0; 
				vid.play();
				aud.play();
				
				//make radio button of playing audio is selected
				var selectedRadio = document.getElementById('music'+music);
				selectedRadio.checked = true;
					
			}
		} 

		
		//used to stop video if more than 10 second
		var checkvid = document.getElementById('video');
		checkvid .addEventListener("timeupdate", CheckTime)
		var maxTime = 10;

		function CheckTime(){
  			if(checkvid.currentTime >= maxTime){
    				//pause video and audio
				vid.pause();
				aud.pause();
				resetAudioButton();
  			}
		}	
	
		
		//this is used to check uploaded video
		async function uploadFile() {
			
			//Replace Text for captiion
			document.getElementById('caption').innerText = "Your Movie";
			
			//pause video and audio
			vid.pause();
			aud.pause();
			resetAudioButton();
			
			var player = document.getElementById("video");
			var currentVID = document.getElementById("videosrc");
			var selectedLocalVID = document.getElementById("fileupload").files[0];
			
			//check if there is no video selected
			if (document.getElementById("fileupload").value == "")
			{
				console.log("Cancelled Selected");
				return;
			}
			
			//check if the file size is exceeding 300 MB
			if (selectedLocalVID.size > 314572800)
			{
				alert("File Size Is Exceed The Maximum 300 MB");
				
				//reset form 
				this.form.reset();
				return;
			}
			

			//load the video
			currentVID.setAttribute("src", URL.createObjectURL(selectedLocalVID));
			player.load();
		}
	
	</script>

</body>
</html>
