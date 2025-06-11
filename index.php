<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$title_site = 'MINANCE - Автоматизация трейдинга криптовалют';
include('header.php');

?>

<div class="content">

<h1 class="slivtxt" style="text-align:center">Автоматизация купли-продажи криптовалюты</h1>
<h3 style="text-align:center">За вас мы купим и продадим криптовалюту во время падений и роста в вашу пользу.</h3>
<p class="home_txt1" style="margin-bottom:15px;">- Наша система 24/7 ежесекундно анализирует рынок, по высчетам алгоритма делает покупки и продажи криптовалюты/токена.<br/>- Ваша прибыль зависит от изменений курса криптовалют, также возможно убыдки. Комиссия за услугу 0%.</p>
<hr/>

<div class="forums1">
<? if(!isset($_SESSION['id']) == ""){
include('bot.php');
} else {
	echo '<div class="block1"><ul><li>Авторизуйтесь, введите <strong>API Key</strong> и <strong>Secret Key</strong> от <b>Binance</b></li>
	<li>Валюты для обмена крипты такие как: <strong>USD, EUR</strong> так же <strong>USDT, USDC, BUSD</strong> которыми будете пользоваться <b>не должен быть ниже 11 USD/EUR</b>.</li>
	<li>Включите бот, сайт работает в тестовом режиме.</li>
	</ul>
	<br/>
	<hr/>
- ❤️ Для регистрации пишите в Telegram: <a href="https://t.me/+wC9l8Ss1ALY1YzRi" target="_blank">Minance Chat</a><br>
<br/>
	</div>';
}
?>
</div>

<? include('widget.php');?>


</div>
<? include('footer.php');?>