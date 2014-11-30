<?php
/********************************
 * psFile v0.1
 * Written by Hamid Parchami
 * Email: hamidparchami@gmail.com
 * 29/09/2014
 ********************************/
/** File and Folder Processing Object **/
require_once("includes/processor/pWd_file_functions.php");
require_once("includes/processor/pWd_common_functions.php");
$fileObject = new PsFile();

/** Login Object **/
require_once("includes/processor/pWd_loginFileBased.php");
$login = new loginFileBased();

/** Start read directory and sort files and folders **/
$ac_sw1 = 0;
$dir = $_GET['folderName'];
$topDir = $fileObject->topDirectory($dir);

$directories = array();
$files_list  = array();
$files = scandir($dir);
foreach($files as $file){
   if(($file != '.') && ($file != '..') && ($file != "index.php")){
	  if(is_dir($dir.'/'.$file)){
		 $directories[]  = $file;

	  }else{
		 $files_list[]    = $file;

	  }
   }
}
natcasesort($directories);
natcasesort($files_list);
$fileID = 1;
/** End read directory and sort files and folders **/

/** Check user permission and redirect to login page if not authorized **/
if($login->checkPermission()){
?>
<div class="fileManagerToolbar">
<?php if($topDir != ""){ ?>
    <div class="upLinkContainer">
        <a id="upDirectory" href="javascript:void();" onclick="javascript:openFolder('<?php echo $topDir; ?>');"><img src="themes/default/images/folder-up.png" /> Up One Level</a>
    </div>
<?php } ?>
    <div class="currentFolderContainer" id="currentFolder"><a id="homeDirectory" href="javascript:void();" onclick="javascript:openFolder('uploads');" title="Home"><img src="themes/default/images/go-home.png" /></a><?php echo str_replace("uploads", " ", $_GET['folderName']); ?>:</div>
</div>
<div class="showFilesTable" style="overflow:auto;">
    <div class="showFileTableTitle">
    	<div class="fileName" style="padding:0px;">Name</div>
    	<div class="fileOptionTitle" style="padding:0px;">Options</div>
    </div>
    <!--Start Folders Container-->
    <?php foreach($directories as $directory){ ?>
	<?php $class = ($ac_sw1++%2==0)?"odd":"even"; ?>
   	<div class="fileContainer <?php echo $class; ?>" style="overflow:auto;">
        <div class="fileName">
			<a href="javascript:openFolder('<?php echo $dir."/".$directory; ?>');" title="<?php if(strlen($directory) > 70) echo $directory; ?>"><img src="themes/default/images/folder.png" width="24" height="24" style="vertical-align:middle;" /> <b><?php echo cropLongWord($directory, 70); ?></b></a>
        </div>
    	<div class="fileOptionsContainer">
            <div class="fileOption"><a id="deleteObject" href="javascript:void();" onclick="javascript:deleteObject('<?php echo $dir."/".$directory; ?>', 'folder');" title="Delete Folder"><img src="themes/default/images/folder_delete.png" width="24" height="24" /></a></div>
            <div class="fileOption"><a id="renameFolder" href="javascript:void();" onclick="javascript:showRenameFilePanel('<?php echo $dir."/".$directory; ?>', '<?php echo $directory; ?>', 'folder');" title="Rename Folder"><img src="themes/default/images/folder_edit.png" width="24" height="24" /></a>&nbsp; &nbsp;</div>
		</div>
	</div>
	<?php } ?>
    <!--End Folders Container-->
    <!--Start Files Container-->
    <?php foreach($files_list as $file_list){ ?>
	<?php $class = ($ac_sw1++%2==0)?"odd":"even"; ?>
    <div class="fileContainer <?php echo $class; ?>" style="overflow:auto;" onmouseover="showFileOptions('#fileOptionsContainer<?php echo $fileID; ?>');" onmouseout="hideFileOptions('#fileOptionsContainer<?php echo $fileID; ?>');">
        <div class="fileName">
            <a href="<?php echo $dir."/".$file_list; ?>" title="<?php if(strlen($file_list) > 70) echo $file_list; ?>" target="_blank">
            <?php if(file_exists("themes/default/images/file-extensions/".$fileObject->getFileExtension($dir."/".$file_list).".png")){ ?>
			    <img src="themes/default/images/file-extensions/<?php echo $fileObject->getFileExtension($dir."/".$file_list); ?>.png" width="24" height="24" style="vertical-align:middle;" />
            <?php }else{ ?>
                <img src="themes/default/images/page.png" width="24" height="24" style="vertical-align:middle;" />
            <?php } ?>
            <?php echo cropLongWord($file_list, 70); ?>
            </a>
        </div>
    	<div class="fileOptionsContainer" id="fileOptionsContainer<?php echo $fileID; ?>" style="display: none;">
            <div class="fileOption"><a id="deleteObject" href="javascript:void();" onclick="javascript:deleteObject('<?php echo $dir."/".$file_list; ?>', 'file');" title="Delete File">Delete</a></div>
            <div class="fileOption"><a id="renameFile" href="javascript:void();" onclick="javascript:showRenameFilePanel('<?php echo $dir."/".$file_list; ?>', '<?php echo $file_list; ?>', 'file');" title="Rename File">Rename</a> |&nbsp;</div>
            <div class="fileOption">
                <?php if($fileObject->isImage($file_list)){ ?>
                    <a id="resizeImage" href="javascript:void();" onclick="javascript:showResizeImagePanel('<?php echo $dir."/".$file_list; ?>', '<?php echo $fileObject->getImageWidth($dir."/".$file_list); ?>', '<?php echo $fileObject->getImageHeight($dir."/".$file_list); ?>');" title="Resize Image">Resize</a> |&nbsp;
                <?php } ?>
            </div>
        </div>
	</div>
        <?php $fileID++; ?>
    <?php } ?>
    <!--End Files Container-->
</div>
<?php
/** Show a link to redirect to login page **/
}else{
    echo "<div class='fileManagerAccessDeniedContainer'><a href='login.php'>Access Denied! Please login here.</a></div>";
}
?>