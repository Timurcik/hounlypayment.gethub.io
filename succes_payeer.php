<?php
include "cfg.php";
if (isset($_POST["m_operation_id"]) && isset($_POST["m_sign"]))
{
	$m_key = "rktdth";
	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);
	$sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));
	if ($_POST["m_sign"] == $sign_hash && $_POST['m_status'] == "success")
	{
	
	$query	= "SELECT * FROM enter WHERE id = ".intval($_POST['m_orderid'])." LIMIT 1";
	$result	= mysql_query($query);
	$row	= mysql_fetch_array($result);
		mysql_query('UPDATE users SET lr_balance = lr_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1');
		mysql_query("UPDATE enter SET status = 2, paysys = 'Payeer' WHERE id = ".intval($_POST['m_orderid'])." LIMIT 1");
		echo $_POST['m_orderid']."|success"; 
		exit;
	}
	echo $_POST['m_orderid']."|error";
}



?>