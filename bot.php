<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ('con.php');
require 'binance.php';

$color_dis = '';
$if_user_sql = '';
if(!isset($_SESSION['id']) == ""){
$if_user_sql = " WHERE id ='".$_SESSION['id']."'";
}

$shots = mysqli_query($link,"SELECT * FROM users".$if_user_sql) or die(mysqli_error());
while($row = mysqli_fetch_assoc($shots)) {
if($row["online"] == 1){
 
$api = new Binance\API($row["api_key"],$row["secret_key"]);
$balances = $api->balances();

?>
<div class="block1">
<?
//===============arpa====================//
$to_currency = "USD";
$coin_ids = "arpa-chain";
$symbol = "ARPA";
$crypt_currency = "BUSD";

$headers = array(
   "Accept-Encoding: gzip, deflate"
);

$curl2 = curl_init();
curl_setopt_array($curl2, array(
CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency={$to_currency}&ids={$coin_ids}&order=market_cap_desc&per_page=10&page=1&sparkline=true&price_change_percentage=7d",
  CURL_SETOPT($curl2, CURLOPT_HTTPHEADER, $headers),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response2 = curl_exec($curl2);
$err2 = curl_error($curl2);

curl_close($curl2);
$json2 = json_decode($response2, true);
if($row[$symbol] == 0){$color_dis = 'style="background-color:#232d39;"';}else {$color_dis='';}
echo "<div class='token_title' {$color_dis}>".$json2[0]['name']."</div>";
echo "<div class='head1'>";

echo "<b>".strtoupper($json2[0]['symbol']).":</b> ".(float)$balances[$symbol]['available'];
echo " | <strong>".$crypt_currency.":</strong> ".(float)number_format($balances[$crypt_currency]['available'],5)." | ";

$can_buy = (float)($balances[$crypt_currency]['available'])/$json2[0]['current_price'];

$current_price = $json2[0]['current_price'].' '.strtoupper($to_currency).'</div>';

//24 hours
$maxim = $json2[0]['high_24h'];
$minim = $json2[0]['low_24h'];

echo '<b style="color:#ff6f38">Current price:</b> '.$current_price/*.'<br>max:'.$maxim.'<br>min:'.$minim.'<br>'*/;

$esas_per_24 = 100-(($json2[0]['current_price']*100)/$maxim);
//24 hours

//7days
foreach($json2[0]['sparkline_in_7d'] as $value){
	$min = min($value);
$max = max($value);
}

$esas_per_7d_max = 100-(($json2[0]['current_price']*100)/$max);
$esas_per_7d_min = 100-(($min*100)/$json2[0]['current_price']);

//24hours
$esas_per_24_max = 100-(($json2[0]['current_price']*100)/$maxim);
$esas_per_24_min = 100-(($minim*100)/$json2[0]['current_price']);
//24hours

?><br/><table class="tg2" style="width: 100%;">
<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 7d:</strong> <span class="per_c"><?=$min?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 7d:</b> <span class="per_c"><?=$max?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 7d per:</strong> <span class="per_c"><?=abs($esas_per_7d_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 7d per:</b> <span class="per_c"><?=abs($esas_per_7d_max)?></span> %</td>
  </tr>
</tbody>

<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 24h:</strong> <span class="per_c"><?=$minim?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 24h:</b> <span class="per_c"><?=$maxim?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 24h per:</strong> <span class="per_c"><?=abs($esas_per_24_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 24h per:</b> <span class="per_c"><?=abs($esas_per_24_max)?></span> %</td>
  </tr>
</tbody>
</table>
<?
if($row[$symbol] == 1){
if((float)number_format($balances[$crypt_currency]['available'],7) > 10){
echo '<br/><strong>Can buy: </strong>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
//==========//
if(abs($esas_per_7d_min) <= 5 and abs($esas_per_7d_max) >= 10){
$quantity = (float)str_replace('.',',',$can_buy);

$order = $api->marketBuy($symbol.$crypt_currency, $quantity);		
}
//=========//

}else {
echo '<br/><b>Can not buy: </b>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
}


if(abs($can_buy) <= (float)$balances[$symbol]['available'] and (float)$balances[$symbol]['available']*$json2[0]['current_price'] > 10.5){
if(abs($esas_per_7d_max) <= 10 and abs($esas_per_7d_min) >= 5){
$order = $api->marketSell($symbol.$crypt_currency, $balances[$symbol]['available']);
}
}
}else { echo '<br/><b>Trading disabled</b>'; }
?>
<?
//====================SPELL============================//
echo '<br/><br/><hr/>';
$to_currency = "USD";
$coin_ids = "spell-token";
$symbol = "SPELL";
$crypt_currency = "USDT";

$headers = array(
   "Accept-Encoding: gzip, deflate"
);

$curl2 = curl_init();
curl_setopt_array($curl2, array(
CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency={$to_currency}&ids={$coin_ids}&order=market_cap_desc&per_page=10&page=1&sparkline=true&price_change_percentage=7d",
  CURL_SETOPT($curl2, CURLOPT_HTTPHEADER, $headers),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response2 = curl_exec($curl2);
$err2 = curl_error($curl2);

curl_close($curl2);
$json2 = json_decode($response2, true);

if($row[$symbol] == 0){$color_dis = 'style="background-color:#232d39;"';}else {$color_dis='';}
echo "<div class='token_title' {$color_dis}>".$json2[0]['name']."</div>";
echo "<div class='head1'>";

echo "<b>".strtoupper($json2[0]['symbol']).":</b> ".(float)$balances[$symbol]['available'];
echo " | <strong>".$crypt_currency.":</strong> ".(float)number_format($balances[$crypt_currency]['available'],5)." | ";
$can_buy = (float)($balances[$crypt_currency]['available'])/$json2[0]['current_price'];

$current_price = $json2[0]['current_price'].' '.strtoupper($to_currency).'</div>';

//24 hours
$maxim = $json2[0]['high_24h'];
$minim = $json2[0]['low_24h'];

echo '<b style="color:#ff6f38">Current price:</b> '.$current_price/*.'<br>max:'.$maxim.'<br>min:'.$minim.'<br>'*/;

$esas_per_24 = 100-(($json2[0]['current_price']*100)/$maxim);
//24 hours

//7days
foreach($json2[0]['sparkline_in_7d'] as $value){
	$min = min($value);
$max = max($value);
}

$esas_per_7d_max = 100-(($json2[0]['current_price']*100)/$max);
$esas_per_7d_min = 100-(($min*100)/$json2[0]['current_price']);

//24hours
$esas_per_24_max = 100-(($json2[0]['current_price']*100)/$maxim);
$esas_per_24_min = 100-(($minim*100)/$json2[0]['current_price']);
//24hours

?><br/><table class="tg2" style="width: 100%;">
<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 7d:</strong> <span class="per_c"><?=$min?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 7d:</b> <span class="per_c"><?=$max?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 7d per:</strong> <span class="per_c"><?=abs($esas_per_7d_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 7d per:</b> <span class="per_c"><?=abs($esas_per_7d_max)?></span> %</td>
  </tr>
</tbody>

<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 24h:</strong> <span class="per_c"><?=$minim?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 24h:</b> <span class="per_c"><?=$maxim?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 24h per:</strong> <span class="per_c"><?=abs($esas_per_24_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 24h per:</b> <span class="per_c"><?=abs($esas_per_24_max)?></span> %</td>
  </tr>
</tbody>
</table>
<?
if($row[$symbol] == 1){
if((float)number_format($balances[$crypt_currency]['available'],7) > 10){
echo '<br/><strong>Can buy: </strong>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
//==========//
if(abs($esas_per_7d_min) <= 5 and abs($esas_per_7d_max) >= 10){
$quantity = (float)str_replace('.',',',$can_buy);

$order = $api->marketBuy($symbol.$crypt_currency, $quantity);		
}
//=========//

}else {
echo '<br/><b>Can not buy: </b>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
}


if(abs($can_buy) <= (float)$balances[$symbol]['available'] and (float)$balances[$symbol]['available']*$json2[0]['current_price'] > 10.5){
if(abs($esas_per_7d_max) <= 10 and abs($esas_per_7d_min) >= 5){
$order = $api->marketSell($symbol.$crypt_currency, $balances[$symbol]['available']);
}
}
}else { echo '<br/><b>Trading disabled</b>'; }
?>
<?

//====================dogecoin============================//
echo '<br/><br/><hr/>';
$to_currency = "EUR";
$coin_ids = "dogecoin";
$symbol = "DOGE";
$crypt_currency = "EUR";

$headers = array(
   "Accept-Encoding: gzip, deflate"
);

$curl2 = curl_init();
curl_setopt_array($curl2, array(
CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency={$to_currency}&ids={$coin_ids}&order=market_cap_desc&per_page=10&page=1&sparkline=true&price_change_percentage=7d",
  CURL_SETOPT($curl2, CURLOPT_HTTPHEADER, $headers),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response2 = curl_exec($curl2);
$err2 = curl_error($curl2);

curl_close($curl2);
$json2 = json_decode($response2, true);

if($row[$symbol] == 0){$color_dis = 'style="background-color:#232d39;"';}else {$color_dis='';}
echo "<div class='token_title' {$color_dis}>".$json2[0]['name']."</div>";
echo "<div class='head1'>";

echo "<b>".strtoupper($json2[0]['symbol']).":</b> ".(float)$balances[$symbol]['available'];
echo " | <strong>".$crypt_currency.":</strong> ".(float)number_format($balances[$crypt_currency]['available'],5)." | ";
$can_buy = (float)($balances[$crypt_currency]['available'])/$json2[0]['current_price'];

$current_price = $json2[0]['current_price'].' '.strtoupper($to_currency).'</div>';

//24 hours
$maxim = $json2[0]['high_24h'];
$minim = $json2[0]['low_24h'];

echo '<b style="color:#ff6f38">Current price:</b> '.$current_price/*.'<br>max:'.$maxim.'<br>min:'.$minim.'<br>'*/;

$esas_per_24 = 100-(($json2[0]['current_price']*100)/$maxim);
//24 hours

//7days
foreach($json2[0]['sparkline_in_7d'] as $value){
	$min = min($value);
$max = max($value);
}

$esas_per_7d_max = 100-(($json2[0]['current_price']*100)/$max);
$esas_per_7d_min = 100-(($min*100)/$json2[0]['current_price']);

//24hours
$esas_per_24_max = 100-(($json2[0]['current_price']*100)/$maxim);
$esas_per_24_min = 100-(($minim*100)/$json2[0]['current_price']);
//24hours

?><br/><table class="tg2" style="width: 100%;">
<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 7d:</strong> <span class="per_c"><?=$min?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 7d:</b> <span class="per_c"><?=$max?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 7d per:</strong> <span class="per_c"><?=abs($esas_per_7d_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 7d per:</b> <span class="per_c"><?=abs($esas_per_7d_max)?></span> %</td>
  </tr>
</tbody>

<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 24h:</strong> <span class="per_c"><?=$minim?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 24h:</b> <span class="per_c"><?=$maxim?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 24h per:</strong> <span class="per_c"><?=abs($esas_per_24_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 24h per:</b> <span class="per_c"><?=abs($esas_per_24_max)?></span> %</td>
  </tr>
</tbody>
</table>
<?
if($row[$symbol] == 1){
if((float)number_format($balances[$crypt_currency]['available'],7) > 10){
echo '<br/><strong>Can buy: </strong>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
//==========//
if(abs($esas_per_7d_min) <= 5 and abs($esas_per_7d_max) >= 10){
$quantity = (float)str_replace('.',',',$can_buy);

$order = $api->marketBuy($symbol.$crypt_currency, $quantity);		
}
//=========//

}else {
echo '<br/><b>Can not buy: </b>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
}


if(abs($can_buy) <= (float)$balances[$symbol]['available'] and (float)$balances[$symbol]['available']*$json2[0]['current_price'] > 10.5){
if(abs($esas_per_7d_max) <= 10 and abs($esas_per_7d_min) >= 5){
$order = $api->marketSell($symbol.$crypt_currency, $balances[$symbol]['available']);
}
}
}else { echo '<br/><b>Trading disabled</b>'; }
?>
<?
//====================dash============================//
echo '<br/><br/><hr/>';
$to_currency = "USD";
$coin_ids = "dash";
$symbol = "DASH";
$crypt_currency = "USDT";

$headers = array(
   "Accept-Encoding: gzip, deflate"
);

$curl2 = curl_init();
curl_setopt_array($curl2, array(
CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency={$to_currency}&ids={$coin_ids}&order=market_cap_desc&per_page=10&page=1&sparkline=true&price_change_percentage=7d",
  CURL_SETOPT($curl2, CURLOPT_HTTPHEADER, $headers),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response2 = curl_exec($curl2);
$err2 = curl_error($curl2);

curl_close($curl2);
$json2 = json_decode($response2, true);

if($row[$symbol] == 0){$color_dis = 'style="background-color:#232d39;"';}else {$color_dis='';}
echo "<div class='token_title' {$color_dis}>".$json2[0]['name']."</div>";
echo "<div class='head1'>";

echo "<b>".strtoupper($json2[0]['symbol']).":</b> ".(float)$balances[$symbol]['available'];
echo " | <strong>".$crypt_currency.":</strong> ".(float)number_format($balances[$crypt_currency]['available'],5)." | ";
$can_buy = (float)($balances[$crypt_currency]['available'])/$json2[0]['current_price'];

$current_price = $json2[0]['current_price'].' '.strtoupper($to_currency).'</div>';

//24 hours
$maxim = $json2[0]['high_24h'];
$minim = $json2[0]['low_24h'];

echo '<b style="color:#ff6f38">Current price:</b> '.$current_price/*.'<br>max:'.$maxim.'<br>min:'.$minim.'<br>'*/;

$esas_per_24 = 100-(($json2[0]['current_price']*100)/$maxim);
//24 hours

//7days
foreach($json2[0]['sparkline_in_7d'] as $value){
	$min = min($value);
$max = max($value);
}

$esas_per_7d_max = 100-(($json2[0]['current_price']*100)/$max);
$esas_per_7d_min = 100-(($min*100)/$json2[0]['current_price']);

//24hours
$esas_per_24_max = 100-(($json2[0]['current_price']*100)/$maxim);
$esas_per_24_min = 100-(($minim*100)/$json2[0]['current_price']);
//24hours

?><br/><table class="tg2" style="width: 100%;">
<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 7d:</strong> <span class="per_c"><?=$min?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 7d:</b> <span class="per_c"><?=$max?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 7d per:</strong> <span class="per_c"><?=abs($esas_per_7d_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 7d per:</b> <span class="per_c"><?=abs($esas_per_7d_max)?></span> %</td>
  </tr>
</tbody>

<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 24h:</strong> <span class="per_c"><?=$minim?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 24h:</b> <span class="per_c"><?=$maxim?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 24h per:</strong> <span class="per_c"><?=abs($esas_per_24_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 24h per:</b> <span class="per_c"><?=abs($esas_per_24_max)?></span> %</td>
  </tr>
</tbody>
</table>
<?
if($row[$symbol] == 1){
if((float)number_format($balances[$crypt_currency]['available'],7) > 10){
echo '<br/><strong>Can buy: </strong>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
//==========//
if(abs($esas_per_7d_min) <= 5 and abs($esas_per_7d_max) >= 10){
$quantity = (float)str_replace('.',',',$can_buy);

$order = $api->marketBuy($symbol.$crypt_currency, $quantity);		
}
//=========//

}else {
echo '<br/><b>Can not buy: </b>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
}


if(abs($can_buy) <= (float)$balances[$symbol]['available'] and (float)$balances[$symbol]['available']*$json2[0]['current_price'] > 10.5){
if(abs($esas_per_7d_max) <= 10 and abs($esas_per_7d_min) >= 5){
$order = $api->marketSell($symbol.$crypt_currency, $balances[$symbol]['available']);
}
}
}else { echo '<br/><b>Trading disabled</b>'; }
?>
<?
//====================BTTC============================//
echo '<br/><br/><hr/>';
$to_currency = "USD";
$coin_ids = "cardano";
$symbol = "ADA";
$crypt_currency = "USDC";

$headers = array(
   "Accept-Encoding: gzip, deflate"
);

$curl2 = curl_init();
curl_setopt_array($curl2, array(
CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency={$to_currency}&ids={$coin_ids}&order=market_cap_desc&per_page=10&page=1&sparkline=true&price_change_percentage=7d",
  CURL_SETOPT($curl2, CURLOPT_HTTPHEADER, $headers),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response2 = curl_exec($curl2);
$err2 = curl_error($curl2);

curl_close($curl2);
$json2 = json_decode($response2, true);

if($row[$symbol] == 0){$color_dis = 'style="background-color:#232d39;"';}else {$color_dis='';}
echo "<div class='token_title' {$color_dis}>".$json2[0]['name']."</div>";
echo "<div class='head1'>";

echo "<b>".strtoupper($json2[0]['symbol']).":</b> ".(float)$balances[$symbol]['available'];
echo " | <strong>".$crypt_currency.":</strong> ".(float)number_format($balances[$crypt_currency]['available'],5)." | ";
$can_buy = (float)($balances[$crypt_currency]['available'])/$json2[0]['current_price'];

$current_price = $json2[0]['current_price'].' '.strtoupper($to_currency).'</div>';

//24 hours
$maxim = $json2[0]['high_24h'];
$minim = $json2[0]['low_24h'];

echo '<b style="color:#ff6f38">Current price:</b> '.$current_price/*.'<br>max:'.$maxim.'<br>min:'.$minim.'<br>'*/;

$esas_per_24 = 100-(($json2[0]['current_price']*100)/$maxim);
//24 hours

//7days
foreach($json2[0]['sparkline_in_7d'] as $value){
	$min = min($value);
$max = max($value);
}

$esas_per_7d_max = 100-(($json2[0]['current_price']*100)/$max);
$esas_per_7d_min = 100-(($min*100)/$json2[0]['current_price']);

//24hours
$esas_per_24_max = 100-(($json2[0]['current_price']*100)/$maxim);
$esas_per_24_min = 100-(($minim*100)/$json2[0]['current_price']);
//24hours

?><br/><table class="tg2" style="width: 100%;">
<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 7d:</strong> <span class="per_c"><?=$min?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 7d:</b> <span class="per_c"><?=$max?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 7d per:</strong> <span class="per_c"><?=abs($esas_per_7d_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 7d per:</b> <span class="per_c"><?=abs($esas_per_7d_max)?></span> %</td>
  </tr>
</tbody>

<thead>
  <tr>
    <th class="tg2-0lax"><strong>min 24h:</strong> <span class="per_c"><?=$minim?></span> <?=$to_currency?></th>
    <th class="tg2-0lax"><b>max 24h:</b> <span class="per_c"><?=$maxim?></span> <?=$to_currency?></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg2-0lax"><strong>min 24h per:</strong> <span class="per_c"><?=abs($esas_per_24_min)?></span> %</td>
	<td class="tg2-0lax"><b>max 24h per:</b> <span class="per_c"><?=abs($esas_per_24_max)?></span> %</td>
  </tr>
</tbody>
</table>
<?
if($row[$symbol] == 1){
if((float)number_format($balances[$crypt_currency]['available'],7) > 10){
echo '<br/><strong>Can buy: </strong>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
//==========//
if(abs($esas_per_7d_min) <= 5 and abs($esas_per_7d_max) >= 10){
$quantity = (float)str_replace('.',',',$can_buy);
echo '3';
$order = $api->marketBuy($symbol.$crypt_currency, $quantity);		
}
//=========//

}else {
echo '<br/><b>Can not buy: </b>'.$can_buy.' '.strtoupper($json2[0]['symbol']);
}


if(abs($can_buy) <= (float)$balances[$symbol]['available'] and (float)$balances[$symbol]['available']*$json2[0]['current_price'] > 10.5){
if(abs($esas_per_7d_max) <= 10 and abs($esas_per_7d_min) >= 5){
$order = $api->marketSell($symbol.$crypt_currency, $balances[$symbol]['available']);
}
}
}else { echo '<br/><b>Trading disabled</b>'; }
//==================mysqli===============//
}
}
?>
<br/><br/>
</div>

<script>
	$('.per_C').each(function (index) {
	    $(this).prop('Counter',0).animate({
	        Counter: $(this).text()
	    }, {
	        duration: 2000,
	        easing: 'swing',
	        step: function (now) {
	            $(this).text(Math.round(now*10000000000)/10000000000);
	        }
	    });
	});
</script>