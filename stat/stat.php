<?php

defined('ACCESS') or die();

if($login) {
?>

<p align="center">
	Показать:  <a href="?sort=1"><font color="#f2650a">Начисление %</font></a> | <a href="?sort=2"><font color="#f2650a"><font color="#f2650a">Открытие депозитов</font></a> | <a href="?sort=3"><font color="#f2650a">Пополнение счета</font></a> | <a href="?sort=4"><font color="#f2650a">Вывод</font></a> | <a href="?sort=5"><font color="#f2650a">Авторизации</font></a>
</p>
<BR>
<?php
	if($_GET['sort'] == 2) {
		include "depo.php";
	} elseif($_GET['sort'] == 3) {
		include "enter.php";
	} elseif($_GET['sort'] == 4) {
		include "out.php";
	} elseif($_GET['sort'] == 5) {
		include "auth.php";
	} else {
		include "percent.php";
	}

} else {
	print "<p class=\"er\">Для доступа к данной странице, вам необходимо авторизироваться!</p>";
}
?>