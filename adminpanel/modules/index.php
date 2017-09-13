<?php
defined('ACCESS') or die();

$sum = 0.0000;
$query	= "SELECT * FROM users";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$sum = $sum + $row['lr_balance'];
}
$query	= "SELECT * FROM users";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$sum = $sum + $row['pm_balance'];
}

$dep	= 0.00;
$query	= "SELECT * FROM deposits WHERE status = 0";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$dep = $dep + $row['sum'];
}

$out	= 0.00;
$query	= "SELECT * FROM output WHERE status = 2";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$out = $out + $row['sum'];
}

$outw	= 0.00;
$query	= "SELECT * FROM output WHERE status = 0";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$outw = $outw + $row['sum'];
}

$deyout	= 0.00;
$query	= "SELECT * FROM deposits WHERE status = 0";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {

	$result2	= mysql_query("SELECT * FROM plans WHERE id = ".$row['plan']." LIMIT 1");
	$row2		= mysql_fetch_array($result2);

	$deyout = $deyout + $row['sum'] / 100 * $row2['percent'];

}

// Создаем уровень
if($_GET['act'] == "addreflevel") {
	$level		= intval($_POST['level']);
	$percent	= sprintf ("%01.2f", str_replace(',', '.', $_POST['percent']));

	if($level < 1) {
		print '<p class="er">Введите уровень реферальной системы</p>';
	} elseif($percent < 0.01 || $percent > 100) {
		print '<p class="er">Процент должен быть от 0.01 до 100</p>';
	} else {
		mysql_query('INSERT INTO reflevels (id, sum) VALUES ('.$level.', '.$percent.')');
		print '<p class="erok">Новый реферальный уровень - добавлен!</p>';
	}
}

// Удаляем уровень
if($_GET['act'] == "dellevel") {
	mysql_query("DELETE FROM reflevels WHERE id = ".intval($_GET['id'])." LIMIT 1");
	print '<p class="erok">Реферальный уровень удален!</p>';
}

// Редактируем уровень
if($_GET['act'] == "editlevel") {
	$level		= intval($_POST['level']);
	$percent	= sprintf ("%01.2f", str_replace(',', '.', $_POST['percent']));

	if($level < 1) {
		print '<p class="er">Введите уровень реферальной системы</p>';
	} elseif($percent < 0.01 || $percent > 100) {
		print '<p class="er">Процент должен быть от 0.01 до 100</p>';
	} else {
		mysql_query("UPDATE reflevels SET id = ".$level.", sum = ".$percent." WHERE id = ".intval($_GET['id'])." LIMIT 1");
		print '<p class="erok">Изменения сохранены!</p>';
	}
}

?>

       <div class="widget">
          <div class="table-container">
            <table cellpading="0" cellspacing="0" border="0" class="default-table stripped blue" id="dynamic">
              <thead>
                <tr align="left">
                  <th>Денег на счетах</th>
                  <th>Сумма депозитов</th>
                  <th>Сумма выплат</th>
                  <th>Ожидает выплат</th>
                  <th>Ежедневно выплачивать</th>
				  <th>Жить проекту</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><b><?php print $sum; ?></b>$</td>
                  <td><b><?php print $dep; ?></b>$</td>
                  <td><b><?php print $out; ?></b>$</td>
                  <td><b><?php print $outw; ?></b>$</td>
                  <td>&asymp;<b><?php print $deyout; ?></b>$</td>
				  <td>&asymp;<b><?php print intval(($dep - $out - $outw) / $deyout); ?></b> дней</td>
                </tr>


              </tbody>
            </table>
          </div>
        </div>





 <div class="row-fluid">
          <div class="widget">
            <form class="form-horizontal" action="?act=addreflevel" method="post">
              <div class="widget-header">
                <h5>Создание нового реферального уровня</h5>
              </div>
              <div class="widget-content no-padding">
                <div class="form-row">
                  <label class="field-name" for="standard">Уровень:</label>
                  <div class="field">
                    <input type="text" class="span12" name="level" id="standard">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name" for="password">Процент:</label>
                  <div class="field">
                    <input type="text" class="span12" name="percent" id="password">
                  </div>
                </div>
				 <div class="form-row" align="right">
                  <input type="submit" name="submit" class="button small-button button-green" value="Создать">
                 
                </div>
          
			   <br>
              </div>
			   
            </form>
          </div>
        </div>








