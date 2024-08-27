<?php
session_start();
$inactive_timeout = 900; 
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_timeout)) {
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header("Location:../Landing/login.php"); // redirect to logout page or any other page after logout
    exit();
}
$_SESSION['last_activity'] = time(); // update last activity time stamp
?>
