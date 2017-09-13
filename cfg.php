<?php


Error_Reporting(0);

	$hostname				= "mysql.hostinger.ru";					// Хост
	$mysql_login			= "u602504605_777";						// Логин к БД
	$mysql_password			= "791v1uAVIO";						// Пароль к БД
	$database				= "u602504605_777";						// База данных
	$num					= 10;							// Кол-во выводов на страницу
	$cfgURL					= "qweqwewqeqw.esy.es";		// URL ресурса
	$chmod					= "755";						// Права папкам на запись

// Данные лицензии. Следующие переменные после установки скрипта НЕ МЕНЯТЬ!


  $mdhash				= "f58ba52a20727ae08099c24e64f41a9e";		// MD5 hash

// Соединение с БД
if (!($conn = mysql_connect($hostname, $mysql_login , $mysql_password))) {
	include "includes/errors/db.php";
	exit();
} else {
	if (!(mysql_select_db($database, $conn))) {
		include "includes/errors/db.php";
		exit();
	}
}
// Конец соединения с БД

mysql_query("SET NAMES 'UTF-8'");

set_magic_quotes_runtime(0);
@set_time_limit(0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
$safe_mode = @ini_get('safe_mode');
$version = "1.24";

if(version_compare(phpversion(), '4.1.0') == -1) {
 $_POST   = &$HTTP_POST_VARS;
 $_GET    = &$HTTP_GET_VARS;
 $_SERVER = &$HTTP_SERVER_VARS;
}

if (@get_magic_quotes_gpc()) {
	foreach ($_POST as $k=>$v) {
		$_POST[$k] = stripslashes($v);
	}
	foreach ($_SERVER as $k=>$v) {
		$_SERVER[$k] = stripslashes($v);
	}
}

define('ACCESS', true);

include "includes/key.php";
include "includes/percent.php";
?>