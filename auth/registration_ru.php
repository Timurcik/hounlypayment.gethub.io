<?php
print $body;
defined('ACCESS') or die();
if($_GET['action'] == "save") {
		$ulogin	= htmlspecialchars($_POST['ulogin'], ENT_QUOTES);
		$pass	= $_POST['pass'];
		$repass	= $_POST['repass'];
		$email	= htmlspecialchars($_POST['email'], ENT_QUOTES);
		$code	= htmlspecialchars($_POST["code"], ENT_QUOTES);
		$lr		= htmlspecialchars($_POST["lr"], ENT_QUOTES);
		$pm		= htmlspecialchars($_POST["pm"], ENT_QUOTES);
		$yes	= intval($_POST['yes']);

		if(!$ulogin || !$pass || !$repass || !$email || !$yes) {
			$error = "<p class=\"er\">Заполните все поля обязательные для заполнения</p>";
		} elseif(strlen($ulogin) > 20 || strlen($ulogin) < 3) {
			$error = "<p class=\"er\">Логин должен содержать от 3-х до 20 символов</p>";
		} elseif($pass != $repass) {
			$error = "<p class=\"er\">Пароли не совпадают</p>";
		} elseif(strlen($email) > 30) {
			$error = "<p class=\"er\">E-mail должен содержать до 30 символов</p>";
		} elseif(!mysql_num_rows(mysql_query("SELECT * FROM captcha WHERE sid = '".$sid."' AND ip = '".getip()."' AND code = '".$code."'"))) {
			$error = "<p class=\"er\">Введёный код с рисунка, не совпадает!</p>";
		} elseif(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $email)) {
			$error = "<p class=\"er\">Введите валидно e-mail</p>";
		} elseif(mysql_num_rows(mysql_query("SELECT login FROM users WHERE login = '".$ulogin."'"))) {
			$error = "<p class=\"er\">Такой логин уже есть в базе! Выберите пожалуйста другой</p>";
		} elseif(mysql_num_rows(mysql_query("SELECT mail FROM users WHERE mail = '".$email."'"))) {
			$error = "<p class=\"er\">Такой e-mail уже есть в базе!</p>";
		} else {
			$time	 = time();
			$ip		 = getip();
			$pass	 = as_md5($key, $pass);
			if($referal) { 
				$get_user_info	= mysql_query("SELECT * FROM users WHERE login = '".$referal."' LIMIT 1");
				$row			= mysql_fetch_array($get_user_info);
				$ref_id			= intval($row['id']);
			} else { 
				$ref_id = 0; 
			}

			$sql = "INSERT INTO users (login, pass, mail, go_time, ip, reg_time, ref, lr, pm) VALUES ('".$ulogin."', '".$pass."', '".$email."', ".$time.", '".$ip."', ".$time.", ".$ref_id.", '".$lr."', '".$pm."')";
			mysql_query($sql);

			$subject = "Поздравляем Вас с успешной регистрацией";

			$headers = "From: ".$adminmail."\n";
			$headers .= "Reply-to: ".$adminmail."\n";
			$headers .= "X-Sender: < http://".$cfgURL." >\n";
			$headers .= "Content-Type: text/html; charset=windows-1251\n";

			$text = "Здравствуйте <b>".$ulogin."!</b><br />Поздравляем Вас с успешной регистрацией в сервисе <a href=\"http://".$cfgURL."/\" target=\"_blank\">http://".$cfgURL."</a><br />Ваш Login: <b>".$ulogin."</b><br />Ваш пароль: <b>".$repass."</b><br /><br />С Уважением, администрация проекта ".$cfgURL;

			mail($email, $subject, $text, $headers);

			$ulogin	= "";
			$pass	= "";
			$repass	= "";
			$email	= "";
			$lr		= "";
			$pm		= "";

			$error = 1;
		}
}

if($error == 1) {

	print "<p class=\"erok\">Поздравляем! Вы зарегистрировались. Авторизируйтесь пожалуйста.</p>";

} else {
	print $error;
?>
<center>
<form action="?action=save" method="post">
<table align="center" width="400" border="0" cellpadding="3" cellspacing="1">
	<tr>
		<td><font color="red"><b>!</b></font> Логин:</td>
		<td align="center"><input style="width: 200px;" type="text" name="ulogin" value="<?php print $ulogin; ?>" size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> Пароль:</td><td align="center"><input style="width: 200px;" type="password" name="pass" size="30" maxlength="20" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> Пароль повторно:</td>
		<td align="center"><input style="width: 200px;" type="password" name="repass" size="30" maxlength="20" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> E-mail:</td>
		<td align="center"><input style="width: 200px;" type="text" name="email" value="<?php print $email; ?>" size="30" maxlength="30" /></td>
	</tr>
<?php
if($cfgLiberty) {	
?>
	<tr>
		<td>LibertyReserve:</td><td align="center"><input style="width: 200px;" type="text" name="lr" value="<?php print $lr; ?>" size="30" maxlength="10" /></td>
	</tr>
<?php
}
if($cfgPerfect) {	
?>
	<tr>
		<td>PerfectMoney: </td><td align="center"><input style="width: 200px;" type="text" name="pm" value="<?php print $pm; ?>" size="30" maxlength="10" /></td>
	</tr>
<?php
}	
?>
	<tr>
		<td align="right"><img src="/captcha.php" width="70" height="25" border="0" alt="Введите код изображённый на рисунке" /></td><td align="center"><input style="width: 200px; height: 25px; font-size: 16px; font-weight: bold;" type="text" name="code" size="17" maxlength="5" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><font color="red"><b>!</b></font> <label><input class="check" type="checkbox" name="yes" value="1" /> <b>Я согласен с <a href="/law/" target="_blank">правилами</a> проекта.</b></label></td>
	</tr>
</table>
</center>
<div align="center" style="padding-top: 10px; padding-bottom: 15px;"><input class="subm" type="submit" name="submit" value=" Регистрация " /></div>
</form>
<?php

	if($referal) {
		print '<center>Ваш Upline: '.$referal.'</center>';
	}

} 
?>