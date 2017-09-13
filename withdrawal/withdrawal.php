
<?php
defined('ACCESS') or die();
if ($login) {

	$sql	= 'SELECT `lr`, `pm`, `lr_balance`, `pm_balance`, `ref` FROM `users` WHERE `id` = '.$user_id.' LIMIT 1';
	$rs		= mysql_query($sql);
	$r		= mysql_fetch_array($rs);

	if ($_GET['action'] == 'save') {
		$sum	= sprintf ("%01.2f", str_replace(',', '.', $_POST['sum']));
		$ps		= intval($_POST['ps']);

		if ($sum <= 0) {
			print '<p class="er">Введите корректную сумму (от $'.$cfgMinOut.' до $1000)!</p>';
		} elseif ($sum < $cfgMinOut || $sum > 1000) {
			print '<p class="er">За один раз разрешено выводить от $'.$cfgMinOut.' до $1000!</p>';
		} elseif ($r['lr_balance'] < $sum && $ps == 2) {
			print '<p class="er">У Вас нет столько денег на счету!</p>';
		} elseif ($r['pm_balance'] < $sum && $ps == 1) {
			print '<p class="er">У Вас нет столько денег на счету!</p>';
		} elseif($ps < 1 || $ps > 2) {
			print '<p class="er">Укажите платежную систему! Номер счета укажите в вашем профиле.</p>';
		} else {

			$minus = $sum;

			if($cfgPercentOut) {
				$sum = sprintf("%01.2f", $sum - $sum / 100 * $cfgPercentOut);
			}

			if($ps == 1) {
				$purse	= $r['pm'];
				$sql	= 'UPDATE `users` SET pm_balance = pm_balance - '.$minus.' WHERE id = '.$user_id.' LIMIT 1';
			} elseif($ps == 2) {
				$purse	= $r['lr'];
				$sql	= 'UPDATE `users` SET lr_balance = lr_balance - '.$minus.' WHERE id = '.$user_id.' LIMIT 1';
			}

			mysql_query($sql);

			if($cfgAutoPay == "on") { 
				$st = 2; 
			} else { 
				$st = 0; 

				$text = "<p>Здравствуйте! В <a href=\"http://".$cfgURL."\">вашем проекте</a> подана заявка на вывод средств. Обработайте её пожалуйста.</p>";

				$subject	= "Заявка на вывод средств";
				$headers 	= "From: ".$adminmail."\n";
				$headers 	.= "Reply-to: ".$adminmail."\n";
				$headers 	.= "X-Sender: < http://".$cfgURL." >\n";
				$headers 	.= "Content-Type: text/html; charset=UTF-8\n";

				mail($adminmail,$subject,$text,$headers);
			}

			$sql = 'INSERT INTO `output` (`sum`, `date`, `login`, `paysys`, `purse`, `status`) VALUES("'.$sum.'", "'.time().'", "'.$login.'", '.$ps.', "'.$purse.'", '.$st.')';

			if (mysql_query($sql)) {

					$lid = mysql_insert_id();

					// АВТОВЫПЛАТЫ
						if($ps == 1 && $cfgAutoPay == "on") {
							$f = fopen('https://perfectmoney.com/acct/confirm.asp?AccountID='.$cfgPMID.'&PassPhrase='.$cfgPMpass.'&Payer_Account='.$cfgPerfect.'&Payee_Account='.$purse.'&Amount='.$sum.'&PAY_IN=1&PAYMENT_ID='.$lid.'&Memo='.$cfgURL, 'rb');
						} elseif($ps == 2 && $cfgAutoPay == "on") {
							require_once('cpayeer.php');
$accountNumber = 'P1861817';
$apiId = '1359601';
$apiKey = 'rktdth';
$payeer = new CPayeer($accountNumber, $apiId, $apiKey);
if ($payeer->isAuth())
{
	// инициализация вывода
	$initOutput = $payeer->initOutput(array(
		// id платежной системы полученный из списка платежных систем
		'ps' => '1136053',
		// счет, с которого будет списаны средства        
		'curIn' => 'USD',
		// сумма вывода
		'sumOut' => $sum,
		// валюта вывода
		'curOut' => 'USD',
		// номер телефона получателя платежа
		'param_ACCOUNT_NUMBER' => $purse
	));
	
	if ($initOutput)
	{
		// вывод средств
		$historyId = $payeer->output();
		if ($historyId)
		{
			echo "Выплата поставлена в очередь на выполнение";
		}
		else
		{
			echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
		}
	}
	else
	{
		echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
	}
}
else
{
	echo "Ошибка авторизации";
}
						}

					print '<p><center><font color=green>Ваша заявка выполнена!</font></center></p><br>';

			} else {
				print '<p><center><font color=red>Не удаётся отправить заявку на снятие денег!</font></center></p></br>';
			}
		}
	}
	?>

<script language="JavaScript">
<!--
	function CheBal() {
		if(document.getElementById('ps').value == '1') {
			document.getElementById("sum").value = "<?php print $r['pm_balance']; ?>"
		} else if(document.getElementById('ps').value == '2') {
			document.getElementById("sum").value = "<?php print $r['lr_balance']; ?>"
		}
	}
//-->
</script>

<form action="?action=save" method="post">
	<div class="general-block-outer">

					<div class="general-block cart-container">
															<center><font color="#f2650a"><h2>Вывод средств</h2></font></center>
					<br>			
					<center><font color="#f2650a">Комиссия: <b>5%</b></font></center>
					<center><font color="#f2650a"><b>Выплата производится в течении 12 часов, но обычно 10-15 минут</b></font></center>					
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
								<td class="price"><span class="summary">&#36; <?php print $pmbalance; ?></span></td>
								<td></td>
								<td></td>
							</tr>
							
<?php
} 
if($cfgLiberty) {
?>							
							<tr>
								<td colspan="2" class="unit-price"><input type="radio" name="ps" value="2" /></td>
								<td class="quantity1"><span class="summary">Payeer</span></td>
								<td class="price"><span class="summary">&#36; <?php print $lrbalance; ?></span></td>
								<td></td>
								<td></td>
							</tr>
<?php
} 
?>							
							<tr class="last submit">
								<td colspan="4" class="unit-price"></td>
								<td class="quantity">
									
								</td>
								<td class="price">
								<input type="submit" value=" Вывести средства " />
									
								</td>
							</tr>
						</table>
					</div>
				</div>

	</form>

