

<table align="center">
<tr bgcolor="#dddddd">
	<td><b>Уровень</b></td>
	<td><b>Процент</b></td>
	<td width="32"></td>
	<td width="32"></td>
</tr>
<?php
$query	= "SELECT * FROM reflevels ORDER BY id ASC";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {

print '<form action="?act=editlevel&id='.$row['id'].'" method="post"><tr bgcolor="#eeeeee">
	<td><input class="inp" type="text" size="10" name="level" value="'.$row['id'].'" /></td>
	<td><input class="inp" type="text" size="10" name="percent" value="'.$row['sum'].'" /></td>
	<td align="center" bgcolor="#ffffff"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	<td align="center" bgcolor="#ffffff"><img style="cursor:pointer;" onclick="if(confirm(\'Вы действительно хотите удалить данный уровень?\')) top.location.href=\'?act=dellevel&id='.$row['id'].'\';" src="images/delite.gif" width="20" height="20" border="0" alt="Удалить" /></td>
</tr></form>';

}
?>
</table>