<?php


session_start();
// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

?>


<?php echo file_get_contents("navtop.html"); ?>
<?php echo file_get_contents("navleft.html"); ?>
This is the home page; default dashboard