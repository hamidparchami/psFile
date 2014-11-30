<?php
/********************************
 * psFile v0.1
 * Written by Hamid Parchami
 * Email: hamidparchami@gmail.com
 * 29/09/2014
 ********************************/
require_once("includes/processor/pWd_file_functions.php");
if(@(isset($_POST['renameNewFileName']) && $_POST['renameNewFileName'] != "")){
    $renameNewFileName  = $_POST['renameNewFileName'];  //File New Name
    $renameOldFileName  = $_POST['renameOldFileName'];  //File Old Name

    $renameFile = new PsFile;
    //Rename File
    if(@$_POST['type'] == "file"){
    if($renameFile->renameFile($renameOldFileName, $renameNewFileName)){
        echo $renameFile->topDirectory($renameOldFileName);
    }else{
        echo "error";
    }
    //Rename Folder
    }elseif(@$_POST['type'] == "folder"){
        if($renameFile->renameFolder($renameOldFileName, $renameNewFileName)){
            echo $renameFile->topDirectory($renameOldFileName);
        }else{
            echo "error";
        }
    }
}
?>