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
	
		img {
			border: 3px solid #555;
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
		
		/* HIDE RADIO */
		[type=radio] { 
		  position: absolute;
		  opacity: 0;
		  width: 0;
		  height: 0;
		}

		/* IMAGE STYLES */
		[type=radio] + img {
		  cursor: pointer;
		}

		/* CHECKED STYLES */
		[type=radio]:checked + img {
		  outline: 2px solid #f00;
		}
	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- End of Boostrap Css Framework-->
</head>

<body>

<p><br><br><br><br></p>

<center>
	<h1>Select Template</h1>
	
	<form method="POST" action="frame.php">
	
		<label>
			<input type="radio" name="frame" value="frame1" checked>
			<img src="media/templates/frame1.png" width="200" height="200" style="background-color:#EBEBEB;">
		</label>

		<label>
		  <input type="radio" name="frame" value="frame2">
		  <img src="media/templates/frame2.png" width="200" height="200" style="background-color:#EBEBEB;">
		</label>
		
		<label>
		  <input type="radio" name="frame" value="frame3">
		  <img src="media/templates/frame3.png" width="200" height="200" style="background-color:#EBEBEB;">
		</label>
		
		<p></br>		
		<button type="submit" class="btn btn-outline-secondary" name="submit">Select</button>
	</form>

</center>

</body>
</html>
