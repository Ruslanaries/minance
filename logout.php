<?php
ob_start();
session_start();

if(isset($_SESSION['email_id'])) {
	session_destroy();
	unset($_SESSION['email_id']);
	unset($_SESSION['full_name']);
	header("Location: index.php");
} else {
	header("Location: index.php");
}
?>