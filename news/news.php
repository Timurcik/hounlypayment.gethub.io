							<center><font color="#f2650a"><h2>Новости проекта</h2></font></center>
							<br>
<?php
defined('ACCESS') or die();
if(!intval($_GET[id])) {
function show_topics ($id, $subj, $msg, $date, $status)
{
	$text = substr($msg, 0, 1000);

	$text = substr($text, 0, 20000);

	print "<p>".$date." | <a href=\"?id=".$id."\"><font color=#f2650a><b>".$subj."</b></font></a>";

	if ($status == 1 || $status == 2)
	{
		print " <a href=\"/adminpanel/adminstation.php?a=edit_news&id=".$id."\"><img src=\"/adminpanel/images/edit_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Редактировать новость\" /></a> ";
		print "<img style=\"cursor: hand;\" onclick=\"if(confirm('Вы уверены?')) top.location.href='/adminpanel/del/news.php?id=".$id."'\";  width=\"12\" height=\"12\" border=\"0\" src=\"/adminpanel/images/del.gif\" alt=\"Удалить новость\" />";
	}
	print "</p><br><p align=\"justify\">".$text."</p><hr size=\"1\" color=\"#cccccc\" />";
}

function topics_list($page, $num, $status)
{
	$query	= "SELECT * FROM news WHERE subject_en != '' ORDER BY id DESC";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);
	$total	= intval(($themes - 1) / $num) + 1;
	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query." LIMIT ".$start.", ".$num);

	while ($row = mysql_fetch_array($result))
	{
		show_topics($row['id'], $row['subject'], $row['msg'], $row['date'], $status);
	}

	if ($page) {
		if($page != 1) { $pervpage = "<a href=\"?page=". ($page - 1) ."\">««</a>"; }
		if($page != $total) { $nextpage = " <a href=\"?page=". ($page + 1) ."\">»»</a>"; }
		if($page - 2 > 0) { $page2left = " <a href=\"?page=". ($page - 2) ."\">". ($page - 2) ."</a>) "; }
		if($page - 1 > 0) { $page1left = " <a href=\"?page=". ($page - 1) ."\">". ($page - 1) ."</a>) "; }
		if($page + 2 <= $total) { $page2right = " | <a href=\"?page=". ($page + 2) ."\">". ($page + 2) ."</a>) "; }
		if($page + 1 <= $total) { $page1right = " | <a href=\"?page=". ($page + 1) ."\">". ($page + 1) ."</a>) "; }
	}
	print "<div align=\"center\"><b>Страницы:  </b>".$pervpage.$page2left.$page1left."[<b>".$page."</b>]".$page1right.$page2right.$nextpage."</div>";
}

$page = intval($_GET['page']);
topics_list($page, $num, $status);
} else {

	print "<p align=\"justify\">".stripslashes($news_text)."</p>";
	print '<div class="hline"></div>
	<br>
	<table width="100%"><tr><td align="right">Дата: <b>'.$news_date.'</b></td></tr></table><br><a href=/news"><font color=#f2650a><b>Назад</b></font></a>';

}
?>