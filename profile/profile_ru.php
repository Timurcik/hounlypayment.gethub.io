<?php
defined('ACCESS') or die();
if ($login) {
	if ($_GET['action'] == 'save') {
		$pass_1 = $_POST['pass_1'];
		$pass_2 = $_POST['pass_2'];
		$email	= addslashes(htmlspecialchars($_POST['email'], ENT_QUOTES));
		$icq	= addslashes(htmlspecialchars($_POST['icq'], ENT_QUOTES));
		$lr		= addslashes(htmlspecialchars($_POST['lr'], ENT_QUOTES));
		$pm		= addslashes(htmlspecialchars($_POST['pm'], ENT_QUOTES));

		if($ulr) { $lr = $ulr; }
		if($upm) { $pm = $upm; } 

		if (!$email) {
			echo '<p class="er">Следует ввести E-mail!</p>';
		} else {
			if ($pass_1 != $pass_2) {
				echo '<p class="er">Пароль и подтверждение не совпадают!</p>';
			} else {
				if (!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $email)) {
					print '<p class="er">Введите правильно e-mail!</p>';
				} elseif (strlen($lr) != 8 && $lr) {
					print '<p class="er">Введите корректный LR кошелёк!</p>';
				} elseif ($lr[0] != 'U' && $lr) {
					print '<p class="er">Введите корректный LR кошелёк!</p>';
				} elseif(mysql_num_rows(mysql_query("SELECT lr FROM users WHERE lr = '".$lr."' AND id != ".$user_id)) && $lr) {
					print "<p class=\"er\">Такой LR уже есть в базе!</p>";
				} elseif (strlen($pm) != 8 && $pm) {
					print '<p class="er">Введите корректный PM кошелёк!</p>';
				} elseif ($pm[0] != 'U' && $pm) {
					print '<p class="er">Введите корректный PM кошелёк!</p>';
				} elseif(mysql_num_rows(mysql_query("SELECT pm FROM users WHERE pm = '".$pm."' AND id != ".$user_id)) && $pm) {
					print "<p class=\"er\">Такой PM уже есть в базе!</p>";
				} elseif(mysql_num_rows(mysql_query("SELECT mail FROM users WHERE mail = '".$email."' AND id != ".$user_id))) {
					print "<p class=\"er\">Такой e-mail уже есть в базе!</p>";
				} else {
					$sql = 'UPDATE users SET ';
					if($pass_1) { $sql .= 'pass = "'.as_md5($key, $pass_1).'", '; }

					$sql .= 'mail = "'.$email.'", icq = "'.$icq.'", lr = "'.$lr.'", pm = "'.$pm.'" WHERE id = '.$user_id.' LIMIT 1';
					if (mysql_query($sql)) {
						print '<p class="erok">Данные были успешно обновлены!</p>';
					} else {
						print '<p class="er">Не удаётся изменить данные!</p>';
					}
			}
		}
	}
}

$sql	= 'SELECT * FROM users WHERE login = "'.$login.'" LIMIT 1';
$rs		= mysql_query($sql);
$a		= mysql_fetch_array($rs);
?>
<form action="?action=save" method="post">
<table align="center" width="350" border="0" cellpadding="2" cellspacing="1">
	<tr>
		<td>Пароль: </td>
		<td align="right"><input type='password' name='pass_1' size="30" /></td>
	</tr>
	<tr>
		<td>Подтверждение: </td>
		<td align="right"><input type='password' name='pass_2' size="30" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> E-mail:</td>
		<td align="right"><input type='text' name='email' value='<?php print $a['mail']; ?>' size="30" maxlength="30" /></td>
	</tr>
<?php
if($cfgLiberty) {	
?>
	<tr>
		<td>LibertyReserve(Qiwi): </td>
		<td align="right"><input type='text' name='lr' value='<?php print $a['lr']; ?>' size="30" maxlength="8" <?php if($a['lr']) { print 'disabled'; } ?> /></td>
	</tr>
<?php
}
if($cfgPerfect) {	
?>
	<tr>
		<td>PerfectMoney: </td>
		<td align="right"><input type='text' name='pm' value='<?php print $a['pm']; ?>' size="30" maxlength="8" <?php if($a['pm']) { print 'disabled'; } ?> /></td>
	</tr>
<?php
}	
?>
</table>
<div align="center" style="padding-top: 10px;"><input class="subm" type="submit" name="submit" value=" Сохранить " /></div>
</form>
<?php
} else {
	print "<p class=\"er\">Вы должны авторизироваться для доступа к этой странице!</p>";
}
?>