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
	<style>
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
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- End of Boostrap Css Framework-->
</head>

<body>

	<?php
		//start session
		session_start();
		//get url location
		$urlLocation = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
		
		$dir = $_SESSION["location"];
	
	?>
	
	<p></p>

	<center> <h4> Your movie has been saved successfully </h4> </center>
  
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<p></p>
				
				<!-- Sample movie Frame -->
				<video id="video1" width="220" height="220" class="video" preload="metadata" webkit-playsinline playsinline onended="videoEnd()">
					<source src="<?php echo ($_SESSION["video"])?>#t=2" type="video/mp4">
				</video>
				<!-- ------------->
				<h3>
					<!-- Play button for Video Frame -->
					<button id="playbtn" class="btn" onclick="playPause()"><i class="fa fa-play" id="iconBtn"> Play </i></button>	
				</h3>
			</div>	
			
			<div class="col-sm-auto">
				<!-- Download Video -->
				<a href="<?php echo $_SESSION["video"]?>" download="GreetingVideo.mp4">
					<img alt="ImageName" src="media/images/download.png">
				</a>
				
				<div class="form-group">
					<textarea class="form-control" id="linkdownload" rows="3">http://<?php echo ($urlLocation.$_SESSION["video"]) ?> </textarea>
					
					<button class="btn btn-primary btn-lg" onclick="copyText()" style="float: right;">Copy text</button>
				</div>

			</div>

		</div>
		
	</div>
	
	<center>
	
		<img src="qr.php?text=http://<?php echo ($urlLocation.$_SESSION["video"]) ?>" alt="" style="width:300px;height:300px;" />   
		
		<a href="qr.php?text=http://<?php echo ($urlLocation.$_SESSION["video"]) ?>" download="qrcode.png">
			<img alt="ImageName" src="media/images/mini-download.png">
		</a>
	
	</center>

	<!--  -->
				
	
	<!-- Script Js -->
	<script>
		<!-- Copy Text -->
		function copyText() {
			/* Get the text field */
			var copyText = document.getElementById("linkdownload");

			/* Select the text field */
			copyText.select();
			copyText.setSelectionRange(0, 99999); /* For mobile devices */

			/* Copy the text inside the text field */
			document.execCommand("copy");

			/* Alert the copied text */
			//alert("Copied the text: " + copyText.value);
		}
		<!-- --------------- -->
	

		
		<!-- Play and Stop Video -->
		
		var myVideo = document.getElementById("video1"); 
		
		function videoEnd(){
			//reset button
			document.querySelector('#playbtn').innerHTML = '<i class="fa fa-play" id="iconBtn"> Play </i>';
		}
		
		function playPause() { 
			
			if (myVideo.paused) {
				myVideo.currentTime=0; 
				myVideo.play();
				document.querySelector('#playbtn').innerHTML = '<i class="fa fa-stop" id="iconBtn"> Stop </i>';

			} 
			else {
				myVideo.pause();
				document.querySelector('#playbtn').innerHTML = '<i class="fa fa-play" id="iconBtn"> Play </i>';

			}
		} 
		<!-- --------------- -->
		

	</script>

</body>
</html>
