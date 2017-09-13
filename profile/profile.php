<link rel="stylesheet" type="text/css" href="/css/demo.css" />
<link rel="stylesheet" type="text/css" href="/css/style.css" />



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



		if (!$email) {
			echo '<p class="er">Следует ввести E-mail!</p>';
		} else {
			if ($pass_1 != $pass_2) {
				echo '<p class="er">Пароль и подтверждение не совпадают!</p>';
			} else {
				if (!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $email)) {
					print '<p class="er">Введите правильно e-mail!</p>';
				} elseif (strlen($lr) != 8 && $lr) {
					print '<p class="er">Введите корректный Payeer кошелёк!</p>';
				} elseif ($lr[0] != 'P' && $lr) {
					print '<p class="er">Введите корректный Payeer кошелёк!</p>';
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

<section>				
                <div id="container_demo" >
                    

                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form action="?action=save" method="post" autocomplete="on"> 
							<center><font color="#f2650a"><h2>Профиль</h2></font></center>
							<br>
                                <p> 
                                    <label for="username" class="uname"  > Пароль </label>
                                    <input id="username" name="pass_1" required="required" type="password" />
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" > Повтор пароля </label>
                                    <input id="password" name="pass_2" required="required" type="password" /> 
                                </p>
								
								<p> 
                                    <label for="password" class="youpasswd" > E-Mail </label>
                                    <input id="password" name="email" required="required" type="text" value="<?php print $a['mail']; ?>" /> 
                                </p>
<?php
if($cfgLiberty) {	
?>
								<p> 
                                    <label for="password" class="youpasswd"> Payeer </label>
                                    <input id="password" name="lr" value="<?php print $a['lr']; ?>" required="required" type="text" placeholder="P1111111" <?php if($a['lr']) { print 'disabled'; } ?> /> 
                                </p>
<?php
}
if($cfgPerfect) {	
?>
								<p> 
                                    <label for="password" class="youpasswd" >Кошелёк PerfectMoney </label>
                                    <input id="password" name="pm" value="<?php print $a['pm']; ?>" required="required" type="text"  /> 
                                </p>
<?php
}	
?>
                                <p > 
                                    <input type="submit" value="Сохранить" /> 
								</p>
                             
                            </form>
                        </div>

                     
						
                    </div>
                </div>  
            </section>
<?php
} else {
	print "<p class=\"er\">You must login to access this page!</p>";
}
?>