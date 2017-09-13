<?php
defined('ACCESS') or die();
if($_GET['action'] == "edit") {

	$adminmail				= htmlspecialchars($_POST['adminmail'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$adminmail.'" WHERE cfgname = "adminmail" LIMIT 1');

	$cfgLiberty				= htmlspecialchars($_POST['cfgLiberty'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgLiberty.'" WHERE cfgname = "cfgLiberty" LIMIT 1');

	$cfgPerfect				= htmlspecialchars($_POST['cfgPerfect'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPerfect.'" WHERE cfgname = "cfgPerfect" LIMIT 1');

	$cfgPAYEE_NAME			= htmlspecialchars($_POST['cfgPAYEE_NAME'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPAYEE_NAME.'" WHERE cfgname = "cfgPAYEE_NAME" LIMIT 1');

	$cfgLRsecword			= htmlspecialchars($_POST['cfgLRsecword'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgLRsecword.'" WHERE cfgname = "cfgLRsecword" LIMIT 1');

	$ALTERNATE_PHRASE_HASH	= htmlspecialchars($_POST['ALTERNATE_PHRASE_HASH'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$ALTERNATE_PHRASE_HASH.'" WHERE cfgname = "ALTERNATE_PHRASE_HASH" LIMIT 1');

	$cfgAutoPay				= htmlspecialchars($_POST['cfgAutoPay'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgAutoPay.'" WHERE cfgname = "cfgAutoPay" LIMIT 1');

	$cfgPMID				= htmlspecialchars($_POST['cfgPMID'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPMID.'" WHERE cfgname = "cfgPMID" LIMIT 1');

	$cfgPMpass				= htmlspecialchars($_POST['cfgPMpass'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPMpass.'" WHERE cfgname = "cfgPMpass" LIMIT 1');

	$cfgLRkey				= htmlspecialchars($_POST['cfgLRkey'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgLRkey.'" WHERE cfgname = "cfgLRkey" LIMIT 1');

	$cfgMinOut				= sprintf("%01.2f", $_POST['cfgMinOut']);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgMinOut.'" WHERE cfgname = "cfgMinOut" LIMIT 1');

	$cfgPercentOut			= sprintf("%01.2f", $_POST['cfgPercentOut']);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPercentOut.'" WHERE cfgname = "cfgPercentOut" LIMIT 1');

	$cfgLang				= htmlspecialchars($_POST['cfgLang'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgLang.'" WHERE cfgname = "cfgLang" LIMIT 1');

	$h = intval($_POST['h']);
	$i = intval($_POST['i']);
	$d = intval($_POST['d']);
	$m = intval($_POST['m']);
	$ye = intval($_POST['ye']);

	$datestart				= mktime($h,$i,0,$m,$d,$ye);
	mysql_query('UPDATE `settings` SET `data` = "'.$datestart.'" WHERE cfgname = "datestart" LIMIT 1');

	$autopercent			= htmlspecialchars($_POST['autopercent'], ENT_QUOTES);
	mysql_query('UPDATE `settings` SET `data` = "'.$autopercent.'" WHERE cfgname = "autopercent" LIMIT 1');

	print '<p class="erok">Данные сохранены!</p>';

	$cfgOutAdminPercent = sprintf("%01.2f", str_replace(',', '.', $_POST['cfgOutAdminPercent']));

	if($cfgOutAdminPercent >= 0 && $cfgOutAdminPercent <= 100) {
		mysql_query('UPDATE `settings` SET `data` = "'.$cfgOutAdminPercent.'" WHERE cfgname = "cfgOutAdminPercent" LIMIT 1');
	} else {
		print '<p class="er">Процент администратору должен быть установлен в диапазоне от 0 до 100</p>';
	}

	$AdminPMpurse			= htmlspecialchars($_POST['AdminPMpurse'], ENT_QUOTES);
	if($AdminPMpurse != $cfgPerfect) {
		mysql_query('UPDATE `settings` SET `data` = "'.$AdminPMpurse.'" WHERE cfgname = "AdminPMpurse" LIMIT 1');
	} else {
		print '<p class="er">Админский PerfectMoney кошелек, должен отличаться от кошелька приема средств</p>';
	}

	$AdminLRpurse			= htmlspecialchars($_POST['AdminLRpurse'], ENT_QUOTES);
	if($AdminLRpurse != $cfgLiberty) {
		mysql_query('UPDATE `settings` SET `data` = "'.$AdminLRpurse.'" WHERE cfgname = "AdminLRpurse" LIMIT 1');
	} else {
		print '<p class="er">Админский LibertyReserve кошелек, должен отличаться от кошелька приема средств</p>';
	}

}

?>
<script language="javascript" type="text/javascript" src="files/alt.js"></script>

 <div class="row-fluid">
          <div class="widget">
            <form class="form-horizontal" action="?a=settings&action=edit" method="post">
              <div class="widget-header">
                <h5>Настройки системы</h5>
              </div>
              <div class="widget-content no-padding">
                <div class="form-row">
                  <label class="field-name" for="standard">E-mail администратора:</label>
                  <div class="field">
                    <input type="text" class="span12" name="adminmail" id="standard" value="<?php print cfgSET('adminmail'); ?>">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name" for="password">Минимальная сумма на вывод:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgMinOut" id="password" value="<?php print cfgSET('cfgMinOut'); ?>">
                  </div>
                </div>
				<div class="form-row">
                  <label class="field-name" for="standard">Процент при выводе:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgPercentOut" id="standard" value="<?php print cfgSET('cfgPercentOut'); ?>">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name">Дата старта проекта:</label>
                  
                    <select class="uniform" style="width:100px;" name="h" title="Часы">
                      <option value="">ЧЧ</option>
                    <?php
		$datestart = cfgSET('datestart');
		for($i=0; $i<=24; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("H", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
                    </select> :
                  
               
				                
                  
                 
                    <select class="uniform" style="width:120px;" name="i" title="Минуты">
                     <option value="">MM</option>
		<?php
		for($i=0; $i<=60; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("i", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
                    </select> -
             
				            
                  
                    <select class="uniform" style="width:120px;" name="d" title="День">
                      <option value="">ДД</option>
		<?php
		for($i=0; $i<=31; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("d", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
                    </select> .
                 <select class="uniform" style="width:120px;"  name="m" title="Месяц">
                     <?php
			print '<option value="1"';
			if(intval(date("m", $datestart)) == 1) { print ' selected'; }
			print '>Январь</option>';

			print '<option value="2"';
			if(intval(date("m", $datestart)) == 2) { print ' selected'; }
			print '>Февраль</option>';

			print '<option value="3"';
			if(intval(date("m", $datestart)) == 3) { print ' selected'; }
			print '>Март</option>';

			print '<option value="4"';
			if(intval(date("m", $datestart)) == 4) { print ' selected'; }
			print '>Апрель</option>';

			print '<option value="5"';
			if(intval(date("m", $datestart)) == 5) { print ' selected'; }
			print '>Май</option>';

			print '<option value="6"';
			if(intval(date("m", $datestart)) == 6) { print ' selected'; }
			print '>Июнь</option>';

			print '<option value="7"';
			if(intval(date("m", $datestart)) == 7) { print ' selected'; }
			print '>Июль</option>';

			print '<option value="8"';
			if(intval(date("m", $datestart)) == 8) { print ' selected'; }
			print '>Август</option>';

			print '<option value="9"';
			if(intval(date("m", $datestart)) == 9) { print ' selected'; }
			print '>Сентябрь</option>';

			print '<option value="10"';
			if(intval(date("m", $datestart)) == 10) { print ' selected'; }
			print '>Октябрь</option>';

			print '<option value="11"';
			if(intval(date("m", $datestart)) == 11) { print ' selected'; }
			print '>Ноябрь</option>';

			print '<option value="12"';
			if(intval(date("m", $datestart)) == 12) { print ' selected'; }
			print '>Декабрь</option>';
		?>	
                    </select> .
					<select class="uniform" style="width:120px;" name="ye" title="Год">
                      <option value="">ГГГГ</option>
		<?php
		for($i=2012; $i<=date(Y); $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("Y", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
                    </select>
                

               
                     <div class="form-row">
                  <label class="field-name">Язык:</label>
                  <div class="field">
                    <input type="radio" name="cfgLang" value="ru" <?php if(cfgSET('cfgLang') == "ru") { print ' checked="checked"'; } ?> /> Русский ||
                    <input type="radio" name="cfgLang" value="en" <?php if(cfgSET('cfgLang') == "en") { print ' checked="checked"'; } ?> /> Английский
                    
                  </div>
                </div>
				
				                   <div class="form-row">
                  <label class="field-name">Начисление процентов:</label>
                  <div class="field">
                    <input type="radio" name="autopercent" value="on" <?php if(cfgSET('autopercent') == "on") { print ' checked="checked"'; } ?> /> Включить ||
                    <input type="radio" name="autopercent" value="off" <?php if(cfgSET('autopercent') == "off") { print ' checked="checked"'; } ?> /> ВЫключить
                    
                  </div>
                </div>
                  
                











<div class="widget-header">
                <h5>НАСТРОЙКА ПРИЕМА ОПЛАТЫ</h5>
              </div>






                <div class="form-row">
                  <label class="field-name" for="standard">PerfectMoney счет:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgPerfect" id="standard" value="<?php print cfgSET('cfgPerfect'); ?>">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name" for="password">Альтернативный пароль:</label>
                  <div class="field">
                    <input type="text" class="span12" name="ALTERNATE_PHRASE_HASH" id="password" value="<?php print cfgSET('ALTERNATE_PHRASE_HASH'); ?>">
                  </div>
                </div>
				<div class="form-row">
                  <label class="field-name" for="standard">Store name:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgPAYEE_NAME" id="standard" value="<?php print cfgSET('cfgPAYEE_NAME'); ?>">
                  </div>
                </div>


                <div class="form-row">
                  <label class="field-name" for="standard">LibertyReserve счет:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgLiberty" id="standard" value="<?php print cfgSET('cfgLiberty'); ?>">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name" for="password">Security Word:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgLRsecword" id="password" value="<?php print cfgSET('cfgLRsecword'); ?>">
                  </div>
                </div>







<div class="widget-header">
                <h5>НАСТРОЙКА АВТОМАТИЧЕСКИХ ВЫПЛАТ ( API )</h5>
              </div>

   <div class="form-row">
                  <label class="field-name">Автовыплаты:</label>
                  <div class="field">
                    <input type="radio" name="cfgAutoPay" value="on" <?php if(cfgSET('cfgAutoPay') == "on") { print ' checked="checked"'; } ?> /> Включить ||
                    <input type="radio" name="cfgAutoPay" value="off" <?php if(cfgSET('cfgAutoPay') == "off") { print ' checked="checked"'; } ?> /> ВЫключить
                    
                  </div>
                </div>
   
   
                <div class="form-row">
                  <label class="field-name" for="standard">Ваш ID в PerfectMoney:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgPMID" id="standard" value="<?php print cfgSET('cfgPMID'); ?>">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name" for="password">Ваш пароль в PerfectMoney:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgPMpass" id="password" value="<?php print cfgSET('cfgPMpass'); ?>">
                  </div>
                </div>
				
				<div class="form-row">
                  <label class="field-name" for="standard">API Security Word в LibertyReserve:</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgLRkey" id="standard" value="<?php print cfgSET('cfgLRkey'); ?>">
                  </div>
                </div>
              
   
   



<div class="widget-header">
                <h5>НАСТРОЙКА АВТОПЕРЕВОДА НА АДМИНСКИЕ КОШЕЛЬКИ</h5>
              </div>

<div class="form-row">
                  <label class="field-name" for="password">Процент от суммы пополнения - админу</label>
                  <div class="field">
                    <input type="text" class="span12" name="cfgOutAdminPercent" id="password" value="<?php print cfgSET('cfgOutAdminPercent'); ?>">
                  </div>
                </div>
				
				<div class="form-row">
                  <label class="field-name" for="standard">Админский PerfectMoney счет:</label>
                  <div class="field">
                    <input type="text" class="span12" name="AdminPMpurse" id="standard" value="<?php print cfgSET('AdminPMpurse'); ?>">
                  </div>
                </div>
                <div class="form-row">
                  <label class="field-name" for="password">Админский LibertyReserve счет:</label>
                  <div class="field">
                    <input type="text" class="span12" name="AdminLRpurse" id="password" value="<?php print cfgSET('AdminLRpurse'); ?>">
                  </div>
                </div>
			  
			  
			   <div class="form-row" align="right">
                  <input type="submit" name="submit" class="button large-button button-green" value="Сохранить">
                 
                </div>






              </div>
            </form>
          </div>
        </div>