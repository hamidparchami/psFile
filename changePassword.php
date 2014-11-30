<?php
/********************************
 * psFile v0.1
 * Written by Hamid Parchami
 * Email: hamidparchami@gmail.com
 * 29/09/2014
 ********************************/
require_once("includes/processor/pWd_file_functions.php");
require_once('includes/setting/userSetting.php');
if(@isset($_POST['password'])){
	if(md5($_POST['oldPassword']) == $password){
	$fileContent = 
'<?php
$'.'username = "'.$username.'";
$'.'password = "'.md5($_POST['password']) . '";
?>';
		$writeFile = new PsFile;
		if($writeFile->writeToFile('includes/setting/userSetting.php', $fileContent)){
			header("Location: changePassword.php?result=changed");
		}else{
			header("Location: changePassword.php?result=failed");
		}
	}else{
		header("Location: changePassword.php?result=old_Password_Incorect");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="themes/default/css/common.css" rel="stylesheet" type="text/css" />
<title>psFile - Change Password</title>
</head>

<body>
<div align="center">
    <div class="boxHead fileManagerTitle" style="width: 500px;">Change Password</div>
    <div class="loginFormContainer">
    <?php
    if(@$_GET['result'] == "changed"){
        echo "<div style='color:#039; margin-bottom: 10px;'>Password has been changed.</div>";
    }
    if(@$_GET['result'] == "failed"){
        echo "<div style='color:#F00; margin-bottom: 10px;'>Password reset has been failed! Please try again.</div>";
    }
    if(@$_GET['result'] == "old_Password_Incorect"){
        echo "<div style='color:#F00; margin-bottom: 10px;'>Password reset has been failed! old password is incorrect.</div>";
    }
    ?>
    <form action="" method="POST" name="pWd_password">
        <div>Old password: &nbsp;<input name="oldPassword" type="text" size="20" maxlength="32" /></div>
        <div>New Password: <input name="password" type="password" size="20" maxlength="32" /></div>
        <div><br /><input name="submit" class="button" type="submit" value=" Change " /></div>
        <hr />
        <div><a href="index.php"><img src="themes/default/images/go-home.png" width="24" height="24" style="vertical-align:bottom;" /> Back to File Manager</a></div>
    </form>
    </div>
</div>
</body>
</html>