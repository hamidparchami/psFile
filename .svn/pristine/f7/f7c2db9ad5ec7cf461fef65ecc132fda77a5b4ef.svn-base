<?php
//Check user permission and redirect to login page if not authorized
require_once("includes/processor/pWd_loginFileBased.php");
$login = new loginFileBased();
if(!$login->checkPermission()){
	header("Location: login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Hamid Parchami">
<title>psFile</title>
<script src="includes/js/jquery.min.js"></script>
<script src="includes/js/psFile.js"></script>
<link href="themes/default/css/common.css" rel="stylesheet" type="text/css" />
</head>

<body>
	
<div class="mainContainer">
	<!--Start Left Navigation-->
    <div class="navigation">
        <a href="javascript:void();" id="createFolderLink"><img src="themes/default/images/folder_add.png" width="32" height="32" /> Create Folder</a><br />
        <a href="javascript:void();" id="uploadFilesLink"><img src="themes/default/images/publish.png" width="32" height="32" /> Upload Files</a><br />
        <a href="javascript:void();" id="leechFileLink"><img src="themes/default/images/edit_chain.png" width="32" height="32" /> Leech File</a><br />
        <a href="changePassword.php"><img src="themes/default/images/change_password.png" width="32" height="32" /> Change Password</a><br />
        <a href="logout.php"><img src="themes/default/images/door_out.png" width="32" height="32" /> Logout</a><br />
	</div>
    <!--End Left Navigation-->
    <!--Start Right Container-->
    <div class="rightContainer">
    	<div class="boxHead fileManagerTitle">File manager</div>
		<div id="processResult" class="actionContainer"></div>
        <!--Start Create Folder-->
        <div id="createFolderContainer" class="actionContainer">
        	• Don't use spaces in your folder name.<br />
            • You can create nested folders. Ex: music/rap/eminem<br />
            <input type="text" id="folderName" name="folderName" size="32" />
            <input type="button" id="createFolderButton" class="button" name="createFolderButton" value="Create Folder" />
            <input type="button" class="cancelButton" id="cancelCreateFolderButton" name="cancelCreateFolderButton" value="Cancel" />
        </div>
        <!--End Create Folder-->
        <!--Start Upload Files-->
        <div id="uploadFilesContainer" class="actionContainer">
        	• You can upload multiple files.<br />
            <form id="form1">
              <input type="file" id="files" name="files[]" multiple />
              <input type="hidden" id="mainFolder" name="mainFolder" />
              <input type="submit" name="pWd_Upload" class="button" value="Upload" />
              <input type="button" id="canceluploadFilesButton" class="cancelButton" name="canceluploadFilesButton" value="Cancel" />
            </form>
        </div>
        <!--End Upload Files-->
        <!--Start Leech File-->
      	<div id="leechFileContainer" class="actionContainer">
            URL: <input type="text" id="leechURL" name="leechURL" size="32" />
            <input type="hidden" id="leechDestination" name="leechDestination" />
            <input type="button" id="leechFileButton" class="button" name="leechFileButton" value="Leech File" />
            <input type="button" id="cancelLeechFileButton" class="cancelButton" name="cancelLeechFileButton" value="Cancel" />
      	</div>
        <!--End Leech File-->
		<!--Start Resize Image-->
		<div id="resizeImageContainer" class="actionContainer">
            • The Source file will not change, but a new file will be created with the new dimensions.<hr size="1" />
            <div id="showImageFileName"></div>
			  Width: <input type="text" id="imageWidth" name="imageWidth" size="2" /> px &nbsp; | &nbsp;
              Height: <input type="text" id="imageHeight" name="imageHeight" size="2" /> px
              <input type="hidden" id="imageFile" name="imageFile" /> &nbsp;
              <input type="button" id="resizeImageButton" class="button" name="resizeImageButton" value="Resize Image" />
              <input type="button" id="cancelResizeImageButton" class="cancelButton" name="cancelResizeImageButton" value="Cancel" />
      	</div>
        <!--End Resize Image-->
        <!--Start Rename File-->
        <div id="renameFileContainer" class="actionContainer">
            Name: <input type="text" id="renameNewFileName" name="renameNewFileName" size="32" />
            <input type="hidden" id="renameOldFileName" name="renameOldFileName" /> &nbsp;
            <input type="hidden" id="renameFileType" name="renameFileType" />
            <input type="button" id="renameFileButton" class="button" name="renameFileButton" value="Rename File" />
            <input type="button" id="cancelRenameFileButton" class="cancelButton" name="cancelRenameFileButton" value="Cancel" />
        </div>
        <!--End Rename File-->

        <!--Start Load Files-->
        <div id="showFilesContainer"></div>
        <!--End Load Files-->
    </div>
    <!--End Right Container-->
</div>
</body>
</html>