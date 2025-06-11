<?php 

ob_start();
include ('con.php');
$domain = 'https://perfact.group/mine';

if(isset($_SESSION['email_id'])!="") {

}



if (isset($_POST['login'])) {
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$result = mysqli_query($link, "SELECT * FROM users WHERE email = '" . $email. "' and passw = '" . md5($password). "'");
	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['email_id'] = $row['email'];
		$_SESSION['full_name'] = $row['fullname'];		
		$_SESSION['coins'] = $row['coins'];	
		$_SESSION['id'] = $row['id'];	
		$_SESSION['api_key'] = $row['api_key'];	
		$_SESSION['secret_key'] = $row['secret_key'];	

	} else {
		$error_message = "E-mail или пароль неверно!";
	}
}
?>
<html>
<head>
<title><?php echo $title_site ?></title>
<link rel="stylesheet" type="text/css" href="<?=$domain?>/css/style.css" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="header_up">

<div class="home_header">

<a class="logo1" href="/mine">MINANCE</a>

<div class="menu">
<ul>
  <li><a href="#contact">Contact</a></li>
  <li><a href="#about">About</a></li>
</ul>
</div>


</div>

</div>