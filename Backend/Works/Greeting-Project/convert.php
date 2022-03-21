<?php

	//parameter loader
	$dirLoc = $argv[1]; //used for random directory location
	$music = $argv[2]; //used for selected music index by user
	$frame = $argv[3]; //used for selected frame index by user
	$ext = $argv[4]; //used for identifiying video extension
	
	/////////////////////FFMPEG Process ///////////////////////////
					
	//create watermark video
	$fileWatermark = 'media/watermark/watermark.mp4';
	if (!file_exists($fileWatermark)){
		echo "missing";
		#create watermark
		$watermark = shell_exec("ffmpeg -loop 1 -s 640x640 -i media/watermark/watermark.png -s 640x640 -pix_fmt yuv420p -t 1 media/watermark/watermark.mp4");
	}
	
	#get video length
	$getVidLength = shell_exec ("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ".$dirLoc."/original.".$ext." 2>&1");
	$length = floor($getVidLength);
	if ($length > 10)
		$length = 10;
	/////////////////////////
	
	#crop Length
	//$cropLength = shell_exec("ffmpeg -ss 00:00:00 -i ".$dirLoc."/original.".$ext." -to 00:00:".$length." -c:v copy -c:a aac ".$dirLoc."/crop.mp4");
	$cropLength = shell_exec("ffmpeg -i ".$dirLoc."/original.".$ext." -ss 00:00:00 -t 00:00:".$length." -async 1 ".$dirLoc."/crop.mp4");
	chmod ($dirLoc."/crop.mp4" , 0775);
	////////////////////////
	
	#add fake audio
	#check If Audio is exist
	$audcheck = shell_exec ("ffprobe -i ".$dirLoc."/crop.mp4 -show_streams -select_streams a -loglevel error 2>&1");
	$hasAudio=true;
	
	if($audcheck=="" || $audcheck==null)
		$hasAudio=false;
	else
		$hasAudio=true;
	
	if($hasAudio){
		rename($dirLoc."/crop.mp4",$dirLoc."/crop2.mp4");
	}
	else{
		$fakeaduio = shell_exec("ffmpeg -f lavfi -i anullsrc=channel_layout=stereo:sample_rate=44100 -i ".$dirLoc."/crop.mp4 -c:v copy -strict experimental -c:a aac -shortest ".$dirLoc."/crop2.mp4");
		chmod ($dirLoc."/crop2.mp4" , 0775);
	}
	////////////////////////
	
	#Video Scaling
	$convertScale = shell_exec("ffmpeg -i ".$dirLoc."/crop2.mp4 -threads 7 -preset veryfast -vf \"scale=640:640:force_original_aspect_ratio=increase,crop=640:640\" ".$dirLoc."/scale.mp4");
	chmod ($dirLoc."/scale.mp4" , 0775);
	////////////////////////
	
	#Add frame to the video
	$frameVideo = shell_exec("ffmpeg -i ".$dirLoc."/scale.mp4 -i media/templates/".$frame.".png -filter_complex \"[0:v][1:v] overlay=W-w:H-h:\" -pix_fmt yuv420p -threads 7 -preset veryfast -c:a copy ".$dirLoc."/framevideo.mp4");
	chmod ($dirLoc."/framevideo.mp4" , 0775);
	///////////////////////
	
	#lower uploaded video audio volume
	$lowerVolume = shell_exec("ffmpeg -i ".$dirLoc."/framevideo.mp4 -filter:a \"volume=0.5\" ".$dirLoc."/lowvolume.mp4");
	chmod ($dirLoc."/lowvolume.mp4" , 0775);
	///////////////////////
	
	#merge audio and video
	$mergeAudioVideo = shell_exec("ffmpeg -i ".$dirLoc."/lowvolume.mp4 -i media/music/".$music.".wav -filter_complex \"[0:a][1:a]amerge=inputs=2[a]\" -map 0:v -map \"[a]\" -c:v copy -ac 2 -shortest ".$dirLoc."/audcombine.mp4");
	chmod ($dirLoc."/audcombine.mp4" , 0775);
	///////////////////////
	
	$vidFade = $length-2;
	$audFade = $length-5;
	
	#fadeout
	$fadeout = shell_exec("ffmpeg -i ".$dirLoc."/audcombine.mp4 -filter_complex \"[0:v]fade=t=out:st=".$vidFade.":d=2[v]; [0:a]afade=t=out:st=".$audFade.":d=3[a]\" -map \"[v]\" -map \"[a]\" -threads 7 -preset veryfast ".$dirLoc."/fade.mp4");
	chmod ($dirLoc."/fade.mp4" , 0775);
	///////////////////////
	
	#Merge video with watermark
	$mergeVideo = shell_exec("ffmpeg -i ".$dirLoc."/fade.mp4 -i media/watermark/watermark.mp4 -f lavfi -i color=s=640x640:r=30 -filter_complex \"[0]scale=640x640:force_original_aspect_ratio=decrease[vid1];[1]scale=640x640:force_original_aspect_ratio=decrease[vid2];[2][vid1]overlay=x='(W-w)/2':y='(H-h)/2':shortest=1[vid1];[2][vid2]overlay=x='(W-w)/2':y='(H-h)/2':shortest=1[vid2];[vid1][vid2]concat=n=2:v=1:a=0,setsar=1\" ".$dirLoc."/final.mp4");
	chmod ($dirLoc."/final.mp4" , 0775);
	///////////////////////
	
	//rename
	rename($dirLoc."/final.mp4",$dirLoc."/result.mp4");
	
?>
