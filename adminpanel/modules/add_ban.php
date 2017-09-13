
<?
defined('ACCESS') or die();

$id = intval($_GET['id']);



if ($_GET["p"]==save) {
$ps	= intval($_POST['ps']);
$save="UPDATE plat_sistem SET status='$ps' WHERE id='$id'";
mysql_query($save);
//print" / <font color=#00cc00><b>Настройки сохранены!</b></font>";
if ($save != 'true'){print"<font color=#00cc00><b>Настройки сохранены!</b></font>";
}
else{
	print"<font color=red><b>Настройки несохранены!</b></font>";
}
}


$sql="SELECT * FROM plat_sistem";
$result=mysql_query($sql);

while($row=mysql_fetch_array($result)){
echo"<br><b>Платежная система <font color=\"green\">$row[name]</font></b>


<form action=index.php?page=plat_sistem&p=save&id=$row[id] method=POST class=\"niceform\">

<dl>
                        <dt><label for=\"gender\">ВКЛ/ВЫКЛ:</label></dt>
                        <dd>
                            <select size=\"1\" name=\"ps\">
							
                                <option value=\"1\">Включить</option>
								
								
                                <option value=\"2\">Выключить</option>
								
								 <option value=\"\"></option>
                        <input type=hidden name=id />
                            </select>";
							if ($row[status] == 1) {
							echo"<dt><font color=\"green\">Включено</font></dt>";
							}
							else{
							echo"<dt><font color=\"red\">Выключено</font></dt>";
							}
                       echo"</dd>
                    </dl>
					 <dl class=\"submit\">
<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Сохранить\" />
</dl>


</form>
<br><br>";}

?>

