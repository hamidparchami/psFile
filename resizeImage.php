<?php
/********************************
 * psFile v0.1
 * Written by Hamid Parchami
 * Email: hamidparchami@gmail.com
 * 29/09/2014
 ********************************/
require_once("includes/processor/pWd_image_functions.php");
if(isset($_POST['imageFile'])){
	$imageFile      = $_POST['imageFile'];   //Image File
	$width          = $_POST['imageWidth'];  //Width For New Image Size
	$height			= $_POST['imageHeight']; //Height For New Image Size

	$resizeImage = new pWd_image;
	$resizeImage->thumbnail($imageFile, "", $width, $height, ""); //Create a New and Resized Image
	$mainDirectory = $resizeImage->topDirectory($_POST['imageFile']);
	echo $mainDirectory; //Print Image Processing Result
}
?>