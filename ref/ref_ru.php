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

		print "<p>Ваш Upline: <b>".$uplogin."</b>; Вы принесли ему: <b>$".$ref_money."</b></p>";

	}
?>
<FIELDSET style="border: solid #666666 1px; margin-bottom: 5px;">
<LEGEND><b>Ваша партнёрская ссылка:</b></LEGEND>
<table width="100%">
	<tr align="center">
		<td><input type="text" name="refurl" style="width: 100%;" value="http://<?php print $cfgURL; ?>/?ref=<?php print $login; ?>" /></td>
	</tr>
</table>
</FIELDSET>

<hr color="#cccccc" size="2">
<b>Приглашённые Вами пользователи:</b>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#eeeeee">
<tr align="center" bgcolor="#ccffcc" style="background:URL(/images/title_bg.gif) repeat-x top left;">
	<td width="50" style="padding: 3px;"><b>#</b></td>
	<td align="left"><b>Login:</b></td>
	<td width="150"><b>Доход $:</b></td>
</tr>
<?php

	$sql	= 'SELECT login, ref_money FROM users WHERE ref = '.$user_id;
	$rs		= mysql_query($sql);
	if(mysql_num_rows($rs)) {

		$i = 1;
		$m = 0;
		while($a = mysql_fetch_array($rs)) {
			$money = $a['ref_money'];
			print "<tr bgcolor=\"#ffffff\" align=\"center\"><td style=\"padding: 3px;\">".$i."</td><td align=\"left\">".$a['login']."</td><td>".sprintf("%01.2f", $money)."</td></tr>";
			$m = $m + $money;
			$i++;
		}
print "<tr align=\"center\" bgcolor=\"#dddddd\">
	<td align=\"right\" colspan=\"2\" style=\"padding: 3px;\"><b>Всего:</b></td>
	<td><b>".sprintf("%01.2f", $m)."</b></td>
</tr>";
	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">Вы пока никого не пригласили!</td></tr>";
	}
print "</table>";

} else {
	print '<p class="er">Вам необходимо авторизироваться для доступа к данной странице</p>';;
}
?>