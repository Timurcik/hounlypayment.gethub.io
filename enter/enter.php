
<?php
defined('ACCESS') or die();

if ($login) {

	if ($_GET['action'] == 'save') {
		$sum	= sprintf ("%01.2f", str_replace(',', '.', $_POST['sum']));
		$ps		= intval($_POST['ps']);
		

		if ($sum <= 0) {
			print '<p class="er">Введите корректную сумму (от $0.10 до $1000)!</p>';
		} elseif ($sum < 0.01 || $sum > 1000) {
			print '<p class="er">За один раз разрешено выводить от $0.10 до $1000!</p>';
		} elseif($ps < 1 || $ps > 3) {
			print '<p class="er">Укажите платежную систему!</p>';
		} else {

				// Форма пополнения
					if($ps == 1) {

					// PM

					$sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "PM", "bal")';
					mysql_query($sql);

					
$cfgURL="qweqwewqeqw.esy.es";					
					
					print '<div class="general-block-outer">
					<div class="general-block cart-container">
						<table cellpadding="0" cellspacing="0">
					<center><font color="#f2650a"><h2>Подтверждение платежа</h2></font></center>
					<br>
					<form action="https://perfectmoney.is/api/step1.asp" method="POST">
					<input type="hidden" name="PAYEE_ACCOUNT" value="'.$cfgPerfect.'">
					<input type="hidden" name="PAYEE_NAME" value="'.$cfgPAYEE_NAME.'">
					<input type="hidden" name="PAYMENT_ID" value="'.mysql_insert_id().'">
					<input type="hidden" name="PAYMENT_AMOUNT" value="'.$sum.'">
					<input type="hidden" name="PAYMENT_UNITS" value="USD">
					<input type="hidden" name="STATUS_URL" value="http://'.$cfgURL.'/pmresult.php">
					<input type="hidden" name="PAYMENT_URL" value="http://'.$cfgURL.'/deposit/">
					<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="NOPAYMENT_URL" value="http://'.$cfgURL.'/enter/?er=1">
					<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="BAGGAGE_FIELDS" value="">
					<input type="hidden" name="SUGGESTED_MEMO" value="'.$cfgURL.'">
					<center>
					Вы переводите <strong>'.$sum.'</strong> USD на счёт <strong>'.$cfgPerfect.'</strong> PerfectMoney<br />Пополнение баланса в проекте '.$cfgURL.'<br />
					<p align="center"><input name="PAYMENT_METHOD" type="submit" value=" Платёж подтверждаю " /></p>
					</center>
					</form>
					</table>
					</div>
				</div>';

					
					} elseif($ps == 2) {

					// LR

					$sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "LR", "bal")';
						if(mysql_query($sql)) {

					print '	<div class="general-block-outer">
					<div class="general-block cart-container">
						<table cellpadding="0" cellspacing="0">
					<h1><b>Подтверждение платежа</b></h1>
					<form method="post" action="https://sci.libertyreserve.com">
					<input type="hidden" name="lr_acc" value="'.$cfgLiberty.'">
					<input type="hidden" name="lr_store" value="'.$cfgPAYEE_NAME.'">
					<input type="hidden" name="lr_amnt" value="'.$sum.'">
					<input type="hidden" name="lr_currency" value="LRUSD">
					<input type="hidden" name="lr_comments" value="'.$cfgURL.'">
					<input type="hidden" name="item_name" value="'.mysql_insert_id().'">
					<center>
					Вы переводите <strong>'.$sum.'</strong> USD на счёт <strong>'.$cfgLiberty.'</strong> LibertyReserve<br />Пополнение баланса в проекте '.$cfgURL.'<br />
					<p align="center"><input type="submit" value=" Платёж подтверждаю " /></p>
					</center>
					</form>
											</table>
					</div>
				</div>';

						} else {
							print '<p class="er">Не удаётся отправить заявку!</p>';
						}

				
					} elseif($ps == 3) {
					
					$sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "Payeer", "bal")';
						if(mysql_query($sql)) {

					// Payeer
$desc = base64_encode($cfgURL);
$m_shop = 1359470;
$m_orderid = mysql_insert_id();
$m_amount = $sum;
$m_curr = "USD";
$m_desc = $desc;
$m_key = "rktdth";

$arHash = array(
	$m_shop,
	$m_orderid,
	$m_amount,
	$m_curr,
	$m_desc,
	$m_key
);
$sign = strtoupper(hash('sha256', implode(":", $arHash)));
					

					print '	<div class="general-block-outer">
					<div class="general-block cart-container">
						<table cellpadding="0" cellspacing="0">
					<h1><b>Подтверждение платежа</b></h1>
					<form method="GET" action="http://payeer.com/api/merchant/m.php">
<input type="hidden" name="m_shop" value="'.$m_shop.'">
<input type="hidden" name="m_orderid" value="'.$m_orderid.'">
<input type="hidden" name="m_amount" value="'.$sum.'">
<input type="hidden" name="m_curr" value="'.$m_curr.'">
<input type="hidden" name="m_desc" value="'.$desc.'">
<input type="hidden" name="m_sign" value="'.$sign.'">
<center>
					Вы переводите <strong>'.$sum.'</strong> USD <br />Пополнение баланса в проекте '.$cfgURL.'<br />
					<p align="center"><input class="red-button cart-button" type="submit" name="m_process" value=" Платёж подтверждаю " /></p>
					</center>
					</form>
											</table>
					</div>
				</div>';

						} else {
							print '<p class="er">Не удаётся отправить заявку!</p>';
						}

				
					}
		}
	} else {
	?>

	<form action="?action=save" method="post">
	<div class="general-block-outer">
					<div class="general-block cart-container">
					
																	<center><font color="#f2650a"><h2>Пополнение баланса через PerfectMoney</h2></font></center>
							<br>					
						<table cellpadding="0" cellspacing="0">
						
							
				
<tr class="promo"> 
                                
								<td colspan="2" class="unit-price"><span class="grey">Сумма</span></td>
								
								<td class="quantity1"><input type="text" name="sum" value="" class="styled-input cart-field1"></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
<?php
if($cfgPerfect) {	
?>
							<tr style="display: none;">
								<td colspan="2" class="unit-price"><input type="radio" checked="checked" name="ps" value="1" /></td>
								<td class="quantity1"><span class="summary">PerfectMoney</span></td>
								<td class="price"></td>
								<td></td>
								<td></td>
							</tr>
							
<?php
} 

?>							



							<tr >
								<td colspan="4" class="unit-price"></td>
								<td class="quantity">
									
								</td>
								<td class="quantity1">
								<input  type="submit" value=" Пополнить баланс " />
									
								</td>
							</tr>
						</table>
					</div>
				</div>

	</form>


							
        <?php
			
		
		
	}

} else {
	print "<p class=\"er\">Вы должны авторизироваться для доступа к этой странице!</p>";
}

?>