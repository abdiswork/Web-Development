<?php
	//include framework phpqrcode
	include('phpqrcode/qrlib.php');
	
	//get [GET] Data from caller of php
	$dataText = $_GET['text'];
    
    //generate qr code with text, last 2 numbers are pixels of qr and size of frame qr respectively
    QRcode::png($dataText,false,false, 10,3);

?>
