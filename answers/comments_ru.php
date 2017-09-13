<?php
defined('ACCESS') or die();

// ---------------------------------------------------------------------
if($_GET['pid']) {
	$pid = intval($_GET['pid']);
} else {
	$pid = intval($_GET['id']);
}

if($_GET['a'] == "pollno") {
	// Голосование (ПРОТИВ)

	if(!$login) {
		print "<p class=\"er\">Для голосования вам необходимо зарегистрироваться!</p>";
	} elseif(mysql_num_rows(mysql_query("SELECT * FROM answers_poll WHERE answer_id = ".$pid." AND (user_id = ".$user_id." || ip = '".getip()."') LIMIT 1"))) {
		print "<p class=\"er\">Вы уже голосовали за данный отзыв</p>";
	} else {

		mysql_query("INSERT INTO answers_poll (`user_id`, `date`, `ip`, `answer_id`, `poll`) VALUES (".$user_id.", ".time().", '".getip()."', ".$pid.", 1)");
		mysql_query("UPDATE answers SET poll_no = poll_no + 1, poll_count = poll_count + 1 WHERE id = ".$pid." LIMIT 1");
		print "<p class=\"erok\">Ваше мнение учтено!</p>";

	}

} elseif($_GET['a'] == "pollyes") {
	// Голосование (ЗА)

	if(!$login) {
		print "<p class=\"er\">Для голосования вам необходимо зарегистрироваться!</p>";
	} elseif(mysql_num_rows(mysql_query("SELECT * FROM answers_poll WHERE answer_id = ".$pid." AND (user_id = ".$user_id." || ip = '".getip()."') LIMIT 1"))) {
		print "<p class=\"er\">Вы уже голосовали за данный отзыв</p>";
	} else {

		mysql_query("INSERT INTO answers_poll (`user_id`, `date`, `ip`, `answer_id`, `poll`) VALUES (".$user_id.", ".time().", '".getip()."', ".$pid.", 2)");
		mysql_query("UPDATE answers SET poll_yes = poll_yes + 1, poll_count = poll_count + 1 WHERE id = ".$pid." LIMIT 1");
		print "<p class=\"erok\">Ваше мнение учтено!</p>";

	}

} elseif($status == 1 && $_GET['v']) {
	mysql_query("UPDATE answers SET view = 0 WHERE id = ".intval($_GET['v'])." LIMIT 1");
	print "<p class=\"erok\">Сообщение скрыто</p>";
} 