<h3></h3>
<br>
<?php


	$page	= intval($_GET['page']);
	$query	= "SELECT * FROM `output` WHERE login = '".$login."'";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);
	$total	= intval(($themes - 1) / $num) + 1;

	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query." ORDER BY id DESC LIMIT ".$start.", ".$num);

	if(!$themes) {
		print "<p class=\"er\">Вы не подавали заявок на вывод!</p>";
	} else {

		print "
	<div class=\"general-block-outer\">
					<div class=\"general-block cart-container\">
										<center><font color=\"#f2650a\"><h2>История вывода средств</h2></font></center>
					<br>
						<table cellpadding=\"0\" cellspacing=\"0\">
						<tr>

								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Дата</span></td>
								
								<td style=\"width:250px\" class=\"product-name\"><span class=\"heading\">Сумма</span></td>
								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Счет</span></td>
								
								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Система</span></td>
								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Статус</span></td>
							</tr>";

		$i = 1;
		$s = 0;
		while ($row = mysql_fetch_array($result)) {

		if($i % 2) { $bg = ""; } else { $bg = " bgcolor=\"#eeeeee\""; }

		print "<tr>

								<td style=\"width:200px\" class=\"product-name\">".date("d.m.Y H:i", $row['date'])."</td>
								<td style=\"width:550px\" class=\"product-name\">$".$row['sum']."</td>
								<td style=\"width:200px\" class=\"product-name\"><b>".$row['purse']."</b></td>
								<td style=\"width:200px\" class=\"product-name\"> ";
								if($row['paysys'] == 1) {
			print 'PerfectMoney';
		} else {
			print 'Payeer';
		}
								print"</td>
								<td style=\"width:200px\" class=\"product-name\">";
								if($row['status'] == 0) {
								print'<span class="tool"><img src="/images/wait_ico.png" width="16" height="16" alt="Ожидание" /><span class="tip">Ожидание!</span></span></td>
								<td style=\"width:200px\" class=\"product-name\">';
							} elseif($row['status'] == 2) {
								print'<span class="tool"><img src="/images/yes_ico.png" width="16" height="16" alt="Обработана" /><span class="tip">Обработана!</span></span></td>
								<td style=\"width:200px\" class=\"product-name\">';
								} else {
								print'<span class="tool"><img src="/images/no_ico.png" width="16" height="16" alt="Удалена" /><span class="tip">Удалена!</span></span>';
								}
								print'</td>
							</tr>';
		
	



			$i++;
			$s = $s + $row['sum'];
		}

		print "<tr bgcolor=\"#dddddd\" height=\"3\"><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><td></td><td align=\"right\"><b>Итого:</b></td><td align=\"center\"><b>$".$s."</b></td><td></td><td></td><td></td></tr>	</table>
					</div>
				</div>";

	}

	if ($page) {
		if($page != 1) { $pervpage = "<a href=\"?page=". ($page - 1) ."\">««</a>"; }
		if($page != $total) { $nextpage = " <a href=\"?page=". ($page + 1) ."\">»»</a>"; }
		if($page - 2 > 0) { $page2left = " <a href=\"?page=". ($page - 2) ."\">". ($page - 2) ."</a>) "; }
		if($page - 1 > 0) { $page1left = " <a href=\"?page=". ($page - 1) ."\">". ($page - 1) ."</a>) "; }
		if($page + 2 <= $total) { $page2right = " | <a href=\"?page=". ($page + 2) ."\">". ($page + 2) ."</a>) "; }
		if($page + 1 <= $total) { $page1right = " | <a href=\"?page=". ($page + 1) ."\">". ($page + 1) ."</a>) "; }
	}
	print "<div align=\"right\"><b>Страницы:  </b>".$pervpage.$page2left.$page1left."[<b>".$page."</b>]".$page1right.$page2right.$nextpage."</div>";
} else {
	print "<p class=\"er\">Вы должны авторизироваться для доступа к этой странице!</p>";
}
?>