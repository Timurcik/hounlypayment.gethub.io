<?php
include "cfg.php";
$ALTERNATE_PHRASE_HASH_NO_HASH="t0E4Q6i83ZXmGeQKyZfphtGhX";
$ALTERNATE_PHRASE_HASH = strtoupper(md5($ALTERNATE_PHRASE_HASH_NO_HASH));

$string = $_REQUEST['PAYMENT_ID'].':'.$_REQUEST['PAYEE_ACCOUNT'].':'.$_REQUEST['PAYMENT_AMOUNT'].':'.$_REQUEST['PAYMENT_UNITS'].':'.$_REQUEST['PAYMENT_BATCH_NUM'].':'.$_REQUEST['PAYER_ACCOUNT'].':'.$ALTERNATE_PHRASE_HASH.':'.$_REQUEST['TIMESTAMPGMT'];

$hash = strtoupper(md5($string));



/*
$restoremail='sirgoffan@mail.ru';
	$subject = "Восстановление пароля в ";
	$message = 'Ваш код восстановления: <br>'.$hash.'<br>req - '.$_REQUEST['V2_HASH'].'<br>post - '.$_POST['V2_HASH'].'<br>get - '.$_GET['V2_HASH'].'Или используйте ссылку: '.$secretlinkk.' ';

	$headers = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "From: admin@weboption.ru \r\n";
	mail($restoremail, $subject, $message, $headers);
	
	
	$subject = "Восстановление пароля 2";
	$message = $_REQUEST['PAYMENT_ID'].':'.$_REQUEST['PAYEE_ACCOUNT'].':'.$_REQUEST['PAYMENT_AMOUNT'].':'.$_REQUEST['PAYMENT_UNITS'].':'.$_REQUEST['PAYMENT_BATCH_NUM'].':'.$_REQUEST['PAYER_ACCOUNT'].':'.$ALTERNATE_PHRASE_HASH.':'.$_REQUEST['TIMESTAMPGMT'];

	$headers = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "From: admin@weboption.ru \r\n";
	mail($restoremail, $subject, $message, $headers);	
*/	
	
if($hash==$_REQUEST['V2_HASH']) {



	$query	= "SELECT * FROM enter WHERE id = ".intval($_REQUEST['PAYMENT_ID'])." LIMIT 1";
	$result	= mysql_query($query);
	$row	= mysql_fetch_array($result);
	if($row['id']) {

		if(sprintf("%01.2f", $_REQUEST['PAYMENT_AMOUNT'])==$row['sum'] && $_REQUEST['PAYEE_ACCOUNT']==$cfgPerfect && $_REQUEST['PAYMENT_UNITS']=='USD'){

			mysql_query('UPDATE users SET pm_balance = pm_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1');
			mysql_query("UPDATE enter SET status = 2, purse = '".htmlspecialchars($_REQUEST['PAYER_ACCOUNT'], ENT_QUOTES)."', paysys = 'PM' WHERE id = ".intval($_REQUEST['PAYMENT_ID'])." LIMIT 1");

			// Отправляем деньги админу если нужно
			if(cfgSET('cfgOutAdminPercent') != 0 && cfgSET('AdminPMpurse')) {
				$sum	= sprintf ("%01.2f", $row['sum'] / 100 * cfgSET('cfgOutAdminPercent'));
				fopen('https://perfectmoney.com/acct/confirm.asp?AccountID='.$cfgPMID.'&PassPhrase='.$cfgPMpass.'&Payer_Account='.$cfgPerfect.'&Payee_Account='.cfgSET('AdminPMpurse').'&Amount='.$sum.'&PAY_IN=1&PAYMENT_ID='.rand(100000,999999).'&Memo='.$cfgURL, 'rb');
			}

		} else {
			print "ERROR";
			mail($adminmail, "Status", "Не те данные");
		}

	} else {
		print "ERROR";
		mail($adminmail, "Status", "Нет записи в БД".$_REQUEST['PAYMENT_ID']);
	}

} else {
	print "ERROR";
	mail($adminmail, "Status", "Не прошёл хеш");
}
?>