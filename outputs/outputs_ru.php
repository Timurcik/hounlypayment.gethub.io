<?php
function topics_list2($page, $num, $query)
{
?>
<table align="center" width="100%" border="0" bgcolor="#cccccc" cellpadding="1" cellspacing="1">
<tr align="center" height="19" bgcolor="#ccffcc" style="background:URL(/images/title_bg.gif) repeat-x top left;">
	<td width="150"><b>Дата</b></td>
	<td><b>Логин</b></td>
	<td width="100"><b>Сумма</b></td>
	<td width="70"><b>Система</b></td>
</tr>
<?php
	$result = mysql_query($query.' LIMIT 10');
	while ($topics = mysql_fetch_array($result))
	{

		print '<tr align="center" bgcolor="#ffffff">
		<td>'.date("d.m.Y H:i:s", $topics['date']).'</td>
		<td align="left"><b>'.$topics['login'].'</b></td>
		<td>'.$topics['sum'].'</td>
		<td>';
		if($topics['paysys'] == 1) { print "PerfectMoney"; } else { print "LibertyReserve"; }
		print '</td></tr>';

	}
?>
</table>
<?php
}

$sql = 'SELECT * FROM output WHERE status = 2 ORDER BY id DESC';

topics_list2(1, 10, $sql);

?>