// Добавление отзыва
if ($_GET['action'] == "send") {
	if ($login) {
		if (!$_POST['text'] || $_POST['text'] == " ") {
				print "<p class=\"er\">Введите текст сообщения</p>";
			} else {
			$text = nl2br(htmlspecialchars(substr($_POST['text'], 0, 10000), ENT_QUOTES, ''));

			$text = str_replace(":001:","<img src=\"/images/smiles/01.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":002:","<img src=\"/images/smiles/02.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":003:","<img src=\"/images/smiles/03.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":004:","<img src=\"/images/smiles/04.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":005:","<img src=\"/images/smiles/05.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":006:","<img src=\"/images/smiles/06.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":007:","<img src=\"/images/smiles/07.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":008:","<img src=\"/images/smiles/08.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":009:","<img src=\"/images/smiles/09.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":010:","<img src=\"/images/smiles/10.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":011:","<img src=\"/images/smiles/11.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":012:","<img src=\"/images/smiles/12.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":013:","<img src=\"/images/smiles/13.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":014:","<img src=\"/images/smiles/14.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":015:","<img src=\"/images/smiles/15.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":016:","<img src=\"/images/smiles/16.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":017:","<img src=\"/images/smiles/17.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":018:","<img src=\"/images/smiles/18.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":019:","<img src=\"/images/smiles/19.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":020:","<img src=\"/images/smiles/20.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":021:","<img src=\"/images/smiles/21.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":022:","<img src=\"/images/smiles/22.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":023:","<img src=\"/images/smiles/23.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":024:","<img src=\"/images/smiles/24.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":025:","<img src=\"/images/smiles/25.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":026:","<img src=\"/images/smiles/26.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":027:","<img src=\"/images/smiles/27.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);
			$text = str_replace(":028:","<img src=\"/images/smiles/28.gif\" height=\"20\" width=\"20\" border=\"0\" alt=\":)\" />",$text);

			$temp = strtok($text, " ");


			if (!$text || $text == " ") {
				print "<p class=\"er\">Введите текст сообщения</p>";
			} elseif (strlen($temp) > 100) {
				print "<p class=\"er\">Текст Вашего сообщение содержит слишком много символов без пробелов!</p>";
			} elseif (mysql_num_rows(mysql_query("SELECT id FROM answers WHERE date > ".(time() - 300)." AND username = '".$login."' LIMIT 1"))) {
				print "<p class=\"er\">Комментарий нельзя добавлять чаще одного раза в 5 минут.</p>";
			} else {

				if(mysql_num_rows(mysql_query("SELECT user_id FROM clients WHERE user_id = ".$user_id." LIMIT 1"))) {

					$get_user	= mysql_query("SELECT id FROM clients WHERE user_id = ".$user_id." LIMIT 1");
					$row		= mysql_fetch_array($get_user);
					$client_id	= $row['id'];

				} else {
					$client_id 	= 0;
				}

				$sql = "INSERT INTO answers (`part`, `username`, `client_id`, `text`, `date`, `view`, `ip`, `poll`) VALUES (".intval($_GET['id']).", '".$login."', ".$client_id.", '".$text."', ".time().", 1, '".getip()."', 5)";

				if (mysql_query($sql)) {
					print "<p class=\"erok\">Комментарий добавлен!</p>";
					mysql_query("UPDATE answers SET comments = comments + 1 WHERE id = ".intval($_GET['id'])." LIMIT 1");
				} else {
					print "<p class=\"er\">Произошла ошибка при записи данных в БД</p>";
				}

				$text = "";
			}
		}
	} else {
		print '<p class="er">Вы должны авторизироваться для доступа на эту страницу!</p>';
	}
}

// ---------------------------------------------------------------------

	$query	= "SELECT * FROM answers WHERE view = 1 AND id = ".intval($_GET['id'])." LIMIT 1";
	$result	= mysql_query($query);
	$row	= mysql_fetch_array($result);

	if($row) {

  		if ($status == 1) {
			$admin_but  = "<a href=\"/adminpanel/adminstation.php?a=admin_answers&id=".$row['id']."\"><img src=\"/adminpanel/images/comment_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Комментировать\" /></a> ";
			$admin_but .= "<a href=\"/adminpanel/adminstation.php?a=edit_answers&id=".$row['id']."\"><img src=\"/adminpanel/images/edit_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Редактировать сообщение\" /></a> ";
			$admin_but .= "<img style=\"cursor: hand;\" onclick=\"if(confirm('Вы уверены?')) top.location.href='/adminpanel/del/answers.php?id=".$row['id']."'\"; src=\"/adminpanel/images/delite_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Удалить сообщение\" />";
			$admin_but .= " IP: ".$row['ip'];
		} else {
			$admin_but	= "";
		}

		if ($row['yes'] == 1) {
			$smile = '<img src="/images/yes.gif" width="15" height="15" border="0" alt="Положительный отзыв" title="Положительный отзыв" />';
			$style = "border: 1px solid #99ff99; background-color: #e4ffe4; padding: 4 4 4 4px; margin-bottom: 10px;";
		} else {
			$smile = '<img src="/images/no.gif" width="15" height="15" border="0" alt="Отрицательный отзыв" title="Отрицательный отзыв" />';
			$style = "border: 1px solid #ff9999; background-color: #ffe4e4; padding: 4 4 4 4px; margin-bottom: 10px;";
		}



print '
	<table width="100%" border="0" style="'.$style.'">
		<tr>
			<td><p>'.$smile.' '.date("d.m.Y H:i", $row['date']).' - <b>'.$row['username'].'</b>';

			if($row['client_id'] == 0) {
				print ' [Прохожий]';
			} else {
				print ' [Инвестор #'.$row['client_id'].']';
			}

print '	'.$admin_but.'</p>
			<div class="hline"></div>
			<p align="justify">'.$row['text'].'</p>';

		if($row['answer']) { print "<div style='border: 1px solid #ff9900; background-color: #feffee; padding: 3px;'><i>Комментарий от администрации:</i><br /><font color=\"#660000\">".$row['answer']."</font></div>"; }

print '	<div style="margin-top: 3px;" class="hline"></div>
		<div style="float: left;">
			Комментарии ['.$row['comments'].']
		</div>
		<div align="right">
			<a style="color: red;" href="?a=pollno&id='.$row['id'].'">Не согласен ['.$row['poll_no'].']</a> | <a style="color: green;" href="?a=pollyes&id='.$row['id'].'">Согласен ['.$row['poll_yes'].']</a>
		</div>
			</td>
		</tr>
	</table>
';

print '<h2>Комментарии к отзыву:</h2>';

// Вывод отзывов
function topics_list($page, $num, $status)
{
	$query	= "SELECT * FROM answers WHERE view = 1 AND part = ".intval($_GET['id'])." ORDER BY id ASC";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);

	if(!$themes) {
		print '<p class="er">К данному отзыву нет комментариев.</p>';
	}

	$total	= intval(($themes - 1) / $num) + 1;
	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query." LIMIT ".$start.", ".$num);
	while ($row = mysql_fetch_array($result))
	{
  		if ($status == 1) {
			$admin_but  = "<a href=\"/adminpanel/adminstation.php?a=admin_answers&id=".$row['id']."\"><img src=\"/adminpanel/images/comment_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Комментировать\" /></a> ";
			$admin_but .= "<a href=\"/adminpanel/adminstation.php?a=edit_answers&id=".$row['id']."\"><img src=\"/adminpanel/images/edit_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Редактировать сообщение\" /></a> ";
			$admin_but .= "<img style=\"cursor: hand;\" onclick=\"if(confirm('Вы уверены?')) top.location.href='/adminpanel/del/answers.php?id=".$row['id']."'\"; src=\"/adminpanel/images/delite_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Удалить сообщение\" />";
			$admin_but .= " IP: ".$row['ip'];
		} else {
			$admin_but	= "";
		}

print '
	<table width="100%" border="0" style="border: 1px solid #66ccff; background-color: #e9ffff; padding: 4 4 4 4px; margin-bottom: 10px;">
		<tr>
			<td><p>'.date("d.m.Y H:i", $row['date']).' - <b>'.$row['username'].'</b>';

			if($row['client_id'] == 0) {
				print ' [Прохожий]';
			} else {
				print ' [Инвестор #'.$row['client_id'].']';
			}

print ' '.$admin_but.'</p>
			<div class="hline"></div>
			<p align="justify">'.$row['text'].'</p>';

		if($row['answer']) { print "<div style='border: 1px solid #ff9900; background-color: #feffee; padding: 3px;'><i>Комментарий от администрации:</i><br /><font color=\"#660000\">".$row['answer']."</font></div>"; }

print '	<div style="margin-top: 3px;" class="hline"></div>
		<div align="right">
			<a style="color: red;" href="?a=pollno&pid='.$row['id'].'">Не согласен ['.$row['poll_no'].']</a> | <a style="color: green;" href="?a=pollyes&pid='.$row['id'].'">Согласен ['.$row['poll_yes'].']</a>
		</div>
			</td>
		</tr>
	</table><div class="hline" style="margin-bottom: 3px;"></div>
';

	}


	if($page != 1) { $pervpage = "<a href=\"?page=". ($page - 1) ."\">««</a> "; }
	if($page != $total) { $nextpage = " <a href=\"?page=". ($page + 1) ."\">»»</a>"; }
	if($page - 2 > 0) { $page2left = " <a href=\"?page=". ($page - 2) ."\">". ($page - 2) ."</a>) "; }
	if($page - 1 > 0) { $page1left = " <a href=\"?page=". ($page - 1) ."\">". ($page - 1) ."</a>) "; }
	if($page + 2 <= $total) { $page2right = " <a href=\"?page=". ($page + 2) ."\">". ($page + 2) ."</a>)"; }
	if($page + 1 <= $total) { $page1right = " <a href=\"?page=". ($page + 1) ."\">". ($page + 1) ."</a>)"; }

	print "<div align=\"right\"><b>Страницы: </b>".$pervpage.$page2left.$page1left.$page.")".$page1right.$page2right.$nextpage."</div>";
}

