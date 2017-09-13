<?php
	$page = 'login';
	$file = 'login.php';
	$idpg = 2;
	include '../cfg.php';
	include '../ini.php';

$user			= addslashes(htmlspecialchars($_POST["user"], ENT_QUOTES));
$password		= $_POST['pass'];

$get_pass	= mysql_query("SELECT id, login, pass, status FROM users WHERE login = '".$user."' LIMIT 1");
$row		= mysql_fetch_array($get_pass);
 $id			= $row['id'];
 $login			= $row['login'];
 $user_password = $row['pass'];
 $status		= $row['status'];

if(as_md5($key, $password) != $user_password || !$login) {

	$login = '';
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
	exit();

} elseif($status == 4) {

print "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">
<link href=\"/files/styles.css\" rel=\"stylesheet\">
<script language=\"javascript\">alert('Ваш логин заблокирован!'); top.location.href=\"/\";</script>
<title>Перенаправление</title>
</head>
<body bgcolor=\"#eeeeee\" topmargin=\"0\" leftmargin=\"0\">
Через секунду вы будете перемещены на сайт.<br>
Если устали ждать жмите <a href=\"/\">здесь!</a>
</body>
</html>";

} else {

session_start();
$_SESSION['login'] = $user;

$ip		= getip();
$time	= time();

mysql_query("UPDATE users SET ip = '".$ip."', go_time = ".$time." WHERE login = '".$login."' LIMIT 1");
mysql_query("INSERT INTO logip (user_id, ip, date) VALUES (".$id.", '".$ip."', ".$time.")");

print "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">
<link href=\"/files/styles.css\" rel=\"stylesheet\">
<script language=\"javascript\">top.location.href=\"/deposit/\";</script>
<title>Перенаправление</title>
</head>
<body bgcolor=\"#eeeeee\" topmargin=\"0\" leftmargin=\"0\">
Вы вошли в систему как <b>".$user."</b><br>
Через секунду вы будете перемещены на сайт.<br>
Если устали ждать жмите <a href=\"/deposit/\">здесь!</a>
</body>
</html>";

}
?>