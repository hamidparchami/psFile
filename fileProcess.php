<?php
/********************************
 * psFile v0.1
 * Written by Hamid Parchami
 * Email: hamidparchami@gmail.com
 * 29/09/2014
 ********************************/
require_once("includes/processor/pWd_file_functions.php");
$file = new PsFile();
if(@$_GET['action'] == "createFolder"){
    echo $file->createFolder($_GET['folderName'], $_GET['mainFolder']);
}
if(@($_POST['action'] == "deleteObject" && $_POST['objectType'] == "folder")){
	if($file->deleteFolder($_POST['object']))
		echo $file->topDirectory($_POST['object']);
	else
		echo "error";
}
if(@($_POST['action'] == "deleteObject" && $_POST['objectType'] == "file")){
	if($file->deleteFile($_POST['object']))
		echo $file->topDirectory($_POST['object']);
	else
		echo "error";
}