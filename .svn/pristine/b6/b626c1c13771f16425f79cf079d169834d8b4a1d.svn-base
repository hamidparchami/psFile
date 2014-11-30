<?php
// *** Logout the current user.
$logoutGoTo = "login.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['pWd_Username'] = NULL;
$_SESSION['pWd_UserGroup'] = NULL;
unset($_SESSION['pWd_Username']);
unset($_SESSION['pWd_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
