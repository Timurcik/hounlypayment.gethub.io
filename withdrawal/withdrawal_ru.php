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
				$headers 	.= "Content-Type: text/html; charset=windows-1251\n";

				mail($adminmail,$subject,$text,$headers);
			}

			$sql = 'INSERT INTO `output` (`sum`, `date`, `login`, `paysys`, `purse`, `status`) VALUES("'.$sum.'", "'.time().'", "'.$login.'", '.$ps.', "'.$purse.'", '.$st.')';

			if (mysql_query($sql)) {

					$lid = mysql_insert_id();

					// АВТОВЫПЛАТЫ
						if($ps == 1 && $cfgAutoPay == "on") {
							$f = fopen('https://perfectmoney.com/acct/confirm.asp?AccountID='.$cfgPMID.'&PassPhrase='.$cfgPMpass.'&Payer_Account='.$cfgPerfect.'&Payee_Account='.$purse.'&Amount='.$sum.'&PAY_IN=1&PAYMENT_ID='.$lid.'&Memo='.$cfgURL, 'rb');
						} elseif($ps == 2 && $cfgAutoPay == "on") {
							include "TransferSample.php";
						}

					print '<p class="erok">Ваша заявка отправлена в обработку!</p>';

			} else {
				print '<p class="er">Не удаётся отправить заявку на снятие денег!</p>';
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
<FIELDSET style="border: solid #666666 1px; margin-bottom: 5px;">
<LEGEND><b>Форма подачи заявки на вывод</b>:</LEGEND>
	<table align="center">
	<form action="?action=save" method="post">
	<tr><td><b>Сумма вывода</b>: </td><td align="right"><input id="sum" style="width: 200px;" type='text' name='sum' value='<?php print $r['pm_balance']; ?>' size="30" maxlength="7" /></td></tr>
	<tr><td><b>Платежная система</b>: </td><td align="right"><select id="ps" onChange="CheBal();" style="width: 200px; margin-right: 0px;" name="ps">
<?php
if($r['pm']) {
	print '<option value="1">'.$r['pm'].' [$'.$r['pm_balance'].'] - PerfectMoney</option>';
}
if($r['lr']) {
	print '<option value="2">'.$r['lr'].' [$'.$r['lr_balance'].'] - LibertyReserve</option>';
}
?>
	</select></td></tr>
	<tr><td></td><td align="right"><input class="subm" type='submit' name='submit' value=' Подать заявку ' /></td></tr>
	</form>
	</table>
</FIELDSET>
<h3>История вывода средств:</h3>
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

		print "<table width=\"100%\"><tr bgcolor=\"#dddddd\" align=\"center\"><td style=\"padding: 3px;\"><b>#</b></td><td width=\"100\"><b>Дата</b></td><td><b>Сумма</b></td><td><b>Счет</b></td><td><b>Система</b></td><td><b>Статус</b></td></tr>";

		$i = 1;
		$s = 0;
		while ($row = mysql_fetch_array($result)) {

		if($i % 2) { $bg = ""; } else { $bg = " bgcolor=\"#eeeeee\""; }

		print "<tr".$bg." align=\"center\">
		<td style=\"padding: 3px;\">".$row['id']."</td>
		<td>".date("d.m.Y H:i", $row['date'])."</td>
		<td>$".$row['sum']."</td>
		<td><b>".$row['purse']."</b></td>
		<td>";
		
		if($row['paysys'] == 1) {
			print 'PerfectMoney';
		} else {
			print 'LibertyReserve';
		}

		print "</td>
		<td>";

		if($row['status'] == 0) {
			print '<span class="tool"><img src="/images/wait_ico.png" width="16" height="16" alt="Ожидание" /><span class="tip">Заявка находится на рассмотрении и обработке.</span></span>';
		} elseif($row['status'] == 2) {
			print '<span class="tool"><img src="/images/yes_ico.png" width="16" height="16" alt="Обработана" /><span class="tip">Заявка выполнена!</span></span>';
		} else {
			print '<span class="tool"><img src="/images/no_ico.png" width="16" height="16" alt="Удалена" /><span class="tip">Заявка отклонена администратором.</span></span>';
		}

		print "</td>

		</tr>";

			$i++;
			$s = $s + $row['sum'];
		}

		print "<tr bgcolor=\"#dddddd\" height=\"3\"><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><td></td><td align=\"right\"><b>Итого:</b></td><td align=\"center\"><b>$".$s."</b></td><td></td><td></td><td></td></tr></table>";

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