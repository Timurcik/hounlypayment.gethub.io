
<?php
defined('ACCESS') or die();

$action = $_GET['action'];

// Добавление отзыва
if ($action == "senda") {
	if ($login) {
		if ($_POST['radio'] < 1 OR $_POST['radio'] > 2) {
			print '<p class="er">Не балуйтесь!</p>';
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
			} elseif (mysql_num_rows(mysql_query("SELECT id FROM answers WHERE date > ".(time() - 1800)." AND username = '".$login."' LIMIT 1"))) {
				print "<p class=\"er\">Отзыв нельзя добавлять чаще одного раза в 30 минут.</p>";
			} else {

				if ($_POST['radio'] == 1) {
					$radi = 1;
				} else {
					$radi = 2;
				}

				if(mysql_num_rows(mysql_query("SELECT user_id FROM deposits WHERE user_id = ".$user_id." LIMIT 1"))) {

					$get_user	= mysql_query("SELECT user_id FROM deposits WHERE user_id = ".$user_id." LIMIT 1");
					$row		= mysql_fetch_array($get_user);
					$client_id	= $row['user_id'];
					$view 		= 1;

				} else {
					$view 		= 1;
					$client_id 	= 0;
				}

				$sql = "INSERT INTO answers (`username`, `client_id`, `text`, `date`, `yes`, `view`, `ip`, `poll`) VALUES ('".$login."', ".$client_id.", '".$text."', ".time().", '".$radi."', ".$view.", '".getip()."', ".intval($_POST['poll']).")";

				if (mysql_query($sql)) {
					print "<p class=\"erok\">Сообщение добавлено!</p>";
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

// Вывод отзывов




if ($login) {
// Форма добавления комментариев
?>
<h1>Оставь отзыв</h1>
	<form action="?action=senda" method="post" name="msg_form">
	<input class="check" type="radio" name="radio" value="1" checked /><img src="/images/32.gif"  border="0" alt="Положительный отзыв" title="Положительный отзыв" />
		<input class="check" type="radio" name="radio" value="2" /> <img src="/images/23.gif" border="0" alt="Отрицательный отзыв" title="Отрицательный отзыв" />
				<p class="newsletter">
					<input type="text" name="text" class="newsletter-field" onblur="if(this.value==''){this.value='Напишите ваш отзыв...'};" onfocus="if(this.value=='Напишите ваш отзыв...'){this.value=''};" value="Напишите ваш отзыв...">
					<input type="submit" class="go-btn" value="Go" id="go">
				</p>
				</form>
				
				<?php
} else {
	print '<p class="er">Для добавления отзывов вам необходимо авторизироваться!</p>';
}
?>