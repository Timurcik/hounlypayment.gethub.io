<?php
defined('ACCESS') or die();

if($login) {

if($_GET['act'] == "open") {

	$plan	= intval($_POST['plan']);
	$sum	= sprintf("%01.2f", $_POST['sum']);
	$paysys	= intval($_POST['paysys']);

	if($plan && $sum && $paysys) {

	$result	= mysql_query("SELECT * FROM plans WHERE id = ".$plan." LIMIT 1");
	$row	= mysql_fetch_array($result);

		if(!$row['id']) {
			print '<p class="er">Выберите тарифный план</p>';
		} elseif($sum < $row['minsum'] || ($sum > $row['maxsum'] && $row['maxsum'] != 0)) {
			print '<p class="er">Сумма не соответствует тарифному плану</p>';
		} elseif(($paysys == 1 && $sum > $pmbalance) || ($paysys == 2 && $sum > $lrbalance)) {
			print '<p class="er">У вас недостаточно средств на счету, рекомендуем <a href="/enter/">пополнить</a> его.</p>';
		} else {

			if($row['bonusdeposit']) {
				$depo	= sprintf("%01.2f", $sum + $sum / 100 * $row['bonusdeposit']);
			} else {
				$depo	= $sum;
			}

			// Вычисляем даты
			if(cfgSET('datestart') <= time()) {
				$lastdate = time();
				if($row['period'] == 1) {
					$nextdate = $lastdate + 86400;
				} elseif($row['period'] == 2) {
					$nextdate = $lastdate + 604800;
				} elseif($row['period'] == 3) {
					$nextdate = $lastdate + 2592000;
				} elseif($row['period'] == 4) {
					$nextdate = $lastdate + 3600;
				}
			} else {
				$lastdate = time();
				if($row['period'] == 1) {
					$nextdate = cfgSET('datestart') + 86400;
				} elseif($row['period'] == 2) {
					$nextdate = cfgSET('datestart') + 604800;
				} elseif($row['period'] == 3) {
					$nextdate = cfgSET('datestart') + 2592000;
				} elseif($row['period'] == 4) {
					$nextdate = cfgSET('datestart') + 3600;
				}
			}

			$sql = "INSERT INTO `deposits` (username, user_id, date, plan, sum, paysys, lastdate, nextdate) VALUES ('".$login."', ".$user_id.", ".time().", ".$plan.", ".$depo.", ".$paysys.", ".$lastdate.", ".$nextdate.")";
			mysql_query($sql);

			if($paysys == 2) {
				mysql_query('UPDATE users SET lr_balance = lr_balance - '.$sum.' WHERE id = '.$user_id.' LIMIT 1');
			} else {
				mysql_query('UPDATE users SET pm_balance = pm_balance - '.$sum.' WHERE id = '.$user_id.' LIMIT 1');
			}

			// Начисляем бонус

			if($row['bonusbalance']) {
				$bonus	= sprintf("%01.2f", $sum / 100 * $row['bonusbalance']);
				if($paysys == 2) {
					mysql_query('UPDATE users SET lr_balance = lr_balance + '.$bonus.' WHERE id = '.$user_id.' LIMIT 1');
				} else {
					mysql_query('UPDATE users SET pm_balance = pm_balance + '.$bonus.' WHERE id = '.$user_id.' LIMIT 1');
				}
			}

			// Начисляем нашим "любимым" рефералам
			if($uref) {

				// Подсчитываем кол-во уровней
				$countlvl = mysql_num_rows(mysql_query("SELECT * FROM reflevels"));

				if($countlvl) {
					$i		= 0;
					$uid	= $user_id;
					$query	= "SELECT * FROM reflevels ORDER BY id ASC";
					$result	= mysql_query($query);
					while($row = mysql_fetch_array($result)) {
						if($i < $countlvl) {
							$lvlperc = $row['sum'];		// Процент уровня
							$ps		 = sprintf("%01.2f", $sum / 100 * $lvlperc); // Сумма рефских

							if($uref) {
								if($paysys == 2) {
									mysql_query('UPDATE users SET lr_balance = lr_balance + '.$ps.', reftop = reftop + '.$ps.' WHERE id = '.$uref.' LIMIT 1');
								} else {
									mysql_query('UPDATE users SET pm_balance = pm_balance + '.$ps.', reftop = reftop + '.$ps.' WHERE id = '.$uref.' LIMIT 1');
								}
								mysql_query('UPDATE users SET ref_money = ref_money + '.$ps.' WHERE id = '.$uid.' LIMIT 1');

								// Получаем данные следующего пользователя

								$get_ref	= mysql_query("SELECT id, ref FROM users WHERE id = ".intval($uref)." LIMIT 1");
								$rowref		= mysql_fetch_array($get_ref);
								$uref		= $rowref['ref'];
								$uid		= $rowref['id'];

							}

						}
						$i++;
					}
				}

			}
			// Закончили с рефералами

			print '<p class="erok">Депозит открыт! <a href="/deposits/">К списку депозитов »</a></p>';
		}

	} else {
		print '<p class="er">Выберите тарифный план, платежную систему и введите сумму депозита</p>';
	}
	
}
?>
<form method="post" action="?act=open">
<table width="100%" align="center">
<?php
$result	= mysql_query("SELECT * FROM plans ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

print "<tr>
	<td><label><input style=\"float: left;\" type=\"radio\" name=\"plan\" value=\"".$row['id']."\" checked /> <div style=\"padding: 4px; background-color: #eeeeee;\"><b>".$row['name']."</b></div>";
		print "<div style=\"padding-left: 22px;\">Сумма вклада: $".$row['minsum']." - $".$row['maxsum']." под ".$row['percent']."% в ";
		if($row['period'] == 1) { print "день"; } elseif($row['period'] == 2) { print "неделю"; } elseif($row['period'] == 4) { print "час"; } else { print "месяц"; }
		print ", сроком ".$row['days'];
		if($row['period'] == 4) { print " часов"; } elseif($row['period'] == 1) { print " дней"; } elseif($row['period'] == 2) { print " недель"; } elseif($row['period'] == 3) { print " месяцев"; }
		print "</div></label></td>
</tr>
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>
<tr>
	<td height=\"15\"></td>
</tr>";

}
?>
</table>
<div style="margin-top: 15px;"></div>

<table width="100%">
<?php
if($cfgPerfect) {	
?>
<tr>
	<td align="right">Ваш PM баланс:</td>
	<td width="200"><b>$<?php print $pmbalance; ?></b></td>
</tr>
<?php
} 
if($cfgLiberty) {
?>
<tr>
	<td align="right">Ваш LR(Qiwi) баланс:</td>
	<td width="200"><b>$<?php print $lrbalance; ?></b></td>
</tr>
<?php
} 
?>
<tr>
	<td align="right">Сумма ($): </td>
	<td><input style="width: 198px;" type="text" name="sum" value="" /></td>
</tr>
<?php
if($cfgPerfect) {	
?>
<tr>
	<td align="right"><label><input type="radio" name="paysys" value="1" checked /></td>
	<td><b>PerfectMoney</b></label></td>
</tr>
<?php
} 
if($cfgLiberty) {
?>
<tr>
	<td align="right"><label><input type="radio" name="paysys" value="2" /></td>
	<td><b>LibertyReserve(Qiwi)</b></label></td>
</tr>
<?php
} 
?>
<tr>
	<td></td>
	<td><input style="width: 198px;" class="subm" type="submit" value=" Открыть депозит " /></td>
</tr>
</table>
</form>
<?php 
} else {
	print "<p class=\"er\">Для доступа к данной странице вам необходимо авторизироваться</p>";
	include "../login/login_ru.php";
}
?>