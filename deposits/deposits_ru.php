<?php
defined('ACCESS') or die();
if($login) {
?>
<table width="100%" align="center">
<?php
$s = 0;
$result	= mysql_query("SELECT * FROM deposits WHERE user_id = ".$user_id." ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

	$result2	= mysql_query("SELECT * FROM plans WHERE id = ".$row['plan']." LIMIT 1");
	$row2		= mysql_fetch_array($result2);

print "<tr>
	<td><div style=\"padding: 4px; background-color: #eeeeee;\"><b>Сумма: $".$row['sum']."</b></div>";

	print "под ".$row2['percent']."% в ";
	if($row2['period'] == 1) { print "день"; } elseif($row2['period'] == 2) { print "неделю"; }  elseif($row2['period'] == 4) { print "час"; } else { print "месяц"; }
	print ", сроком ".$row2['days'];
	if($row2['period'] == 4) { print " часов"; } elseif($row2['period'] == 1) { print " дней"; } elseif($row2['period'] == 2) { print " недель"; } elseif($row2['period'] == 3) { print " месяцев"; }
	print "<br />	
	Был открыт: ".date("d.m.Y H:i", $row['date'])."
	</td>
</tr>
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";

if(cfgSET('autopercent') == "on") {
print "<tr>
	<td align=\"center\"><b>До следующей выплаты осталось: <span id=\"deptimer".$row['id']."\"></span></b> [ ".date("H:i d.m.Y", $row['nextdate'])." ]</td>
</tr>
<tr>
	<td class=\"lineclock\">
		<div id=\"percentline".$row['id']."\" class=\"percentline\">&nbsp;</div>
		<script language=\"JavaScript\">
		<!--
			CalcTimePercent(".$row['id'].", ".$row['lastdate'].", ".$row['nextdate'].", ".time().", ".$row2['period'].");
		//-->
		</script>
	</td>
</tr>
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";
}

print "<tr>
	<td height=\"20\"></td>
</tr>";
$s = $s + $row['sum'];
}
?>
</table>
<?php 

	if($s == 0) {
		print '<p class="er">У вас нет открытых депозитов</p>';
	} else {
		print 'Всего открытых депозитов на сумму <b>$'.$s.'</b>';
	}

} else {
	print "<p class=\"er\">Для доступа к данной странице вам необходимо авторизироваться</p>";
}
?>