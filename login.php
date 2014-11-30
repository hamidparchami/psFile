<?php require_once('includes/setting/userSetting.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $fldUserAuthorization = "";
  $redirectLoginSuccess = "index.php";
  $redirectLoginFailed = "login.php?login=failed";
  $redirecttoReferrer = false;
  mysql_select_db($database_psFile, $psFile);
  if($_POST['username'] == $username && md5($_POST['password']) == $password){
      $loginUsername = $_POST['username'];
	  $loginFoundUser = true;
  }

  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['pWd_Username'] = $loginUsername;
    $_SESSION['pWd_UserGroup'] = $loginStrGroup;

    if (isset($_SESSION['PrevUrl']) && false) {
      $redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
    header("Location: " . $redirectLoginSuccess );
  }
  else {
    header("Location: ". $redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="themes/default/css/common.css" rel="stylesheet" type="text/css" />
<title>psFile - Login</title>
</head>

<body>
<div align="center">
    <div class="boxHead fileManagerTitle" style="margin-top:100px; width: 500px;">Login</div>
    <div class="loginFormContainer">
    <?php
    if(@$_GET['login'] == "failed"){
        echo "<div style='color:#F00; margin-bottom: 10px;'>Your username or password is incorrect!</div>";
    }
    ?>
    <form action="<?php echo $loginFormAction; ?>" method="POST" name="pWd_login">
        <div>Username: <input name="username" type="text" size="20" maxlength="32" /></div>
        <div>Password: &nbsp;<input name="password" type="password" size="20" maxlength="32" /></div>
        <div><br /><input name="submit" class="button" type="submit" value=" Login " /></div>
    </form>
    </div>
</div>
</body>
</html>