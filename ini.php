<?php
defined('ACCESS') or die();
session_start();
$login	= $_SESSION['login'];
$sid	=	htmlspecialchars(substr(session_id(),0,32), ENT_QUOTES);

function getip() {
	if(getenv("HTTP_CLIENT_IP")) {
		$ip = getenv("HTTP_CLIENT_IP");
	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	} else {
		$ip = getenv("REMOTE_ADDR");
	}
$ip = htmlspecialchars(substr($ip,0,15), ENT_QUOTES);
return $ip;
}

$ref = intval($_GET['ref']);
if($ref) {
	setcookie("referal", $ref, time() + 2592000);
}

$referal = intval($_COOKIE['referal']);

function as_md5($key, $pass) {
	$pass = md5($key.md5("Z&".$key."x_V".htmlspecialchars($pass, ENT_QUOTES)));
return $pass;
}

if (mysql_num_rows(mysql_query("SELECT * FROM `blacklist_ip` WHERE ip = '".getip()."' LIMIT 1"))) {
	include "includes/errors/banip.php";
	exit();
} 

// Если сессии нет, проверяем cookies
if(!$login) {
	if($_COOKIE['adminstation1']) {
		$get_user = mysql_query("SELECT login, pass, mail FROM users WHERE id = ".intval($_COOKIE['adminstation1'])." LIMIT 1");
		$row = mysql_fetch_array($get_user);
			$login	= $row['login'];
			$pass	= $row['pass'];
			$mail	= $row['mail'];
			$user_pass = as_md5($key, $pass.$key.$login);

			if($_COOKIE['adminstation2'] == $user_pass) {
				session_register('login');
			} else {
				$login = "";
			}
	}
}

// Вытаскиваем данные с юзера
if($login) {

	$get_user_info = mysql_query("SELECT * FROM users WHERE login = '".$login."' LIMIT 1");
	$row = mysql_fetch_array($get_user_info);
	 $user_id			= $row['id'];
	 $login				= $row['login'];
	 $user_pass			= $row['pass'];
	 $user_mail			= $row['mail'];
	 $status			= $row['status'];
	 $lrbalance			= $row['lr_balance'];
	 $pmbalance			= $row['pm_balance'];
	 $balance			= $row['lr_balance'];
	 $balance			= $balance + $row['pm_balance'];
	 $ulr				= $row['lr'];
	 $upm				= $row['pm'];
	 $uref				= $row['ref'];

	mysql_query("UPDATE users SET go_time = ".time().", ip = '".getip()."' WHERE id = ".$user_id." LIMIT 1");

	if($status == 3) {
		include "includes/errors/banlogin.php";
		exit();
	}

} else {

	 $user_id		= 0;
	 $login			= "";
	 $user_pass		= "";
	 $user_mail		= "";

}

if(!$idpg) {
	$idpg = 1;
}

	$get_page_info	= mysql_query("SELECT title_en, keywords, description, body_en, part FROM pages WHERE id = ".intval($idpg)." LIMIT 1");
	$row			= mysql_fetch_array($get_page_info);
	 $title			= $row['title_en'];
	 $keywords		= $row['keywords'];
	 $description	= $row['description'];
	 $body			= stripslashes($row['body_en']);
	 $part_page		= $row['part'];

if($page == "news" && $_GET['id']) {
	$get_news_info	= mysql_query("SELECT subject_en, keywords, description, msg_en, date FROM news WHERE id = ".intval($_GET['id'])." LIMIT 1");
	$row			= mysql_fetch_array($get_news_info);
	 $title			= $row['subject_en'];
	 $keywords		= $row['keywords'];
	 $description	= $row['description'];
	 $news_text		= $row['msg_en'];
	 $news_date		= $row['date'];
}
?>