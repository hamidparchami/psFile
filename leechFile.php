<?php
/********************************
 * psFile v0.1
 * Written by Hamid Parchami
 * Email: hamidparchami@gmail.com
 * 29/09/2014
 ********************************/
require_once("includes/processor/pWd_file_functions.php");
if(isset($_GET['leechURL']) && $_GET['leechURL'] != ""){
	$leechURL			= $_GET['leechURL'];          //Desired File URL
	$leechDestination	= $_GET['leechDestination'];  //Destination Directory for Moving File
	if($leechDestination == "") $leechDestination = "uploads/"; //Do Not Change This!!!

	$leechFile = new PsFile;
	$leechFile->leechFileInNewLocation($leechURL, $leechDestination);
}
?>