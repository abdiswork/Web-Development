<?php
	set_time_limit(0);

	//load selected music
	$music = $_POST['option'];
		
	//uniqueID
	$uniqueID = $_POST['uniqid'];
		
	//load selected frame
	$frame = $_POST['frame'];
	
	//load selected file
	$file = $_FILES['file'];
	
	//load file details	
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];
	
	//get extension file
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	
	//array of allowed extention (allowed extension is only in array, if there any or limit some extension, please add or remove) 
	$allowed = array('m4v', 'mp4', 'mov', 'ogg', 'webm', 'mkv', '3gp');
	
	//check if extension in array (white list extension)
	if (in_array($fileActualExt, $allowed)){
		//if there is no error
		if ($fileError === 0 ){
			
			//get extension of file and set the name to the "original"
			$fileNameNew = "original.".$fileActualExt;
			
			//create random unique directory name
			$dirLoc = "uploads/".$uniqueID;
			
			//create the directory
			if (!file_exists($dirLoc)){
				mkdir($dirLoc);
				chmod ($dirLoc , 0775);
			}
			else{
				$files = glob($dirLoc."/*");
				foreach($files as $file)
				{ 
				
					unlink($file);
					
				} 
			}
			
			//upload destination file
			$fileDestination = $dirLoc.'/'.$fileNameNew;
			move_uploaded_file($fileTmpName, $fileDestination);
			chmod ($fileDestination, 0775);
			
			session_start();
			//save video location
			$_SESSION["location"] = $dirLoc;
					
			// Storing session for video location data
			$_SESSION["video"] = $dirLoc."/result.mp4";
			
			$command = "php convert.php ".$dirLoc." ".$music." ".$frame." ".$fileActualExt." > /dev/null &";
			
			exec($command);

			echo "success";
		}
		else{
			
			echo "there is an error uploading your file";
		}
	}
	else{
		echo "file extension is not appropriate";
	}
?>