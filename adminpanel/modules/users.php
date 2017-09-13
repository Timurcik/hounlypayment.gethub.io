<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<?php

defined('ACCESS') or die();
// Задаём статус пользователю
if($_GET['p'] || $_GET['id']) {
	if(isset($_GET['status'])) {
		if($_GET['status'] < 0 OR $_GET['status'] > 5) {
			print '<p class="er">Указанный статус не корректен!</p>';
		} elseif($status != 1) {
			print '<p class="er">У вас нет прав на эту функцию!</p>';
		} else {
			$sql = 'UPDATE users SET status = '.intval($_GET[status]).' WHERE id = '.intval($_GET[id]).' LIMIT 1';
			if (mysql_query($sql)) {
				print '<p class="erok">Статус был успешно установлен!</p>';
			} else {
				print '<p class="er">Ошибка записи в БД!</p>';
			}
		}
	} else {
		print '<p class="er">Не указан статус!</p>';
	}
}
// Закончили со статусом

// Создаём пользователя
if($_GET[action] == "add") {

	$name = addslashes($_POST[name]);
	$pass1 = $_POST[pass];
	$pass2 = $_POST[re_pass];
	$email = $_POST[email];

	if(!$name OR !$pass1 OR !$pass2 OR !$email) {
		print '<p class="er">Корректно заполните все поля!</p>';
	} else {
		if($pass1 != $pass2) {
			print '<p class="er">Пароль и подтерждение не совпадают!</p>';
		} elseif(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is",$email)) {
				print "<p class=\"er\">Введите правильно e-mail!</p>";
		} else {
			$sql = 'SELECT login FROM users WHERE login = "'.$name.'"';
			if(mysql_num_rows(mysql_query($sql))) {
				print '<p class="er">Пользователь с таким именем уже существует!</p>';
			} else {
				$sql = 'INSERT INTO users (login, go_time, ip, pass, mail, reg_time) VALUES ("'.$name.'", '.time().', "'.getip().'", "'.as_md5($key, $pass1).'", "'.$email.'", '.time().')';
				if (mysql_query($sql)) {
					print '<p class="erok">Создание пользователя прошло успешно!</p>';
				} else {
					print '<p class="er">Ошибка записи в БД!</p>';
				}
			}
		}
	}

}
// Закончили создавать
$money = 0.00;
$query	= "SELECT `lr_balance` FROM `users`";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$money = $money + $row['lr_balance'];
}
$query	= "SELECT `pm_balance` FROM `users`";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$money = $money + $row['pm_balance'];
}
?>
<center><b>Всего денег на балансе у пользователей: $<?php print sprintf("%01.2f", $money); ?></b></center>
<hr />
<table border="0" align="center" width="100%" cellpadding="1" cellspacing="1" bgcolor="#547898">
<colspan><div align="right" style="padding: 2px;">Сортировать по: <a href="?a=users">ID</a> | <a href="?a=users&sort=auth">Авторизации</a> | <a href="?a=users&sort=lr_balance">Балансу LR</a> | <a href="?a=users&sort=pm_balance">Балансу PM</a> | <a href="?a=users&sort=status">Статусу</a> | <a href="?a=users&sort=login">Логину</a> | <a href="?a=users&sort=ip">IP</a></div></colspan>
	  <div class="widget">
          <div class="table-container">
            <table cellpading="0" cellspacing="0" border="0" class="default-table stripped blue" id="dynamic">
              <thead>
                <tr align="left">
                  <th width="50">ID</th>
                  <th>Логин</th>
                  <th>Баланс LR</th>
                  <th>Баланс PM</th>
                  <th>Регистрация</th>
				  <th>Входил</th>
				  <th>Последний&nbsp;IP</th>
				  <th>Статус</th>
				  <th>EDIT</th>
                </tr>
              </thead>



<?php

