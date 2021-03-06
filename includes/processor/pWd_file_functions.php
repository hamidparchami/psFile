<?php
/********************************
 * File Process Class
 * Written by Hamid Parchami
 * Email: hamidparchami@gmail.com
 * V0.1 29/09/2014
 ********************************/

class PsFile
{
    /*************************/
    /* Check Directory Slash */
    /*************************/
	function checkDirectorySlash($directory)
	{
		if ($directory != "" && substr($directory, -1) != "/") $directory .= "/";
		return $directory;
	}
    /*******************/
    /*  Create Folder  */
    /*******************/
    function createFolder($folderName, $mainFolder="")
    {
        $mainFolder = $this->checkDirectorySlash($mainFolder);
        $parentFolder = "";
        $msg = "";
        $folderName = explode("/", $folderName);
        for ($i = 0; $i < count($folderName); $i++) {
            if ($folderName[$i] != "") {
                //Create folder if doesn't exists
                if (!file_exists($mainFolder.$folderName[$i])) {
                    if (mkdir($mainFolder.$folderName[$i])) {
                        $msg .= "Folder " . $parentFolder . "<strong>" . $folderName[$i] . "</strong> has been created!<br />";
                    } else {
                        $msg .= "Create folder " . $parentFolder . "<strong>" . $folderName[$i] . "</strong> has been failed!<br />";
                    }
                } else {
                    $msg .= "Folder " . $parentFolder . "<strong>" . $folderName[$i] . "</strong> already exists!<br />";
                }
                $parentFolder .= $folderName[$i]."/";
            }
            //Check the fake index file
            $this->fakeIndexCheck($mainFolder.$folderName[$i]);
            $mainFolder = $mainFolder.$folderName[$i]."/";
        }
        return $msg;
    }
    /*******************/
    /*  Delete File    */
    /*******************/
    function deleteFile($File)
    {
        if (file_exists($File)){
            unlink($File);
            return true;
        } else {
            return false;
        }
    }
    /*******************/
    /*  Delete Folder  */
    /*******************/
    function deleteFolder($Path)
    {
        $Path = $this->checkDirectorySlash($Path);
        $files = glob($Path . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteFolder($file);
            } else {
                unlink($file);
            }
        }
        if (@rmdir($Path)) {
            return true;
        }
    }
    /*******************/
    /** download File **/
    /*******************/
    function downloadFile($filePath, $fileName)
    {
        $filePath = $this->checkDirectorySlash($filePath);
        $pathOnHd = $filePath . $fileName;

        if ($download = fopen($pathOnHd, "r")) {
            $size = filesize($pathOnHd);
            $fileInfo = pathinfo($pathOnHd);
            $ext = strtolower($fileInfo["extension"]);

            switch ($ext) {
                case "pdf":
                    header("Content-type: application/pdf");
                    header("Content-Disposition: attachment; filename=\"{$fileInfo["basename"]}\"");
                    break;
                default;
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: filename=\"{$fileInfo["basename"]}\"");
            }

            header("Content-length: $size");

            while (!feof($download)) {
                $buffer = fread($download, 2048);
                echo $buffer;
            }
            fclose($download);
        }
        exit;
    }
    /********************
     * Check and Create Fake Index
     ********************/
    function fakeIndexCheck($directory, $createFolder=0)
    {
        $sourceFile = dirname(realpath(__FILE__))."/index.php";
        $directory = $this->checkDirectorySlash($directory);
        //Create folder if doesn't exists
        if (!file_exists($directory) && $createFolder == 1) {
            mkdir($directory);
        }
        //Check the fake index file
        if (!file_exists($directory . "index.php")) {
            @copy($sourceFile, $directory . "index.php");
        }
    }
    /*************************/
    /*  Get File Extension   */
    /*************************/
    function getFileExtension($file){
        if(is_file($file)){
            $fileExtension = substr(strtolower($file), -3, 3);
            return $fileExtension;
        }else{
            return false;
        }
    }
    /*********************/
    /* Get Image Height  */
    /*********************/
    function getImageHeight($image){
		$imageHeight = (getimagesize($image));
		$imageHeight = $imageHeight[1];
		return $imageHeight;
	}
    /*********************/
    /*  Get Image Width  */
    /*********************/
    function getImageWidth($image){
        $imageWidth = (getimagesize($image));
        $imageWidth = $imageWidth[0];
        return $imageWidth;
    }
    /*******************/
    /* Create Base URL */
    /*******************/
    function getURL(){
        $URL1 = "http://". $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        $URL = array_reverse(explode("/", $_SERVER['PHP_SELF']));
        $URL = str_replace($URL[0], "", $URL1);
        return $URL;
    }
    /*************************
     * check That is the File an Image or Not
     *************************/
    function isImage($file){
        $AllowedExtensions = "jpg,jpeg,gif,png";
        $AllowedExtensions = explode(",", trim($AllowedExtensions));
        //Check File Type
        if(array_search(substr(strtolower($file), -3, 3), $AllowedExtensions) === false){
            return false;
        }
        return true;
    }
    /****************************************
     * check and Create Last Path in Directory
     ****************************************/
    function lastPath($directory)
    {
        if ($directory != "" && substr($directory, -1) == "/") $directory = substr($directory, 0, strlen($directory)-1);
        $lastDir = substr($directory, strrpos($directory, "/")+1);
        return $lastDir;
    }
    /*******************************/
    /*  Leech File In New Location */
    /*******************************/
    function leechFileInNewLocation($fileSourcePath, $destinationFolder="", $baseFolder = "", $bluePrintLeech=false){
        $MSG = "";
        //Set base folder on script location to store files Ex: uploads/
        $baseFolder = $this->checkDirectorySlash($baseFolder);
        //Receive the file path to copy
        $sourcePath = $fileSourcePath;
        //Explode source path by slash sign (/)
        $explodedSourcePath = explode("/", $sourcePath);
        //Count array keys of source path
        $countExplodedSourcePathKeys = count($explodedSourcePath)-1;

        $starter = 3;

        if($destinationFolder != "" && $bluePrintLeech === false){
            $explodedSourcePath = explode("/", $destinationFolder."/".$explodedSourcePath[$countExplodedSourcePathKeys]);
            $countExplodedSourcePathKeys = count($explodedSourcePath)-1;
            $starter = 0;
        }

        //Check and create needed folders
        for($i=$starter; $i < $countExplodedSourcePathKeys; $i++){
            if(!file_exists($baseFolder . $explodedSourcePath[$i])){
                mkdir($baseFolder . $explodedSourcePath[$i]);
                $this->fakeIndexCheck($baseFolder.$explodedSourcePath[$i]);
                $MSG .= "Folder " . $explodedSourcePath[$i] . " has been created!<br />";
            }
            //Current folder path
            $baseFolder .= $explodedSourcePath[$i] . "/";
        }

        //Create full path for new file location (folders + filename [from the last key of source array])
        $newFileFullPath = $baseFolder . $explodedSourcePath[$countExplodedSourcePathKeys];

        if(!copy($sourcePath, $newFileFullPath)){
            $MSG .= "Uploading file has been failed!<br />";
        }else{
            $MSG .= "The file has been Uploaded!<br />Link: <input type='text' value='".$this->getURL().$newFileFullPath."' size='70' />";
        }

        return $MSG;
    }
    /*****************/
    /* Rename File */
    /*****************/
    function renameFile($oldFileName, $newFileName)
    {
        $dir = $this->topDirectory($oldFileName);
        $newFileName = $this->checkDirectorySlash($dir).$newFileName;
        if(file_exists($newFileName)){
            $newFileName = substr($newFileName, 0, -4)."_".rand().".".$this->getFileExtension($newFileName);
        }
        rename($oldFileName, $newFileName);
        return true;
    }
    /*****************/
    /* Rename Folder */
    /*****************/
    function renameFolder($oldFolderName, $newFolderName)
    {
        $dir = $this->topDirectory($oldFolderName);
        $newFolderName = $this->checkDirectorySlash($dir).$newFolderName;
        if(file_exists($newFolderName)){
            //return "Folder " . $dir . "/<strong>" . $newFolderName . "</strong> already exists!<br />";
            return false;
        }else{
            rename($oldFolderName, $newFolderName);
            return true;
        }
    }
    /*************************/
    /* Create Top Directory  */
    /*************************/
    function topDirectory($directory)
    {
        if ($directory != "" && substr($directory, -1) == "/") $directory = substr($directory, 0, strlen($directory)-1);
        $topDir = substr($directory, 0, strrpos($directory, "/"));
        return $topDir;
    }
    /**************************/
    /* Upload Files(Multiple) */
    /**************************/
	function uploadFiles($mainDirectory, $fileField, $MaxSize, $AllowedExtensions)
	{
		$mainDirectory = $this->checkDirectorySlash($mainDirectory);
		$AllowedExtensions = explode(",", trim($AllowedExtensions));
		$error  = "";
		$msg 	= "";
		$this->fakeIndexCheck($mainDirectory);
		
		foreach($_FILES[$fileField]["error"] as $key => $error){
			$fileName = $_FILES[$fileField]["name"][$key];
			switch($error){
				case UPLOAD_ERR_OK:
					//Check File Type
					if(array_search(substr(strtolower($fileName), -3, 3), $AllowedExtensions) === false){
						$error = sprintf("<strong>%s</strong>: This <strong>file type</strong> is not Allowed!<br />", $fileName);
						$msg  .= $error;
					}
					//Check File Size
					if(($_FILES[$fileField]["size"][$key]/1024/1024) > $MaxSize){
						$error = sprintf("<strong>%s</strong>: This <strong>file size</strong> is not Allowed!<br />", $fileName);
						$msg  .= $error;
					}
					//Check Folder Exist
					if(!file_exists($mainDirectory)){
						if(!mkdir($mainDirectory)){
							$error = "Error creating main directory!<br />";
							$msg  .= $error;
						}else{
							$this->fakeIndexCheck($mainDirectory);
						}
					}
					//Check File Name
					if(file_exists($mainDirectory . $fileName)){
						$newFileName = substr($fileName, 0, -4) . "_" . rand();
						$fileName = $newFileName . "." . substr($fileName, -3, 3);
					}
					//Upload File
					if($error == ""){
						if(@(!move_uploaded_file($_FILES[$fileField]["tmp_name"][$key], $mainDirectory . $fileName))){
							$error = sprintf("Upload <strong>%s</strong> has been failed: Check your disk space or your server setting for max file size!<br />", $fileName);
							$msg  .= $error;
						}
					}
				break;
				/*Upload has been finished successfully*/
				case UPLOAD_ERR_INI_SIZE:
					$error = sprintf("Upload <strong>%s</strong> has been failed: The uploaded file exceeds the upload_max_filesize directive in php.ini!<br />", $fileName);
					$msg  .= $error;
				break;
				case UPLOAD_ERR_FORM_SIZE:
					$error = sprintf("Upload <strong>%s</strong> has been failed: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.<br />", $fileName);
					$msg  .= $error;
				break;
				case UPLOAD_ERR_PARTIAL:
					$error = sprintf("Upload <strong>%s</strong> has been failed: The uploaded file was only partially uploaded!<br />", $fileName);
					$msg  .= $error;
				break;
				case UPLOAD_ERR_NO_FILE:
					$error = sprintf("Upload <strong>%s</strong> has been failed: No file was uploaded!<br />", $fileName);
					$msg  .= $error;
				break;
				case UPLOAD_ERR_NO_TMP_DIR:
					$error = sprintf("Upload <strong>%s</strong> has been failed: Missing a temporary folder!<br />", $fileName);
					$msg  .= $error;
				break;
				case UPLOAD_ERR_CANT_WRITE:
					$error = sprintf("Upload <strong>%s</strong> has been failed: Failed to write file to disk!<br />", $fileName);
					$msg  .= $error;
				break;
				case UPLOAD_ERR_EXTENSION:
					$error = sprintf("Upload <strong>%s</strong> has been failed: A PHP extension stopped the file upload!<br />", $fileName);
					$msg  .= $error;
				break;
			}
		}
		return $msg;
	}

    /*****************/
    /* Write to File */
    /*****************/
    function writeToFile($fileName, $fileContent)
    {
		$OpenFile = fopen($fileName, 'w');
		@fwrite($OpenFile, $fileContent);
		fclose($OpenFile);
		return true;
    }
}
?>