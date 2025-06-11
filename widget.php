<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<div class="left_widgets">

<? if(isset($_SESSION['id']) == ""){?>
<div class="widgets1">
<span class="title_widg" style="margin:0;"><i class="info_ico"></i>SIGN IN</span><hr>
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
					
					<div class="form-group">
						<label for="name">E-mail</label>
						<input type="text" name="email" placeholder="Введите почту" required class="form-control" />
					</div>	
					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="******" required class="form-control" />
					</div>	
					<div class="form-group">
						<input type="submit" class="getbtn log_in" name="login" value="Login" />
					</div>
	
			</form>
			<span style="color: #ff1919;"><?php if (isset($error_message)) { echo $error_message; } ?></span>						
</div>
<? } else { ?>

<div class="widgets1">

<span class="title_widg" style="margin:0;"><i class="info_ico"></i>INFORMATION</span><hr/>
<p style="">
Привет! <?=$_SESSION['full_name']?><br/>
<!--Баланс: <span style="color:#ffec6f;"><i class="coin_ico"></i><?=$_SESSION['coins']?> coins</span><br/-->
Ваш ID: <?=$_SESSION['id']?><br/>
<hr/>
<a href="<?=$domain?>/logout.php"  class="getbtn log_out">Выйти</a>
</p>

</div>

<div class="widgets1">

<span class="title_widg" style="margin:0;"><i class="coin_ico"></i>BALANCE</span><hr/>
<p >
<b>ARPA :</b> <?=(float)$balances['ARPA']['available']?><br/>
<b>SPELL :</b> <?=(float)$balances['SPELL']['available']?><br/>
<b>DOGE :</b> <?=(float)$balances['DOGE']['available']?><br/>
<b>DASH :</b> <?=(float)$balances['DASH']['available']?><br/>
<b>ADA :</b> <?=(float)$balances['ADA']['available']?><br/>
<hr/>
<strong>BUSD :</strong> <?=(float)number_format($balances['BUSD']['available'],5);?><br/>
<strong>USDT :</strong> <?=(float)number_format($balances['USDT']['available'],5);?><br/>
<strong>USDC :</strong> <?=(float)number_format($balances['USDC']['available'],5);?><br/>
<strong>EUR :</strong> <?=(float)number_format($balances['EUR']['available'],5);?><br/>
</p>

</div>
<? } ?>

<div class="widgets1">

<span class="title_widg" style="margin:0;"><i class="sup_ico"></i>SUPPORT</span><hr/>
<p style="">
Telegram: <a href="https://t.me/+wC9l8Ss1ALY1YzRi" target="_blank">Minance Chat</a><br/>

</p>

</div>

</div>