<link rel="stylesheet" type="text/css" href="/css/demo.css" />
<link rel="stylesheet" type="text/css" href="/css/style.css" />
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

		if(!$ulogin || !$pass || !$repass || !$email) {
			$error = "<p class=\"er\">Заполните все поля обязательные для заполнения</p>";
		} elseif(strlen($ulogin) > 20 || strlen($ulogin) < 3) {
			$error = "<p class=\"er\">Логин должен содержать от 3-х до 20 символов</p>";
		} elseif($pass != $repass) {
			$error = "<p class=\"er\">Пароли не совпадают</p>";
		} elseif(strlen($email) > 30) {
			$error = "<p class=\"er\">E-mail должен содержать до 30 символов</p>";
		//} elseif(!mysql_num_rows(mysql_query("SELECT * FROM captcha WHERE sid = '".$sid."' AND ip = '".getip()."' AND code = '".$code."'"))) {
			//$error = "<p class=\"er\">Введёный код с рисунка, не совпадает!</p>";
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
			if($referal) { $ref_id = intval($referal); } else { $ref_id = 0; }

			$sql = "INSERT INTO users (login, pass, mail, go_time, ip, reg_time, ref, lr, pm) VALUES ('".$ulogin."', '".$pass."', '".$email."', ".$time.", '".$ip."', ".$time.", ".$ref_id.", '".$lr."', '".$pm."')";
			mysql_query($sql);

			$subject = "Поздравляем Вас с успешной регистрацией";

			$headers = "From: ".$adminmail."\n";
			$headers .= "Reply-to: ".$adminmail."\n";
			$headers .= "X-Sender: < http://".$cfgURL." >\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\n";

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
<section>				
                <div id="container_demo" >
                    
                    <div id="wrapper">


                        <div  class="animate form">
                            <form action="?action=save" method="post" autocomplete="on"> 
							<center><font color="#f2650a"><h2>Регистрация</h2></font></center>
							<br>
                                <p> 
                                    <label for="usernamesignup" class="uname" ><font color=red>*</font> Логин</label>
                                    <input id="usernamesignup" name="ulogin" required="required" type="text"  />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" ><font color=red>*</font> E-mail</label>
                                    <input id="emailsignup" name="email" required="required" type="email" /> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" ><font color=red>*</font> Пароль </label>
                                    <input id="passwordsignup" name="pass" required="required" type="password" />
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" ><font color=red>*</font> Пароль повторно </label>
                                    <input id="passwordsignup_confirm" name="repass" required="required" type="password" />
                                </p>
<?php
if($cfgLiberty) {	
?>
								<p> 
                                    <label for="passwordsignup_confirm" class="youmail" ><font color=red>*</font> Payeer </label>
                                    <input id="emailsignup" name="lr" required="required" type="text" placeholder="P1111111"/>
                                </p>
								
<?php
}
if($cfgPerfect) {	
?>
								<p> 
                                    <label for="passwordsignup_confirm" class="youmail" ><font color=red>*</font> Кошелёк PerfectMoney </label>
                                    <input id="emailsignup" name="pm" required="required" type="text" />
                                </p>
<?php
}


	if($referal) {
	
			$get_user_info	= mysql_query("SELECT * FROM users WHERE id = ".intval($referal)." LIMIT 1");
		$row			= mysql_fetch_array($get_user_info);
		$refname		= $row['login'];

		print '<p><label for="passwordsignup_confirm" class="uname" >Ваc пригласил </label>
                                    <input id="passwordsignup_confirm"  required="required" disabled type="text" value='.$refname.'>
                                </p>';
	}	
?>

                                Поля отмеченые <font color=red>*</font> обязательны к заполнению
                                
									<input type="submit" value="Регистрация"/> 
								

                        </div>
						
                    </div>
                </div>  
            </section>
<br><br><br>
<?php



} 
?>