$page = intval($_GET['page']);
topics_list($page, $num, $status);



if ($login) {
// Форма добавления комментариев
?>
<div class="hline"></div>
<center>
<table width="380" border="0" align="center">
	<form action="?action=send" method="post" name="msg_form">
	<tr>
		<td><font color="red"><b>!</b></font> Текст комментария:<br /><textarea style="width: 378px;" name="text" rows="7" cols="48"><?php print htmlspecialchars(substr($_POST['text'], 0, 10000), ENT_QUOTES, ''); ?></textarea></td>
	</tr>
	<tr>
		<td align="right"><input class="subm" type="submit" value="Отправить!" /></td>
	</tr>
	</form>
</table>
</center>
<div style="margin-top: 15px;" align="center">
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':001:','msg_form','text')" src="/images/smiles/01.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':002:','msg_form','text')" src="/images/smiles/02.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':003:','msg_form','text')" src="/images/smiles/03.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':004:','msg_form','text')" src="/images/smiles/04.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':005:','msg_form','text')" src="/images/smiles/05.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':006:','msg_form','text')" src="/images/smiles/06.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':007:','msg_form','text')" src="/images/smiles/07.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':008:','msg_form','text')" src="/images/smiles/08.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':009:','msg_form','text')" src="/images/smiles/09.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':010:','msg_form','text')" src="/images/smiles/10.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':011:','msg_form','text')" src="/images/smiles/11.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':012:','msg_form','text')" src="/images/smiles/12.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':013:','msg_form','text')" src="/images/smiles/13.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':014:','msg_form','text')" src="/images/smiles/14.gif" height="20" width="20" border="0" />
<br />
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':015:','msg_form','text')" src="/images/smiles/15.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':016:','msg_form','text')" src="/images/smiles/16.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':017:','msg_form','text')" src="/images/smiles/17.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':018:','msg_form','text')" src="/images/smiles/18.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':019:','msg_form','text')" src="/images/smiles/19.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':020:','msg_form','text')" src="/images/smiles/20.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':021:','msg_form','text')" src="/images/smiles/21.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':022:','msg_form','text')" src="/images/smiles/22.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':023:','msg_form','text')" src="/images/smiles/23.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':024:','msg_form','text')" src="/images/smiles/24.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':025:','msg_form','text')" src="/images/smiles/25.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':026:','msg_form','text')" src="/images/smiles/26.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':027:','msg_form','text')" src="/images/smiles/27.gif" height="20" width="20" border="0" />&nbsp;
<img style="cursor: hand; cursor: pointer;" onclick="PrintSmile(':028:','msg_form','text')" src="/images/smiles/28.gif" height="20" width="20" border="0" />&nbsp;
</div>
<?php
		} else {
			print '<p class="er">Для добавления комментария вам необходимо авторизироваться!</p>';
		}

	} else {
		print "<p class=\"er\">Отзыв не найден!</p>";
	}
?>