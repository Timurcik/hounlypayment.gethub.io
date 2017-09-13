<!-- Breadcrumbs Begin -->
				

				<!-- Breadcrumbs End -->
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
	<div class="general-block-outer">
	
					<div class="general-block cart-container">
												<center><font color="#f2650a"><h2>Создать депозит</h2></font></center>
							<br>

						<table cellpadding="0" cellspacing="0">
						<tr>
								<td class="remove"><span class="heading"></span></td>
								<td style="width:200px" class="product-name"><span class="heading">Тариф</span></td>
								
								<td style="width:250px" class="product-name"><span class="heading">Сумма </span></td>
								<td style="width:200px" class="product-name"><span class="heading">Процент</span></td>

								<td style="width:200px" class="product-name"><span class="heading">Срок</span></td>
							</tr>
<?php
$result	= mysql_query("SELECT * FROM plans ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

print "<tr>
								<td class=\"remove\"><input style=\"float: center;\" type=\"radio\" name=\"plan\" value=\"".$row['id']."\" checked /></td>
								<td style=\"width:200px\" class=\"product-name\">".$row['name']."</td>
								<td style=\"width:550px\" class=\"product-name\">$".$row['minsum']." - $".$row['maxsum']."</td>
								<td style=\"width:200px\" class=\"product-name\">".$row['percent']."% в час</td>
				
								<td style=\"width:200px\" class=\"product-name\">".$row['days']."";
								if($row['period'] == 4) { print " часов"; } elseif($row['period'] == 1) { print " дней"; } elseif($row['period'] == 2) { print " недель"; } elseif($row['period'] == 3) { print " месяцев"; }
								print"</td>
							</tr>








";

}
?>

<tr class="promo"> 
                                <td></td>
								<td colspan="4" class="unit-price"><span class="grey">Введите сумму (&#36;) до $<?php print $pmbalance; ?></span></td>
								
								<td class="quantity"><input type="text" name="sum" value="" class="styled-input cart-field"></td>
								
							</tr>
<?php
if($cfgPerfect) {	
?>
							<tr style="display: none;">
								<td colspan="4" class="unit-price"><input type="radio"  checked="checked" name="paysys" value="1" /></td>
								<td class="quantity"><span class="summary">PerfectMoney</span></td>
								<td class="price"><span class="summary">&#36; <?php print $pmbalance; ?></span></td>
							</tr>
							
<?php
} 
if($cfgLiberty) {
?>							
							<tr>
								<td colspan="4" class="unit-price"><input type="radio" name="paysys" value="2" /></td>
								<td class="quantity"><span class="summary">Payeer</span></td>
								<td class="price"><span class="summary">&#36; <?php print $lrbalance; ?></span></td>
							</tr>
<?php
} 
?>							
							<tr class="last submit">
								<td colspan="4" class="unit-price"></td>
								<td class="quantity">
									
								</td>
								<td class="price">
								<input type="submit" value=" Открыть депозит " />
									
								</td>
							</tr>
						</table>
					</div>
				</div>
<div style="margin-top: 15px;"></div>


</form>
<?php 
} else {
	print "<p class=\"er\">Для доступа к данной странице вам необходимо авторизироваться</p>";
	include "../login/login_ru.php";
}
?>