function users_list($page, $num, $query) {

	$result = mysql_query($query);
	$themes = mysql_num_rows($result);

	if (!$themes) {
		print '<tr><td colspan="9" align="center"><font color="#ffffff"><b>Пользователей пока нет.</b></font></td></tr>';
	} else {

		$total = intval(($themes - 1) / $num) + 1;
		if (empty($page) or $page < 0) $page = 1;
		if ($page > $total) $page = $total;
		$start = $page * $num - $num;
		$result = mysql_query($query." LIMIT ".$start.", ".$num);
		while ($row = mysql_fetch_array($result)) {

	print "<tbody>
                <tr>
                  <td>".$row['id']."</td>
                  <td><a href=\"mailto:".$row['mail']."\"><b>".$row['login']."</b></td>
                  <td>".$row['lr_balance']."</td>
		<td>".$row['pm_balance']."</td>
		<td>".date("d.m.y H:i", $row['reg_time'])."</td>
		<td>".date("d.m.y H:i", $row['go_time'])."</td>
		<td>".$row['ip']."</td>
                
		
	<td>";

switch ($row[status])
			{
			case 0:
				print "<img src=\"images/user.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"User\">";
				break;
			case 1:
				print "<img src=\"images/admin.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Админ\">";
				break;
			case 2:
				print "<img src=\"images/moder.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Модератор\">";
				break;
			case 3:
				print "<img src=\"images/ban.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Заблокированный\">";
				break;
			}

			print "</td>
			<td><nobr><a onClick=\"return confirm('Удалить этого пользователя?')\" href='del/user.php?page=".$page."&id=".$row[id]."'><img src=\"images/del.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Удаление пользователя\"></a> ";

			switch ($row[status])
			{
			case 0:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=2"><img src="images/moder.gif" width="12" height="12" border="0" alt="Сделать модером"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=1"><img src="images/admin.gif" width="12" height="12" border="0" alt="Сделать админом"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=3"><img src="images/ban.gif" width="12" height="12" border="0" alt="Закрыть доступ"></a>';
				break;
			case 1:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=0"><img src="images/user.gif" width="12" height="12" border="0" alt="Сделать юзером"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=2"><img src="images/moder.gif" width="12" height="12" border="0" alt="Сделать модером"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=3"><img src="images/ban.gif" width="12" height="12" border="0" alt="Закрыть доступ"></a>';
				break;
			case 2:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=0"><img src="images/user.gif" width="12" height="12" border="0" alt="Сделать юзером"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=1"><img src="images/admin.gif" width="12" height="12" border="0" alt="Сделать админом"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=3"><img src="images/ban.gif" width="12" height="12" border="0" alt="Закрыть доступ"></a>';
				break;
			case 3:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=0"><img src="images/user.gif" width="12" height="12" border="0" alt="Разблокировать"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=2"><img src="images/moder.gif" width="12" height="12" border="0" alt="Сделать модером"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=1"><img src="images/admin.gif" width="12" height="12" border="0" alt="Сделать админом"></a>';
				break;
			}

			print ' <a href="?a=edit_user&id='.$row[id].'"><img src="images/edit_small.gif" width="12" height="12" border="0" alt="Редактировать"></a> <a href="?a=referals&id='.$row[id].'"><img src="images/partners.gif" width="12" height="12" border="0" alt="Привлечённые рефералы"></a> <a href="?a=logip&id='.$row[id].'"><img src="images/ip.gif" width="12" height="12" border="0" alt="Лог IP"></a></nobr></td></tr>';
		}

		if ($page != 1) $pervpage = "<a href=?a=users&sort=".$_GET['sort']."&page=". ($page - 1) .">««</a>";
		if ($page != $total) $nextpage = " <a href=?a=users&sort=".$_GET['sort']."&page=". ($page + 1) .">»»</a>";
		if($page - 2 > 0) $page2left = " <a href=?a=users&sort=".$_GET['sort']."&page=". ($page - 2) .">". ($page - 2) ."</a> | ";
		if($page - 1 > 0) $page1left = " <a href=?a=users&sort=".$_GET['sort']."&page=". ($page - 1) .">". ($page - 1) ."</a> | ";
		if($page + 2 <= $total) $page2right = " | <a href=?a=users&sort=".$_GET['sort']."&page=". ($page + 2) .">". ($page + 2) ."</a>";
		if($page + 1 <= $total) $page1right = " | <a href=?a=users&sort=".$_GET['sort']."&page=". ($page + 1) .">". ($page + 1) ."</a>";
		print "<tr height=\"19\"><td colspan=\"9\" bgcolor=\"#ffffff\"><b>Страницы: </b>".$pervpage.$page2left.$page1left."[".$page."]".$page1right.$page2right.$nextpage."</td></tr>";
	}
	print "</table>";
}

if($_GET['sort'] == "login") {
	$sort = "ORDER BY login ASC";
} elseif($_GET['sort'] == "status") {
	$sort = "order by status DESC";
} elseif($_GET[sort] == "lr_balance") {
	$sort = "order by lr_balance DESC";
} elseif($_GET[sort] == "pm_balance") {
	$sort = "order by pm_balance DESC";
} elseif($_GET[sort] == "ip") {
	$sort = "order by ip DESC";
} elseif($_GET[sort] == "auth") {
	$sort = "order by go_time DESC";
} else {
	$sort = "GROUP BY id order by id ASC";
}

if($_GET['action'] == "searchuser") {
	$su = " AND (login = '".$_POST['name']."' OR id = ".intval($_POST['name'])." OR mail = '".$_POST['name']."' OR lr = '".$_POST['name']."' OR pm = '".$_POST['name']."')";
}

$sql = "SELECT * FROM users WHERE login != 'Rem-x'".$su." ".$sort;
users_list(intval($_GET[page]), 50, $sql);
?>


		</table></div>
		 <div class="row-fluid">
          <div class="widget">
            <form class="form-horizontal" action="?a=users&action=add" method="post">
              <div class="widget-header">
                <h5>Добавить пользователя</h5>
              </div>
              <div class="widget-content no-padding">
                <div class="form-row">
                  <label class="field-name" for="standard">Логин:</label>
                  <div class="field">
                    <input type="text" class="span12" name="name" id="standard">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name" for="password">Пароль:</label>
                  <div class="field">
                    <input type="password" class="span12" name="pass" id="password">
                  </div>
                </div>
				<div class="form-row">
                  <label class="field-name" for="password">Еще раз пароль:</label>
                  <div class="field">
                    <input type="password" class="span12" name="re_pass" id="password">
                  </div>
                </div>
				
				
				
				
				<div class="form-row">
                  <label class="field-name" for="standard">E-Mail:</label>
                  <div class="field">
                    <input type="text" class="span12" name="email" id="standard">
                  </div>
                </div>
				 <div class="form-row" align="right">
                  <input type="submit" name="submit" class="button small-button button-green" value="Создать">
                 
                </div>


                    </div>
                  </div>
           
              </div>
            </form>

		
		
		
		
		
		
		


<form action="?a=users&action=searchuser" method="post">

<LEGEND><b>Найти пользователя по Логину / ID / e-mail / кошельку</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>Поиск:</strong></td>
		<td><input class="inp" style="background-color: #ffffff; width: 625px;" type="text" name="name" size="93" /></td>
		<td align="center"><input type="image" src="images/search.gif" width="28" height="29" border="0" title="Поиск!" /></td>
	</tr>
</table>

</form>
 </div>
              </div>