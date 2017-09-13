

<?php
if($login) {
defined('ACCESS') or die();
	print $body;

	$get_user_info = mysql_query("SELECT ref, ref_money FROM users WHERE id = ".$user_id." LIMIT 1");
	$row = mysql_fetch_array($get_user_info);
	 $ref			= $row['ref'];
	 $ref_money		= $row['ref_money'];	

	if($ref) {

		$get_user_info2	= mysql_query("SELECT login FROM users WHERE id = ".$ref." LIMIT 1");
		$row2 			= mysql_fetch_array($get_user_info2);
		 $uplogin	= $row2['login'];

		print "<p>Вас пригласил: <b>".$uplogin."</b>; Вы принесли ему: <b>$".$ref_money."</b></p>";

	}
?>
<br><br>
<div class="general-block-outer">
					<div class="general-block breadcrumbs">
							<center><font color="#f2650a"><h2>Рекламные материалы</h2></font></center>
							<br>						
						<ul class="breadcrumbs">
							
							<a>Ваша партнёрская ссылка: </a><b>https://<?php print $cfgURL; ?>/?ref=<?php print $user_id; ?></b>
							
												<br><br>
							<a><b>Баннер 468x60 px:</b></a><br>
							<textarea rows="2" cols="55" readonly><a href="https://hourlypayment.org/?ref=<?php print $user_id; ?>"><img src="https://hourlypayment.org/468x60.gif"></a></textarea>
							<br>
								<img src="https://hourlypayment.org/468x60.gif"> 
																			<br><br>
							<a><b>Баннер 728x90 px:</b></a><br>
							<textarea rows="2" cols="55" readonly><a href="https://hourlypayment.org/?ref=<?php print $user_id; ?>"><img src="https://hourlypayment.org/728x90.gif"></a></textarea>
							<br>
							<img src="https://hourlypayment.org/728x90.gif"> 
							
						</ul>
						<br class="clear"/>
					</div>
				</div>
<br>

<div class="general-block-outer">
					<div class="general-block cart-container">
					
							<center><font color="#f2650a"><h2>Приглашённые Вами пользователи</h2></font></center>
							<br>						
						<table cellpadding="0" cellspacing="0">
						<tr>
								<td class="remove"><span class="heading">№</span></td>
								<td style="width:200px" class="product-name"><span class="heading">Login</span></td>
								
								<td style="width:250px" class="product-name"><span class="heading">Доход $</span></td>
								
							</tr>


<?php

	$sql	= 'SELECT login, ref_money FROM users WHERE ref = '.$user_id;
	$rs		= mysql_query($sql);
	if(mysql_num_rows($rs)) {

		$i = 1;
		$m = 0;
		while($a = mysql_fetch_array($rs)) {
			$money = $a['ref_money'];
			print "<tr>
								<td class=\"remove\">".$i."</td>
								<td style=\"width:200px\" class=\"product-name\">".$a['login']."</td>
								<td style=\"width:550px\" class=\"product-name\">".sprintf("%01.2f", $money)."</td>
								
								
							</tr>
							
							";
			$m = $m + $money;
			$i++;
		}
print "



<tr align=\"center\" bgcolor=\"#dddddd\">
	<td align=\"right\" colspan=\"2\" style=\"padding: 3px;\"><b>Всего:</b></td>
	<td><b>".sprintf("%01.2f", $m)."</b></td>
</tr>";
	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">Вы пока никого не пригласили!</td></tr>";
	}
print "</table></div>
				</div>";

} else {
	print '<p class="er">Вам необходимо авторизироваться для доступа к данной странице</p>';;
}
?>