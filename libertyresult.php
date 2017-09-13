<?php
include "cfg.php";

$conf_merchantAccountNumber	= $cfgLiberty;			// enter your account
$conf_merchantStoreName		= $cfgPAYEE_NAME;		// enter the name of your store
$conf_merchantSecurityWord	= $cfgLRsecword;		// Your store's security word
$conf_merchantEmail			= $adminmail;			// Your e-mail

$str = 
  $_REQUEST["lr_paidto"].":".
  $_REQUEST["lr_paidby"].":".
  stripslashes($_REQUEST["lr_store"]).":".
  $_REQUEST["lr_amnt"].":".
  $_REQUEST["lr_transfer"].":".
  $_REQUEST["lr_currency"].":".
  $conf_merchantSecurityWord;

$hash = strtoupper(bin2hex(mhash(MHASH_SHA256, $str)));

if (isset($_REQUEST["lr_paidto"]) &&  
    $_REQUEST["lr_paidto"] == strtoupper($conf_merchantAccountNumber) &&
    isset($_REQUEST["lr_store"]) && 
    stripslashes($_REQUEST["lr_store"]) == $conf_merchantStoreName &&
    isset($_REQUEST["lr_encrypted"]) &&
    $_REQUEST["lr_encrypted"] == $hash) {


					$query	= "SELECT * FROM enter WHERE id = ".intval($_REQUEST["item_name"])." AND sum = ".htmlspecialchars($_REQUEST["lr_amnt"], ENT_QUOTES)." LIMIT 1";
					$result	= mysql_query($query);
					$rows	= mysql_num_rows($result);
					if($rows == 1) {
						$date = date("d.m.Y");

						$row = mysql_fetch_array($result);
						mysql_query('UPDATE users SET lr_balance = lr_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1');
						mysql_query("UPDATE enter SET status = 2, purse = '".htmlspecialchars($_REQUEST["lr_paidby"], ENT_QUOTES)."', paysys = 'LR' WHERE id = ".intval($_REQUEST["item_name"])." LIMIT 1");

						// Отправляем деньги админу если нужно
						if(cfgSET('cfgOutAdminPercent') != 0 && cfgSET('AdminLRpurse')) {
							$sum	= sprintf ("%01.2f", $row['sum'] / 100 * cfgSET('cfgOutAdminPercent'));
							$purse	= cfgSET('AdminLRpurse');
							include "withdrawal/TransferSample.php";
						}

					} else {
						print 'Deposit Error!';
					}



	$msgBody = "Payment was verified and is successful.\n\n";
} else {
	$msgBody = "Invalid response. Sent hash didn't match the computed hash.\n";
}

$msgBody .= "Received data\n";
$reqKeys = array_keys ($_REQUEST);
foreach($reqKeys as &$key) {
	$msgBody .= $key." = ".$_REQUEST[$key].(ereg("^lr_[a-z_]*$", $key) ? " (LR)" : "")."\n";
}

if ($conf_merchantEmail != "") {
	mail($conf_merchantEmail, "LR SCI Status", $msgBody);
}
?>