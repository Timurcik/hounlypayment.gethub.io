<?php
defined('ACCESS') or die();
function generator($case1, $case2, $case3, $case4, $num1) {
	$password = "";

	$small="abcdefghijklmnopqrstuvwxyz";
	$large="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$numbers="1234567890";
	$symbols="~!#$%^&*()_+-=,./<>?|:;@";
	mt_srand((double)microtime()*1000000);

	for ($i=0; $i<$num1; $i++) {

		$type = mt_rand(1,4);
		switch ($type) {
		case 1:
			if ($case1 == "on") { $password .= $large[mt_rand(0,25)]; } else { $i--; }
			break;
		case 2:
			if ($case2 == "on") { $password .= $small[mt_rand(0,25)]; } else { $i--; }
			break;
		case 3:
			if ($case3 == "on") { $password .= $numbers[mt_rand(0,9)]; } else { $i--; }
			break;
		case 4:
			if ($case4 == "on") { $password .= $symbols[mt_rand(0,24)]; } else { $i--; }
			break;
		}
	}
	return $password;
}

if($_GET['action'] == "send" AND isset($_POST['email']) AND isset($_POST['ulogin'])) {
	$email	= htmlspecialchars($_POST['email'], ENT_QUOTES);
	$ulogin = htmlspecialchars($_POST['ulogin'], ENT_QUOTES);
	$code	= htmlspecialchars(str_replace("'","",$_POST["code"]), ENT_QUOTES);
	if(!mysql_num_rows(mysql_query("SELECT * FROM captcha WHERE sid = '".$sid."' AND ip = '".getip()."' AND code = '".$code."'"))) {
			print "<p class=\"er\">Не правильно введён код!</b></font></center></p>";
	}  elseif(preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $email)) {
		$sql	= 'SELECT login, pass, status FROM users WHERE mail = "'.$email.'" AND login = "'.$ulogin.'" LIMIT 1';
		$rs		= mysql_query($sql);
		$a		= mysql_fetch_array($rs);
		$s		= $a['status'];

		if (!$a) {
			print '<p class="er">Введённый Вами e-mail не найден в базе!</p>';
		} else {

			$case1	= on;
			$case2	= on;
			$case3	= on;
			$case4	= on;
			$num1	= 8;
			$num2	= 1;

			$newpass = generator($case1, $case2, $case3, $case4, $num1);

			$text = "<p>Здравствуйте <b>".$a['login']."</b>!</p><p>По Вашей просьбе высылаем новый пароль к аккаунту ".$a['login']."<br /><p>Новый пароль: <b>".$newpass."</b></p>С Уважением, администрация проекта ".$cfgURL;

			$subject	 = "Новый пароль к аккаунту ".$a['login'];
			$headers = "From: ".$adminmail."\n";
			$headers .= "Reply-to: ".$adminmail."\n";
			$headers .= "X-Sender: < http://".$cfgURL." >\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\n";

			mysql_query("UPDATE users SET pass = '".as_md5($key, $newpass)."' WHERE login = '".$a['login']."' LIMIT 1");
			if (mail($email,$subject,$text,$headers)) {
				print '<p class="erok">Новый пароль был выслан на Ваш E-mail!</p>';
			} else {
				print '<p class="er">Не удаётся отправить письмо!</p>';
			}
		}
	} else {
		print '<p class="er">Введите валидный e-mail!</p>';
	}
}
?>
	<div class="general-block-outer">
	
					<div class="general-block cart-container">
												<center><font color="#f2650a"><h2>Восстановить пароль</h2></font></center>
							<br>
<table align="center" border=0>
<form action="?action=send" method=post>
	<tr>
		<td><strong>Логин</strong>: </td>
	</tr>
	<tr>
		<td><input style="width: 243px;" type="text" name="ulogin" size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td><strong>E-mail</strong>: </td>
	</tr>
	<tr>
		<td><input style="width: 243px;" type="text" name="email" size="45" maxlength="30" /></td>
	</tr>
	<tr>
		<td>
			<table align="center" cellpadding="1" cellspacing="1" border="0">
				<tr>
					<td><img src="/captcha.php" width="70" height="25" border="0" alt="Введите код изображённый на рисунке" /></td>
					<td><input style="width: 90px; height: 25px; font-size: 16px; font-weight: bold;" type="text" name="code" size="5" maxlength="5" /></td>
					<td><input  type="submit" value=" Отправить " /></td>
				</tr>
			</table>
		</td>
	</tr>
</form>
</table>
</div></div>