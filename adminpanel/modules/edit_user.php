<?php


defined('ACCESS') or die();
if($_GET[action] == "add") {
	$pass		= $_POST['pass'];
	$repass		= $_POST['re_pass'];
	$mail		= htmlspecialchars($_POST['mail'], ENT_QUOTES);
	$ul			= htmlspecialchars($_POST['ul'], ENT_QUOTES);
	$com		= htmlspecialchars($_POST['com'], ENT_QUOTES);
	$lr			= htmlspecialchars($_POST['lr'], ENT_QUOTES);
	$pm			= htmlspecialchars($_POST['pm'], ENT_QUOTES);

	if($pass && $repass) {

		if($pass == $repass) {
			mysql_query('UPDATE users SET pass = "'.as_md5($key, $pass).'" WHERE id = '.intval($_GET[id]).' LIMIT 1');
			print "<font color=\"green\">1. Пароль изменён!</font><br />";
		} else {
			print "<font color=\"red\">1. Пароль не изменён, из-за несовпадения введённых паролей!</font><br />";
		}

	} else {
		print "<font color=\"blue\">1. Пароль остался преждним!</font><br />";
	}

	if($mail) {
		if(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is",$mail)) {
			print "<font color=\"red\">2. Введите правильный e-mail!</font><br />";
		} else {
			mysql_query('UPDATE users SET mail = "'.$mail.'", comment = "'.$com.'", lr_balance = lr_balance + '.sprintf("%01.2f", $_POST['lrbal']).', pm_balance = pm_balance + '.sprintf("%01.2f", $_POST['pmbal']).', lr = "'.$lr.'", pm = "'.$pm.'" WHERE id = '.intval($_GET['id']).' LIMIT 1');
			print "<font color=\"green\">2. Данные сохранены!</font><br />";

			if($_POST['lrbal'] != 0.00) {
				mysql_query('INSERT INTO enter (sum, date, login, status, purse, paysys) VALUES ("'.sprintf("%01.2f", $_POST['lrbal']).'", "'.time().'", "'.$ul.'", 2, "АДМИНИСТРАТОР", "LR")');
			}

			if($_POST['pmbal'] != 0.00) {
				mysql_query('INSERT INTO enter (sum, date, login, status, purse, paysys) VALUES ("'.sprintf("%01.2f", $_POST['pmbal']).'", "'.time().'", "'.$ul.'", 2, "АДМИНИСТРАТОР", "PM")');
			}	

		}
	} else {
		print "<font color=\"red\">2. Не заполнены все поля!</font><br />";
	}
}

if($_GET[action] == "mailto") {

$subject	= $_POST['subject'];
$msg		= $_POST['msg'];

	$query	= "SELECT mail FROM users WHERE id = ".intval($_GET[id])." LIMIT 1";
	$result	= mysql_query($query);
	$row	= mysql_fetch_array($result);
	$mail	= $row['mail'];

	$headers = "From: ".$adminmail."\n";
	$headers .= "Reply-to: ".$adminmail."\n";
	$headers .= "X-Sender: < http://".$cfgURL." >\n";
	$headers .= "Content-Type: text/html; charset=windows-1251\n";

	mail($mail, $subject, $msg, $headers);

	print "<p class=\"erok\">Сообщение отправлено</p>";

}

$get_user = mysql_query("SELECT * FROM users WHERE id = ".intval($_GET['id'])." LIMIT 1");
$rows = mysql_fetch_array($get_user);
 $email		= $rows['mail'];
 $lrbal		= $rows['lr_balance'];
 $pmbal		= $rows['pm_balance'];
 $com		= $rows['comment'];
 $lr		= $rows['lr'];
 $pm		= $rows['pm'];
?>
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b>Редактирование данных пользователя</b></LEGEND>
<form action="?a=edit_user&id=<?php print intval($_GET['id']); ?>&action=add" method="post">
<input type="hidden" name="ul" value="<?php print $rows['login']; ?>" />
<table align="center" width="612" border="0" cellpadding="3" cellspacing="0" style="border: solid #cccccc 1px;">
<tr bgcolor="#dddddd">
	<td><b>Пароль</b>:</td>
	<td align="right"><input class="inp" style="background-color: #dddddd; width: 480px;" type="password" name="pass" size="70" maxlength="50" value="" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Пароль</b> <small>[повторно]</small>:</td>
	<td align="right"><input class="inp" style="width: 480px;" type="password" name="re_pass" size="70" maxlength="50" value="" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><font color="red"><b>!</b></font> <b>E-mail</b>:</td>
	<td align="right"><input class="inp" style="background-color: #dddddd; width: 480px;" type="text" name="mail" size="70" maxlength="30" value="<?php print $email; ?>" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Комментарий</b>:</td>
	<td align="right"><input class="inp" style="width: 480px;" type="text" name="com" size="70" maxlength="150" value="<?php print $com; ?>" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Баланс LR</b> [<?php print $lrbal; ?>]:</td>
	<td align="right"><input class="inp" style="background-color: #dddddd; width: 480px;" type="text" name="lrbal" size="70" maxlength="30" value="" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Баланс PM</b> [<?php print $pmbal; ?>]:</td>
	<td align="right"><input class="inp" style="width: 480px;" type="text" name="pmbal" size="70" maxlength="30" value="" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>LR счет</b>:</td>
	<td align="right"><input class="inp" style="background-color: #dddddd; width: 480px;" type="text" name="lr" size="70" maxlength="30" value="<?php print $lr; ?>" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>PM счет</b>:</td>
	<td align="right"><input class="inp" style="width: 480px;" type="text" name="pm" size="70" maxlength="30" value="<?php print $pm; ?>" /></td>
</tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>

<script type="text/javascript" src="editor/tiny_mce_src.js"></script>
<script type="text/javascript">
	tinyMCE.init({

		mode : "exact",
		elements : "elm1",
		theme : "advanced",
		plugins : "cyberfm,safari, inlinepopups,advlink,advimage,advhr,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
		language: "ru",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,hr,|,forecolor,backcolor,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "pasteword,|,bullist,numlist,|,link,image,media,|,tablecontrols,|,replace,charmap,cleanup,fullscreen,preview,code",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		content_css : "adminpanel/files/styles.css",

		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>

<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>Отправка сообщения пользователю</b></LEGEND>
<form action="?a=edit_user&id=<?php print intval($_GET['id']); ?>&action=mailto" method="post" name="mainForm">
<table bgcolor="#eeeeee" width="612" align="center" border="0" style="border: solid #cccccc 1px; width: 612px;">
<tr><td align="center"><input class="inp" style=" width: 606px;" size="97" name="subject" value="Сообщение от администратора проекта <?php print $cfgURL; ?>" type="text" maxlength="100"></td></tr>
<tr><td align="center" style="padding-bottom: 10px;"><textarea id="elm1" style="width: 605px;" name="msg" cols="103" rows="20"></textarea>
</td></tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Отправить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>