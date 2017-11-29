<?php
	//display error 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	echo "Study " . $_GET['file'];

	$file = $_GET['file'];
	//$filename = 'Customfile.pdf'; /* Note: Always use .pdf at the end. */

	header('Content-type: application/pdf');
	// header('Content-Disposition: inline; filename="' . $filename . '"');
	header('Content-Disposition: inline; filename="' . $file . '"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($file));
	header('Accept-Ranges: bytes');

	@readfile($file);
?>
